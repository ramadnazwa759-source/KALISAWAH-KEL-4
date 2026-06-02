<?php

namespace App\Http\Controllers\API\Kelola_booking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Booking;
use App\Models\BookingItem;
use App\Models\BookingFasilitas;
use App\Models\Pembayaran;

use App\Models\PaketWisata;
use App\Models\Fasilitas;

use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminBookingController extends Controller
{
    // =========================================
    // TAMPIL SEMUA BOOKING
    // =========================================
    public function index()
    {
        $data = Booking::with([
            'items.paketWisata',
            'fasilitas.fasilitas',
            'pembayaran'
        ])->latest()->get();

        return view('admin.kelola_booking.index', compact('data'));
    }

    // =========================================
    // DETAIL BOOKING
    // =========================================
    public function show($id)
    {
        $booking = Booking::with([
            'items.paketWisata',
            'fasilitas.fasilitas',
            'pembayaran'
        ])->find($id);

        if (!$booking) {

            return response()->json([
                'message' => 'Booking tidak ditemukan'
            ], 404);
        }

        return response()->json($booking, 200);
    }

    // =========================================
    // TAMBAH BOOKING MANUAL OLEH ADMIN
    // =========================================
    public function store(Request $request)
    {
        $request->validate([

            'nama_pemesan' =>
                'required|string|max:255',

            'no_hp' =>
                'required|string|max:20',

            'tanggal_kunjungan' =>
                'required|date',

            'jam' =>
                'required',

            'jumlah_pengunjung' =>
                'required|integer|min:1',

            'catatan' =>
                'nullable|string',

            // optional checkout / multi-day
            'tanggal_selesai' =>
                'nullable|date',

            'jumlah_hari' =>
                'nullable|integer|min:1',

            // paket wisata
            'paket' =>
                'required|array|min:1',

            'paket.*.paket_wisata_id' =>
                'required|exists:paket_wisata,id',

            'paket.*.qty' =>
                'required|integer|min:1',

            // fasilitas tambahan
            'fasilitas' =>
                'nullable|array',

            'fasilitas.*.fasilitas_id' =>
                'required|exists:fasilitas,id',

            'fasilitas.*.qty' =>
                'required|integer|min:1',

            // diskon
            'diskon_manual' =>
                'nullable|numeric|min:0',

            // pembayaran admin
            'metode_pembayaran' =>
                'nullable|in:cash,transfer',

            'tipe_pembayaran' =>
                'nullable|in:dp,lunas',

            'nominal_bayar' =>
                'nullable|numeric|min:0',

            'bukti_pembayaran' =>
                'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        DB::beginTransaction();

        try {

            // =====================================
            // GENERATE KODE BOOKING
            // =====================================
            $kodeBooking =
                'KLS-' . strtoupper(Str::random(8));

            // =====================================
            // VARIABLE TOTAL
            // =====================================
            $subtotalPaket = 0;

            $subtotalFasilitas = 0;

            $subtotalTiketTambahan = 0;

            $jumlahTiketTambahan = 0;

            // =====================================
            // HITUNG TOTAL KAPASITAS
            // =====================================
            $totalKapasitas = 0;

            foreach ($request->paket as $item) {

                $paket = PaketWisata::findOrFail(
                    $item['paket_wisata_id']
                );

                $totalKapasitas +=
                    $paket->kapasitas *
                    $item['qty'];
            }

            // =====================================
            // HITUNG TIKET TAMBAHAN
            // =====================================
            if (
                $request->jumlah_pengunjung >
                $totalKapasitas
            ) {

                $jumlahTiketTambahan =
                    $request->jumlah_pengunjung -
                    $totalKapasitas;

                $subtotalTiketTambahan =
                    $jumlahTiketTambahan * 25000;
            }

            // =====================================
            // HITUNG TOTAL PAKET
            // =====================================
            foreach ($request->paket as $item) {

                $paket = PaketWisata::findOrFail(
                    $item['paket_wisata_id']
                );

                $subtotal =
                    $paket->harga *
                    $item['qty'];

                $subtotalPaket +=
                    $subtotal;
            }

            // =====================================
            // HITUNG TOTAL FASILITAS
            // =====================================
            if ($request->fasilitas) {

                foreach ($request->fasilitas as $item) {

                    $fasilitas = Fasilitas::findOrFail(
                        $item['fasilitas_id']
                    );

                    // =================================
                    // CEK STOK FASILITAS SEWA
                    // =================================
                    if (
                        $fasilitas->tipe_fasilitas
                        == 'sewa'
                    ) {

                        if (
                            $fasilitas->stok <
                            $item['qty']
                        ) {

                            DB::rollBack();

                            return response()->json([
                                'message' =>
                                    'Stok fasilitas ' .
                                    $fasilitas->nama_fasilitas .
                                    ' tidak mencukupi'
                            ], 422);
                        }
                    }

                    $subtotal =
                        $fasilitas->harga *
                        $item['qty'];

                    $subtotalFasilitas +=
                        $subtotal;
                }
            }

            // =====================================
            // TOTAL HARGA
            // =====================================
            $totalHarga =
                $subtotalPaket +
                $subtotalFasilitas +
                $subtotalTiketTambahan;

            // =====================================
            // DISKON
            // =====================================
            $diskonManual =
                $request->diskon_manual ?? 0;

            // =====================================
            // TOTAL FINAL
            // =====================================
            $totalHargaFinal = max(
                0,
                $totalHarga - $diskonManual
            );

            // =====================================
            // DEFAULT STATUS
            // =====================================
            $statusBooking = 'pending';
            $statusPembayaran = 'belum_bayar';

            // =====================================
            // HANDLE OPTIONAL CHECKOUT / NIGHTS
            // =====================================
            $tanggalSelesai = null;
            if ($request->filled('tanggal_selesai')) {
                $tanggalSelesai = Carbon::parse($request->tanggal_selesai)->toDateString();
            }

            $jumlahHari = (int) ($request->jumlah_hari ?? 1);

            // =====================================
            // JIKA ADA PEMBAYARAN
            // =====================================
            if ($request->nominal_bayar > 0) {

                $statusBooking =
                    'dikonfirmasi';

                if (
                    $request->nominal_bayar >=
                    $totalHargaFinal
                ) {

                    $statusPembayaran =
                        'lunas';
                }

                else {

                    $statusPembayaran =
                        'dp';
                }
            }

            // =====================================
            // SIMPAN BOOKING
            // =====================================
            $booking = Booking::create([

                'kode_booking' =>
                    $kodeBooking,

                'nama_pemesan' =>
                    $request->nama_pemesan,

                'no_hp' =>
                    $request->no_hp,

                'tanggal_kunjungan' =>
                    $request->tanggal_kunjungan,

                'jam' =>
                    $request->jam,

                'jumlah_pengunjung' =>
                    $request->jumlah_pengunjung,

                'jumlah_tiket_tambahan' =>
                    $jumlahTiketTambahan,

                'harga_tiket_tambahan' =>
                    25000,

                'subtotal_tiket_tambahan' =>
                    $subtotalTiketTambahan,

                'catatan' =>
                    $request->catatan,

                // multi-day fields
                'tanggal_selesai' => $tanggalSelesai,
                'jumlah_hari' => $jumlahHari,

                'total_harga' =>
                    $totalHarga,

                'diskon_manual' =>
                    $diskonManual,

                'total_harga_final' =>
                    $totalHargaFinal,

                'status_booking' =>
                    $statusBooking,

                'status_pembayaran' =>
                    $statusPembayaran
            ]);

            // =====================================
            // SIMPAN BOOKING ITEM
            // =====================================
            foreach ($request->paket as $item) {

                $paket = PaketWisata::findOrFail(
                    $item['paket_wisata_id']
                );

                BookingItem::create([

                    'booking_id' =>
                        $booking->id,

                    'paket_wisata_id' =>
                        $paket->id,

                    'qty' =>
                        $item['qty'],

                    'harga' =>
                        $paket->harga,

                    'subtotal' =>
                        $paket->harga *
                        $item['qty']
                ]);
            }

            // =====================================
            // SIMPAN BOOKING FASILITAS
            // =====================================
            if ($request->fasilitas) {

                foreach (
                    $request->fasilitas
                    as $item
                ) {

                    $fasilitas =
                        Fasilitas::findOrFail(
                            $item['fasilitas_id']
                        );

                    // =============================
                    // KURANGI STOK FASILITAS SEWA
                    // =============================
                    if (
                        $fasilitas->tipe_fasilitas
                        == 'sewa'
                    ) {

                        $fasilitas->decrement(
                            'stok',
                            $item['qty']
                        );
                    }

                    BookingFasilitas::create([

                        'booking_id' =>
                            $booking->id,

                        'fasilitas_id' =>
                            $fasilitas->id,

                        'qty' =>
                            $item['qty'],

                        'harga' =>
                            $fasilitas->harga,

                        'subtotal' =>
                            $fasilitas->harga *
                            $item['qty']
                    ]);
                }
            }

            // =====================================
            // SIMPAN PEMBAYARAN ADMIN
            // =====================================
            if ($request->nominal_bayar > 0) {

                $path = null;

                // =============================
                // UPLOAD BUKTI
                // =============================
                if (
                    $request->hasFile(
                        'bukti_pembayaran'
                    )
                ) {

                    $path = $request
                        ->file('bukti_pembayaran')
                        ->store(
                            'pembayaran',
                            'public'
                        );
                }

                Pembayaran::create([

                    'booking_id' =>
                        $booking->id,

                    'tipe_pembayaran' =>
                        $request->tipe_pembayaran,

                    'metode_pembayaran' =>
                        $request->metode_pembayaran,

                    'nominal' =>
                        $request->nominal_bayar,

                    'bukti_pembayaran' =>
                        $path,

                    // ADMIN AUTO VALID
                    'status_verifikasi' =>
                        'valid',

                    'tanggal_pembayaran' =>
                        now()
                ]);
            }

            DB::commit();

            return redirect()->route('admin.booking-admin.index')->with('success', 'Data booking berhasil ditambahkan!');

        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->route('admin.booking-admin.index')->with('error', 'Error: ' . $e->getMessage());
        }
    }

    // =========================================
    // UPDATE BOOKING
    // =========================================
    public function update(Request $request, $id)
    {
        $booking = Booking::with(
            'fasilitas.fasilitas'
        )->find($id);

        if (!$booking) {

            return response()->json([
                'message' => 'Booking tidak ditemukan'
            ], 404);

        }

        $request->validate([

            'status_booking' =>
                'nullable|in:pending,dikonfirmasi,selesai,dibatalkan',

            'status_pembayaran' =>
                'nullable|in:belum_bayar,dp,lunas,menunggu_verifikasi',

            'diskon_manual' =>
                'nullable|numeric|min:0',

            'catatan' =>
                'nullable|string',

            'tanggal_selesai' =>
                'nullable|date',

            'jumlah_hari' =>
                'nullable|integer|min:1'
        ]);

        DB::beginTransaction();

        try {

            // =====================================
            // KEMBALIKAN STOK JIKA BOOKING DIBATALKAN
            // =====================================
            if (
                $booking->status_booking != 'dibatalkan'
                && $request->status_booking == 'dibatalkan'
            ) {
                foreach ($booking->fasilitas as $item) {
                    $fasilitas = $item->fasilitas;
                    if ($fasilitas && $fasilitas->tipe_fasilitas == 'sewa') {
                        $fasilitas->increment('stok', $item->qty);
                    }
                }
            }

            // =====================================
            // KURANGI STOK JIKA STATUS DIBATALKAN DIUBAH KE STATUS LAIN
            // =====================================
            if (
                $booking->status_booking == 'dibatalkan'
                && $request->status_booking != 'dibatalkan'
                && $request->status_booking !== null
            ) {
                foreach ($booking->fasilitas as $item) {
                    $fasilitas = $item->fasilitas;
                    if ($fasilitas && $fasilitas->tipe_fasilitas == 'sewa') {
                        // Validasi stok sebelum proses
                        if ($fasilitas->stok < $item->qty) {
                            throw new \Exception("Stok fasilitas {$fasilitas->nama_fasilitas} tidak cukup.");
                        }
                        $fasilitas->decrement('stok', $item->qty);
                    }
                }
            }

            // =====================================
            // UPDATE DISKON
            // =====================================
            $diskonManual =
                $request->diskon_manual
                ?? $booking->diskon_manual;

            // =====================================
            // HITUNG TOTAL FINAL
            // =====================================
            $totalHargaFinal = max(
                0,
                $booking->total_harga -
                $diskonManual
            );

            // =====================================
            // UPDATE BOOKING
            // =====================================
            $booking->update([

                'status_booking' =>
                    $request->status_booking
                    ?? $booking->status_booking,

                'status_pembayaran' =>
                    $request->status_pembayaran
                    ?? $booking->status_pembayaran,

                'catatan' =>
                    $request->catatan
                    ?? $booking->catatan,

                'diskon_manual' =>
                    $diskonManual,

                'total_harga_final' =>
                    $totalHargaFinal,

                // allow admin to update multi-day fields
                'tanggal_selesai' => $request->tanggal_selesai ?? $booking->tanggal_selesai,
                'jumlah_hari' => $request->jumlah_hari ?? $booking->jumlah_hari
            ]);

            DB::commit();

            return redirect()->route('admin.booking-admin.index')->with('success', 'Booking berhasil diupdate!');

        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->route('admin.booking-admin.index')->with('error', 'Terjadi kesalahan saat mengupdate booking: ' . $e->getMessage());
        }
    }

    // =========================================
    // HAPUS BOOKING
    // =========================================
    public function destroy($id)
    {
        $booking = Booking::with(
            'fasilitas.fasilitas'
        )->find($id);

        if (!$booking) {

            return redirect()->route('admin.booking-admin.index')->with('error', 'Booking tidak ditemukan!');
        }

        DB::beginTransaction();

        try {

            // =====================================
            // KEMBALIKAN STOK
            // =====================================
            foreach (
                $booking->fasilitas
                as $item
            ) {

                $fasilitas =
                    $item->fasilitas;

                if (

                    $fasilitas &&

                    $fasilitas->tipe_fasilitas
                    == 'sewa'

                ) {

                    $fasilitas->increment(
                        'stok',
                        $item->qty
                    );
                }
            }

            // =====================================
            // HAPUS RELASI
            // =====================================
            $booking->items()->delete();

            $booking->fasilitas()->delete();

            $booking->pembayaran()->delete();

            // =====================================
            // HAPUS BOOKING
            // =====================================
            $booking->delete();

            DB::commit();

            return redirect()->route('admin.booking-admin.index')->with('success', 'Booking berhasil dihapus!');

        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->route('admin.booking-admin.index')->with('error', 'Terjadi kesalahan saat menghapus booking: ' . $e->getMessage());
        }
    }
}
