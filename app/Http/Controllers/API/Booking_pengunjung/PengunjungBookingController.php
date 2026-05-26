<?php

namespace App\Http\Controllers\API\Booking_pengunjung;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Booking;
use App\Models\BookingItem;
use App\Models\BookingFasilitas;
use App\Models\PaketWisata;
use App\Models\Fasilitas;
use App\Models\Kategori; 

class PengunjungBookingController extends Controller
{
    // STEP 1 & 2: Menampilkan Form Booking Utama
    public function showForm(Request $request)
    {
        $paketId = $request->query('paket');
        $selectedPaket = $paketId ? PaketWisata::with('kategori')->find($paketId) : null;

        // Ambil semua kategori untuk dropdown pencarian paket & fasilitas
        $allKategori = Kategori::all();

        return view('pengunjung.booking.form', [
            'selectedPaket' => $selectedPaket,
            'allKategori' => $allKategori,
        ]);
    }

    // API INTERNAL 1: Ambil Paket berdasarkan Kategori (Dinamis lewat JavaScript)
    public function getPaketByKategori($kategoriId)
    {
        $pakets = PaketWisata::where('kategori_id', $kategoriId)
                             ->where('status', 'aktif')
                             ->get();

        return response()->json($pakets);
    }

    // API INTERNAL 2: Ambil Fasilitas BER-TIPE SEWA & STOK > 0 berdasarkan Kategori
    public function getFasilitasByKategori($kategoriId)
    {
        // Catatan: Pastikan di tabel fasilitas kamu ada kolom 'kategori_id' atau relasi ke kategori
        $fasilitas = Fasilitas::where('kategori_id', $kategoriId)
                              ->where('tipe_fasilitas', 'sewa')
                              ->where('stok', '>', 0)
                              ->get();

        return response()->json($fasilitas);
    }

