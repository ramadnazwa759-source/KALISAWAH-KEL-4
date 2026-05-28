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
use App\Models\KategoriPaket;
use App\Models\KategoriFasilitas;

class PengunjungBookingController extends Controller
{
    // --- 1. Fungsi Form & Helper ---
    public function showForm(Request $request)
    {
        return view('pengunjung.booking.booking-form', [
            'kategoriPaket' => KategoriPaket::all(),
            'paket' => PaketWisata::with('kategori')->where('status', 'aktif')->get(),
            'kategoriFasilitas' => KategoriFasilitas::all(),
            'fasilitas' => Fasilitas::with('kategori')->where('tipe_fasilitas', 'sewa')->where('stok', '>', 0)->get(),
        ]);
    }

    public function getPaketByKategori($id)
    {
        $paket = PaketWisata::where('kategori_paket_id', $id)->where('status', 'aktif')->get();
        return response()->json($paket);
    }

    public function getFasilitasByKategori($kategoriId)
    {
        $fasilitas = Fasilitas::where('kategori_fasilitas_id', $kategoriId)
                                ->where('tipe_fasilitas', 'sewa')
                                ->where('stok', '>', 0)
                                ->get();
        return response()->json($fasilitas);
    }

    // --- 2. FUNGSI BARU UNTUK ALUR PREVIEW -> KONFIRMASI ---

    public function review(Request $request)
    {
        $request->validate([
            'nama_pemesan' => 'required|string|max:255',
            'no_hp' => 'required|string|min:9|max:20',
            'tanggal_kunjungan' => 'required|date|after_or_equal:today',
            'jam' => 'required',
            'jumlah_pengunjung' => 'required|integer|min:1',
            'paket' => 'required|array|min:1',
        ]);

        // Simpan input sementara ke session
        session(['temp_booking_data' => $request->all()]);

        // Hitung data untuk preview (tapi belum simpan ke DB)
        $data = $this->calculateBookingData($request);

        return view('pengunjung.booking.booking-detail', [
            'booking' => (object) $data,
            'is_preview' => true
        ]);
    }

