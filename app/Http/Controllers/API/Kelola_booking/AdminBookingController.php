<?php

namespace App\Http\Controllers\API\Kelola_booking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

use App\Models\Booking;
use App\Models\BookingItem;
use App\Models\BookingFasilitas;
use App\Models\Fasilitas;
use App\Models\Pembayaran;
use App\Models\PaketWisata;

class AdminBookingController extends Controller
{
    public function index()
    {
        $data = Booking::with(['items.paketWisata', 'fasilitas.fasilitas', 'pembayaran'])
            ->latest()
            ->get();

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
        $booking = Booking::with(['items.paketWisata', 'fasilitas.fasilitas', 'pembayaran'])
            ->findOrFail($id);

        return view('admin.kelola_booking.show', compact('booking'));
    }

public function store(Request $request)
{
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
        'total_harga' => $request->total_harga,
        'total_harga_final' => $request->total_harga_final,
        'diskon_manual' => $request->diskon_manual ?? 0,
        'jumlah_tiket_tambahan' => $request->jumlah_tiket_tambahan ?? 0,
        'subtotal_tiket_tambahan' => $request->subtotal_tiket_tambahan ?? 0,
        'status_booking' => 'pending'
    ]);

    Pembayaran::create([
        'booking_id' => $booking->id,
        'tipe_pembayaran' => $request->tipe_pembayaran,
        'metode_pembayaran' => $request->metode_pembayaran,
        'nominal' => $request->nominal,
        'tanggal_pembayaran' => now()
    ]);

    if ($request->has('paket')) {
        foreach ($request->paket as $p) {
            $tanggal = \Carbon\Carbon::parse($request->tanggal_kunjungan)
                        ->addDays($p['hari'] - 1)
                        ->format('Y-m-d');
            
            $subtotal = $p['qty'] * $p['harga'];

            BookingItem::create([
                'booking_id' => $booking->id,
                'paket_wisata_id' => $p['paket_wisata_id'],
                'hari' => $p['hari'],
                'tanggal' => $tanggal,
                'qty' => $p['qty'],
                'harga' => $p['harga'],
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
                
                $subtotal = $f['qty'] * $f['harga'];

                BookingFasilitas::create([
                    'booking_id' => $booking->id,
                    'fasilitas_id' => $f['fasilitas_id'],
                    'hari' => $i,
                    'tanggal' => $tanggal,
                    'qty' => $f['qty'],
                    'harga' => $f['harga'],
                    'subtotal' => $subtotal,
                ]);
            }
        }
    }

    return redirect('/admin/booking-admin')->with('success', 'Data booking berhasil ditambahkan!');
}

    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $booking->update([
            'nama_pemesan' => $request->nama_pemesan ?? $booking->nama_pemesan,
            'no_hp' => $request->no_hp ?? $booking->no_hp,
            'tanggal_kunjungan' => $request->tanggal_kunjungan ?? $booking->tanggal_kunjungan,
            'jam' => $request->jam ?? $booking->jam,
            'catatan' => $request->catatan ?? $booking->catatan,
            'status_booking' => $request->status_booking ?? $booking->status_booking,
            'status_pembayaran' => $request->status_pembayaran ?? $booking->status_pembayaran,
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
            $booking->pembayaran()->delete();
            $booking->delete();

            DB::commit();

            return back()->with('success', 'Booking berhasil dihapus');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}