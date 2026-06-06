<?php

namespace App\Http\Controllers\API\Kelola_booking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\Models\Booking;
use App\Models\BookingItem;
use App\Models\BookingFasilitas;
use App\Models\Fasilitas;
use App\Models\Pembayaran;
use App\Models\PaketWisata;

class AdminBookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['items.paketWisata', 'fasilitas.fasilitas', 'pembayaran'])->latest();

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_kunjungan', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_kunjungan', $request->tahun);
        } else {
            $query->whereYear('tanggal_kunjungan', date('Y'));
        }

        $data = $query->get();

        $fasilitasList = Fasilitas::where('tipe_fasilitas', 'sewa')->get();
        $paketList = PaketWisata::all();

        $groupedFasilitas = [];
        foreach ($fasilitasList as $f) {
            $katName = $this->parseKategoriName($f->kategori);
            $groupedFasilitas[$katName][] = $f;
        }

        $groupedPaket = [
            'Semua Paket' => []
        ];
        
        foreach ($paketList as $p) {
            $katName = $this->parseKategoriName($p->kategori);
            $groupedPaket['Semua Paket'][] = $p;
            if ($katName !== 'Semua Paket') {
                $groupedPaket[$katName][] = $p;
            }
        }

        return view('admin.kelola_booking.index', compact('data', 'groupedFasilitas', 'groupedPaket'));
    }

    private function parseKategoriName($kategori)
    {
        if (empty($kategori)) return 'Semua Paket';
        
        if (is_object($kategori)) {
            return $kategori->nama_kategori ?? $kategori->NAMA_KATEGORI ?? 'Semua Paket';
        }
        
        if (is_array($kategori)) {
            return $kategori['NAMA_KATEGORI'] ?? $kategori['nama_kategori'] ?? 'Semua Paket';
        }
        
        if (is_string($kategori)) {
            $dec = json_decode(html_entity_decode($kategori), true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($dec)) {
                return $dec['NAMA_KATEGORI'] ?? $dec['nama_kategori'] ?? 'Semua Paket';
            }
            if (preg_match('/"NAMA_KATEGORI"\s*:\s*"([^"]+)"/i', $kategori, $matches) || preg_match('/"nama_kategori"\s*:\s*"([^"]+)"/i', $kategori, $matches)) {
                return $matches[1];
            }
            if (strtoupper($kategori) === 'UMUM') {
                return 'Semua Paket';
            }
            return $kategori;
        }
        
        return 'Semua Paket';
    }

    public function show($id)
    {
        $booking = Booking::with(['items.paketWisata', 'fasilitas.fasilitas', 'pembayaran'])->findOrFail($id);
        return view('admin.kelola_booking.show', compact('booking'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $booking = Booking::create([
                'kode_booking' => 'BK-' . time(),
                'nama_pemesan' => $request->nama_pemesan,
                'no_hp' => $request->no_hp,
                'tanggal_kunjungan' => $request->tanggal_kunjungan,
                'tanggal_selesai' => $request->tanggal_selesai,
                'jam' => $request->jam,
                'jumlah_pengunjung' => $request->jumlah_pengunjung,
                'catatan' => $request->catatan,
                'jumlah_malam' => $request->jumlah_malam,
                'total_harga' => round($request->total_harga),
                'total_harga_final' => round($request->total_harga_final),
                'diskon_manual' => round($request->diskon_manual ?? 0),
                'jumlah_tiket_tambahan' => $request->jumlah_tiket_tambahan ?? 0,
                'subtotal_tiket_tambahan' => round($request->subtotal_tiket_tambahan ?? 0),
                'status_booking' => 'pending'
            ]);

            $buktiPath = null;
            if ($request->hasFile('bukti_pembayaran')) {
                $buktiPath = $request->file('bukti_pembayaran')->store('pembayaran_dp', 'local');
            }

            Pembayaran::create([
                'booking_id' => $booking->id,
                'tipe_pembayaran' => $request->tipe_pembayaran,
                'metode_pembayaran' => $request->metode_pembayaran,
                'nominal' => round($request->nominal),
                'bukti_pembayaran' => $buktiPath,
                'tanggal_pembayaran' => now()
            ]);

            if ($request->has('paket')) {
                foreach ($request->paket as $p) {
                    $tanggal = \Carbon\Carbon::parse($request->tanggal_kunjungan)
                                ->addDays($p['hari'] - 1)
                                ->format('Y-m-d');
                    
                    $subtotal = round($p['qty'] * $p['harga']);

                    BookingItem::create([
                        'booking_id' => $booking->id,
                        'paket_wisata_id' => $p['paket_wisata_id'],
                        'hari' => $p['hari'],
                        'tanggal' => $tanggal,
                        'qty' => $p['qty'],
                        'harga' => round($p['harga']),
                        'subtotal' => $subtotal,
                    ]);
                }
            }

            if ($request->has('fasilitas')) {
                $jumlah_malam = $request->jumlah_malam > 0 ? $request->jumlah_malam : 1;
                
                foreach ($request->fasilitas as $f) {
                    for ($i = 1; $i <= $jumlah_malam; $i++) {
                        $tanggal = \Carbon\Carbon::parse($request->tanggal_kunjungan)
                                    ->addDays($i - 1)
                                    ->format('Y-m-d');
                        
                        $subtotal = round($f['qty'] * $f['harga']);

                        BookingFasilitas::create([
                            'booking_id' => $booking->id,
                            'fasilitas_id' => $f['fasilitas_id'],
                            'hari' => $i,
                            'tanggal' => $tanggal,
                            'qty' => $f['qty'],
                            'harga' => round($f['harga']),
                            'subtotal' => $subtotal,
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect('/admin/booking-admin')->with('success', 'Data booking berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $totalAwal = round($booking->total_harga);
        $diskonBaru = round($request->diskon_manual ?? $booking->diskon_manual);
        $hargaFinalBaru = $totalAwal - $diskonBaru;

        if ($hargaFinalBaru < 0) {
            $hargaFinalBaru = 0;
        }

        $booking->update([
            'nama_pemesan' => $request->nama_pemesan ?? $booking->nama_pemesan,
            'no_hp' => $request->no_hp ?? $booking->no_hp,
            'tanggal_kunjungan' => $request->tanggal_kunjungan ?? $booking->tanggal_kunjungan,
            'tanggal_selesai' => $request->tanggal_selesai ?? $booking->tanggal_selesai,
            'jam' => $request->jam ?? $booking->jam,
            'catatan' => $request->catatan ?? $booking->catatan,
            'diskon_manual' => $diskonBaru,
            'total_harga_final' => $hargaFinalBaru,
            'status_booking' => $request->status_booking ?? $booking->status_booking,
        ]);

        return back()->with('success', 'Booking berhasil diupdate');
    }

    public function destroy($id)
    {
        $booking = Booking::with(['fasilitas.fasilitas'])->findOrFail($id);

        DB::beginTransaction();

        try {
            foreach ($booking->fasilitas as $item) {
                if ($item->fasilitas && $item->fasilitas->tipe_fasilitas === 'sewa') {
                    $item->fasilitas->increment('stok', $item->qty);
                }
            }

            $booking->items()->delete();
            $booking->fasilitas()->delete();
            
            foreach($booking->pembayaran as $pembayaran) {
                if ($pembayaran->bukti_pembayaran) {
                    Storage::disk('local')->delete($pembayaran->bukti_pembayaran);
                }
                $pembayaran->delete();
            }
            
            $booking->delete();

            DB::commit();

            return back()->with('success', 'Booking berhasil dihapus');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}