    public function confirmStore(Request $request)
    {
        $input = session('temp_booking_data');
        if (!$input) {
            return redirect()->route('pengunjung.booking.showForm')->with('error', 'Sesi habis, silakan isi ulang.');
        }

        // Jalankan logika penyimpanan yang sama dengan logic store sebelumnya
        try {
            $booking = DB::transaction(function() use ($input) {
                // Logic ini diambil dari store lama Anda
                $requestObj = new Request($input);
                
                $kodeBooking = 'BK-' . strtoupper(Str::random(8));
                $jumlahHariMenginap = $requestObj->filled('jumlah_hari') ? intval($requestObj->jumlah_hari) : 1;
                $tanggalKunjungan = Carbon::parse($requestObj->tanggal_kunjungan);
                $tanggalPulang = $tanggalKunjungan->copy()->addDays($jumlahHariMenginap);

                $subtotalPaket = 0; $subtotalFasilitas = 0; $totalTiketTambahan = 0; $subtotalTiketTambahan = 0;
                $validPakets = [];

                foreach ($input['paket'] as $hari => $paketIds) {
                    foreach ($paketIds as $paketId) {
                        $paket = PaketWisata::findOrFail($paketId);
                        $subtotalPaket += $paket->harga;
                        $validPakets[] = ['model' => $paket, 'qty' => 1, 'hari' => $hari, 'tanggal' => $tanggalKunjungan->copy()->addDays((int)$hari - 1)->toDateString(), 'harga' => $paket->harga, 'subtotal' => $paket->harga];
                    }
                }

                $validFasilitas = [];
                if (isset($input['fasilitas'])) {
                    foreach ($input['fasilitas'] as $fasilitasId => $qty) {
                        $qty = intval($qty);
                        if ($qty > 0) {
                            $fasilitas = Fasilitas::findOrFail($fasilitasId);
                            $fasilitas->decrement('stok', $qty);
                            $hargaTotal = $fasilitas->harga * $qty * $jumlahHariMenginap;
                            $subtotalFasilitas += $hargaTotal;
                            $validFasilitas[] = ['model' => $fasilitas, 'qty' => $qty, 'tanggal' => $tanggalKunjungan->toDateString(), 'harga' => $fasilitas->harga, 'subtotal' => $hargaTotal];
                        }
                    }
                }

                $bookingRecord = Booking::create([
                    'kode_booking' => $kodeBooking,
                    'nama_pemesan' => strip_tags($input['nama_pemesan']),
                    'no_hp' => strip_tags($input['no_hp']),
                    'tanggal_kunjungan' => $input['tanggal_kunjungan'],
                    'tanggal_selesai' => $tanggalPulang->toDateString(),
                    'jumlah_malam' => $jumlahHariMenginap,
                    'jam' => $input['jam'],
                    'jumlah_pengunjung' => $input['jumlah_pengunjung'],
                    'total_harga' => ($subtotalPaket + $subtotalFasilitas),
                    'total_harga_final' => ($subtotalPaket + $subtotalFasilitas),
                    'status_booking' => 'pending',
                    'status_pembayaran' => 'belum_bayar'
                ]);

                foreach ($validPakets as $p) {
                    BookingItem::create(['booking_id' => $bookingRecord->id, 'paket_wisata_id' => $p['model']->id, 'qty' => $p['qty'], 'hari' => $p['hari'], 'tanggal' => $p['tanggal'], 'harga' => $p['harga'], 'subtotal' => $p['subtotal']]);
                }
                foreach ($validFasilitas as $f) {
                    BookingFasilitas::create(['booking_id' => $bookingRecord->id, 'fasilitas_id' => $f['model']->id, 'qty' => $f['qty'], 'tanggal' => $f['tanggal'], 'harga' => $f['harga'], 'subtotal' => $f['subtotal']]);
                }
                return $bookingRecord;
            });

            session()->forget('temp_booking_data');
            return redirect()->route('pengunjung.booking.showPayment', $booking->id);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    private function calculateBookingData($request)
    {
        // Fungsi helper untuk menghitung data sebelum masuk DB (untuk tampilan preview)
        return [
            'nama_pemesan' => $request->nama_pemesan,
            'no_hp' => $request->no_hp,
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'jam' => $request->jam,
            'jumlah_pengunjung' => $request->jumlah_pengunjung,
            // Logic perhitungan lain bisa ditambah di sini
        ];
    }

    // --- 3. FUNGSI LAMA (JANGAN DIHAPUS) ---

    public function update(Request $request, $id) 
    {
        DB::beginTransaction();
        try {
            $booking = Booking::findOrFail($id);
            $booking->update([
                'nama_pemesan' => $request->nama_pemesan,
                'no_hp' => $request->no_hp,
                'tanggal_kunjungan' => $request->tanggal_kunjungan,
                'jam' => $request->jam,
                'jumlah_malam' => $request->jumlah_hari,
                'jumlah_pengunjung' => $request->jumlah_pengunjung,
            ]);

            $booking->items()->delete();
            if ($request->has('paket')) {
                foreach ($request->paket as $hari => $paketIds) {
                    foreach ($paketIds as $paketId) {
                        $qty = $request->paket_qty[$hari][$paketId] ?? 1;
                        $paket = PaketWisata::find($paketId);
                        $booking->items()->create(['hari' => $hari, 'paket_wisata_id' => $paketId, 'qty' => $qty, 'harga' => $paket->harga, 'subtotal' => $paket->harga * $qty]);
                    }
                }
            }

            $booking->fasilitas()->delete();
            if ($request->has('fasilitas')) {
                foreach ($request->fasilitas as $fasId => $qty) {
                    if ($qty > 0) {
                        $fas = Fasilitas::find($fasId);
                        $booking->fasilitas()->create(['fasilitas_id' => $fasId, 'qty' => $qty, 'harga' => $fas->harga, 'subtotal' => $fas->harga * $qty]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('pengunjung.booking.booking-detail', $id)->with('success', 'Data berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function showDetail($id) {
        $booking = Booking::with(['items.paketWisata', 'fasilitas.fasilitas'])->findOrFail($id);
        return view('pengunjung.booking.booking-detail', compact('booking'));
    }

    public function showPayment($id) {
        $booking = Booking::findOrFail($id);
        return view('pengunjung.booking.booking-payment', compact('booking'));
    }

    public function edit($id) {
        $booking = Booking::with(['items', 'fasilitas'])->findOrFail($id);
        if ($booking->status_pembayaran !== 'belum_bayar') return redirect()->back()->with('error', 'Tidak bisa diubah.');
        return view('pengunjung.booking.booking-form', [
            'booking' => $booking,
            'kategoriPaket' => KategoriPaket::all(),
            'paket' => PaketWisata::with('kategori')->where('status', 'aktif')->get(),
            'kategoriFasilitas' => KategoriFasilitas::all(),
            'fasilitas' => Fasilitas::with('kategori')->where('tipe_fasilitas', 'sewa')->get(),
        ]);
    }

    public function updatePaymentMethod(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['status_pembayaran' => $request->tipe_pembayaran, 'catatan' => $booking->catatan . " | Metode: " . strip_tags($request->metode_pembayaran)]);
        return redirect()->route('pengunjung.booking.booking-success', ['id' => $booking->id]);
    }

    public function showSuccess($id)
    {
        $booking = Booking::findOrFail($id);
        return view('pengunjung.booking.booking-success', compact('booking'));
    }

    public function uploadBukti(Request $request, $id)
    {
        $request->validate(['bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048']);
        $booking = Booking::findOrFail($id);
        if ($request->hasFile('bukti_pembayaran')) {
            $filename = 'BUKTI-' . $booking->kode_booking . '-' . time() . '.' . $request->file('bukti_pembayaran')->getClientOriginalExtension();
            $request->file('bukti_pembayaran')->storeAs('public/bukti_pembayaran', $filename);
            $booking->update(['catatan' => $booking->catatan . " | Bukti terupload: " . $filename]);
            return redirect()->back()->with('success', 'Bukti berhasil diunggah.');
        }
        return redirect()->back()->with('error', 'Gagal.');
    }

    public function create()
    {
        return view('pengunjung.booking.booking-form', [
            'kategoriPaket' => KategoriPaket::all(),
            'paket' => PaketWisata::with('kategori')->where('status', 'aktif')->get(),
            'kategoriFasilitas' => KategoriFasilitas::all(),
            'fasilitas' => Fasilitas::with('kategoriFasilitas')->where('tipe_fasilitas', 'sewa')->where('stok', '>', 0)->get(),
        ]);
    }
}