    // PROSES STEP 2: Validasi Aman & Perhitungan Otomatis di Back-end
    public function store(Request $request)
    {
        $request->validate([
            'nama_pemesan' => 'required|string|max:255',
            'no_hp' => 'required|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:9|max:20',
            'tanggal_kunjungan' => 'required|date|after_or_equal:today',
            'jumlah_hari' => 'required|integer|min:1|max:30',
            'jam' => 'required|date_format:H:i',
            'jumlah_pengunjung' => 'required|integer|min:1',
            'paket' => 'required|array|min:1',
            'paket.*.selected' => 'nullable|in:1',
            'paket.*.qty' => 'nullable|integer|min:0',
            'fasilitas' => 'nullable|array',
            'fasilitas.*.qty' => 'nullable|integer|min:0',
            'catatan' => 'nullable|string|max:1000'
        ]);

        try {
            $booking = DB::transaction(function() use ($request) {
                $kodeBooking = 'BK-' . strtoupper(Str::random(8));
                
                $jumlahHariMenginap = intval($request->jumlah_hari);
                $tanggalKunjungan = Carbon::parse($request->tanggal_kunjungan);
                $tanggalPulang = $tanggalKunjungan->copy()->addDays($jumlahHariMenginap);

                $subtotalPaket = 0;
                $subtotalFasilitas = 0;
                $totalKapasitas = 0;

                $validPakets = [];
                foreach ($request->paket as $paketId => $data) {
                    if (isset($data['selected']) && $data['selected'] == '1') {
                        $qty = isset($data['qty']) ? intval($data['qty']) : 0;
                        if ($qty > 0) {
                            $paket = PaketWisata::with('kategori')->findOrFail($paketId);
                            
                            $isCamping = ($paket->kategori && strtolower($paket->kategori->nama_kategori) === 'camping');
                            $pengaliHari = $isCamping ? $jumlahHariMenginap : 1;

                            $hargaPaketTotal = $paket->harga * $qty * $pengaliHari;
                            $subtotalPaket += $hargaPaketTotal;
                            $totalKapasitas += $paket->kapasitas * $qty;
                            
                            $validPakets[] = [
                                'model' => $paket,
                                'qty' => $qty,
                                'harga' => $paket->harga,
                                'subtotal' => $hargaPaketTotal
                            ];
                        }
                    }
                }

                if (empty($validPakets)) {
                    throw new \Exception("Anda harus memilih minimal satu paket wisata.");
                }

                $jumlahTiketTambahan = 0;
                $subtotalTiketTambahan = 0;
                if ($request->jumlah_pengunjung > $totalKapasitas) {
                    $jumlahTiketTambahan = $request->jumlah_pengunjung - $totalKapasitas;
                    $subtotalTiketTambahan = $jumlahTiketTambahan * 25000 * $jumlahHariMenginap; 
                }

                $validFasilitas = [];
                if ($request->fasilitas) {
                    foreach ($request->fasilitas as $fasilitasId => $data) {
                        $qty = isset($data['qty']) ? intval($data['qty']) : 0;
                        if ($qty > 0) {
                            $fasilitas = Fasilitas::where('id', $fasilitasId)->lockForUpdate()->firstOrFail();

                            if ($fasilitas->tipe_fasilitas == 'sewa') {
                                if ($qty > $fasilitas->stok) {
                                    throw new \Exception("Stok fasilitas {$fasilitas->nama_fasilitas} tidak mencukupi. Sisa stok: {$fasilitas->stok}");
                                }
                                $fasilitas->decrement('stok', $qty);
                            }

                            $hargaFasilitasTotal = $fasilitas->harga * $qty * $jumlahHariMenginap;
                            $subtotalFasilitas += $hargaFasilitasTotal;

                            $validFasilitas[] = [
                                'model' => $fasilitas,
                                'qty' => $qty,
                                'harga' => $fasilitas->harga,
                                'subtotal' => $hargaFasilitasTotal
                            ];
                        }
                    }
                }

                $totalHarga = $subtotalPaket + $subtotalFasilitas + $subtotalTiketTambahan;

                $bookingRecord = Booking::create([
                    'kode_booking' => $kodeBooking,
                    'nama_pemesan' => strip_tags($request->nama_pemesan),
                    'no_hp' => strip_tags($request->no_hp),
                    'tanggal_kunjungan' => $request->tanggal_kunjungan,
                    'tanggal_pulang' => $tanggalPulang->toDateString(),
                    'jumlah_hari' => $jumlahHariMenginap,
                    'jam' => $request->jam,
                    'jumlah_pengunjung' => $request->jumlah_pengunjung,
                    'jumlah_tiket_tambahan' => $jumlahTiketTambahan,
                    'harga_tiket_tambahan' => 25000,
                    'subtotal_tiket_tambahan' => $subtotalTiketTambahan,
                    'catatan' => strip_tags($request->catatan),
                    'total_harga' => $totalHarga,
                    'diskon_manual' => 0,
                    'total_harga_final' => $totalHarga,
                    'status_booking' => 'pending',
                    'status_pembayaran' => 'belum_bayar'
                ]);

                foreach ($validPakets as $p) {
                    BookingItem::create([
                        'booking_id' => $bookingRecord->id,
                        'paket_wisata_id' => $p['model']->id,
                        'qty' => $p['qty'],
                        'harga' => $p['harga'],
                        'subtotal' => $p['subtotal']
                    ]);
                }

                foreach ($validFasilitas as $f) {
                    BookingFasilitas::create([
                        'booking_id' => $bookingRecord->id,
                        'fasilitas_id' => $f['model']->id,
                        'qty' => $f['qty'],
                        'harga' => $f['harga'],
                        'subtotal' => $f['subtotal']
                    ]);
                }

                return $bookingRecord;
            });

            return redirect()->route('booking.detail', ['id' => $booking->id]);

        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    // STEP 3: Menampilkan Rincian Lengkap Hasil Kalkulasi
    public function showDetail($id)
    {
        $booking = Booking::with(['items.paketWisata', 'fasilitas.fasilitas'])->findOrFail($id);
        return view('pengunjung.booking.detail', compact('booking'));
    }

    // STEP 4: Menampilkan Form Pilihan Tipe Pembayaran (DP/Lunas) & Metode Bayar
    public function showPayment($id)
    {
        $booking = Booking::findOrFail($id);
        return view('pengunjung.booking.payment', compact('booking'));
    }

    // PROSES STEP 4: Update Pilihan Metode Pembayaran
    public function updatePaymentMethod(Request $request, $id)
    {
        $request->validate([
            'tipe_pembayaran' => 'required|in:dp,lunas',
            'metode_pembayaran' => 'required|string'
        ]);

        $booking = Booking::findOrFail($id);
        
        $booking->update([
            'status_pembayaran' => $request->tipe_pembayaran,
            'catatan' => $booking->catatan . " | Metode: " . strip_tags($request->metode_pembayaran)
        ]);

        return redirect()->route('booking.success', ['id' => $booking->id]);
    }

    // STEP 5: Tampilan Sukses 
    public function showSuccess($id)
    {
        $booking = Booking::findOrFail($id);
        return view('pengunjung.booking.success', compact('booking'));
    }

    // PROSES STEP 5: Unggah Bukti Transfer
    public function uploadBukti(Request $request, $id)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $booking = Booking::findOrFail($id);

        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $filename = 'BUKTI-' . $booking->kode_booking . '-' . time() . '.' . $file->getClientOriginalExtension();
            
            $file->storeAs('public/bukti_pembayaran', $filename);

            $booking->update([
                'catatan' => $booking->catatan . " | Bukti terupload: " . $filename
            ]);

            return redirect()->back()->with('success', 'Bukti pembayaran berhasil diunggah! Tunggu konfirmasi status dari Admin.');
        }

        return redirect()->back()->with('error', 'Gagal mengunggah file.');
    }
}