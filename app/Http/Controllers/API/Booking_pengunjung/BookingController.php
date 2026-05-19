<?php

namespace App\Http\Controllers\API\Booking_pengunjung;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use App\Models\Booking;
use App\Models\BookingItem;
use App\Models\BookingFasilitas;

use App\Models\PaketWisata;
use App\Models\Fasilitas;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([

            'nama_pemesan' => 'required',
            'no_hp' => 'required',

            'tanggal_kunjungan' => 'required|date',

            'jam' => 'required',

            'jumlah_pengunjung' => 'required|integer|min:1',

            'paket' => 'required|array|min:1',

            'paket.*.id_paket' =>
                'required|exists:paket_wisata,id',

            'paket.*.qty' =>
                'required|integer|min:1',

            'fasilitas' => 'nullable|array',

            'fasilitas.*.id_fasilitas' =>
                'required|exists:fasilitas,id',

            'fasilitas.*.qty' =>
                'required|integer|min:1',

            'catatan' => 'nullable'
        ]);

        DB::beginTransaction();

        try {

            // =========================
            // GENERATE KODE BOOKING
            // =========================

            $kodeBooking =
                'KLS-' . strtoupper(Str::random(8));

            // =========================
            // TOTAL PAKET
            // =========================

            $totalPaket = 0;

            $totalKapasitas = 0;

            foreach ($request->paket as $item) {

                $paket =
                    PaketWisata::findOrFail(
                        $item['id_paket']
                    );

                $subtotal =
                    $paket->harga * $item['qty'];

                $totalPaket += $subtotal;

                $totalKapasitas +=
                    $paket->kapasitas *
                    $item['qty'];
            }

            // =========================
            // HITUNG TIKET TAMBAHAN
            // =========================

            $jumlahTiketTambahan = 0;

            $hargaTiketTambahan = 25000;

            $subtotalTiketTambahan = 0;

            if (
                $request->jumlah_pengunjung >
                $totalKapasitas
            ) {

                $jumlahTiketTambahan =
                    $request->jumlah_pengunjung -
                    $totalKapasitas;

                $subtotalTiketTambahan =
                    $jumlahTiketTambahan *
                    $hargaTiketTambahan;
            }

            // =========================
            // BUAT BOOKING
            // =========================

            $booking = Booking::create([

                'kode_booking' => $kodeBooking,

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
                    $hargaTiketTambahan,

                'subtotal_tiket_tambahan' =>
                    $subtotalTiketTambahan,

                'catatan' =>
                    $request->catatan,

                'status_booking' =>
                    'pending',

                'status_pembayaran' =>
                    'belum_bayar',

                'expired_at' =>
                    now()->addHour()
            ]);

            // =========================
            // SIMPAN BOOKING ITEMS
            // =========================

            foreach ($request->paket as $item) {

                $paket =
                    PaketWisata::findOrFail(
                        $item['id_paket']
                    );

                $subtotal =
                    $paket->harga * $item['qty'];

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
                        $subtotal
                ]);
            }

            // =========================
            // FASILITAS TAMBAHAN
            // =========================

            $totalFasilitas = 0;

            if ($request->fasilitas) {

                foreach (
                    $request->fasilitas
                    as $item
                ) {

                    $fasilitas =
                        Fasilitas::findOrFail(
                            $item['id_fasilitas']
                        );

                    // =====================
                    // CEK STOK
                    // =====================

                    if (
                        $fasilitas->stok <
                        $item['qty']
                    ) {

                        return response()->json([
                            'message' =>
                                'Stok fasilitas tidak cukup'
                        ], 400);
                    }

                    $subtotal =
                        $fasilitas->harga *
                        $item['qty'];

                    $totalFasilitas +=
                        $subtotal;

                    // =====================
                    // SIMPAN BOOKING
                    // FASILITAS
                    // =====================

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
                            $subtotal
                    ]);

                    // =====================
                    // KURANGI STOK
                    // =====================

                    $fasilitas->decrement(
                        'stok',
                        $item['qty']
                    );
                }
            }

            // =========================
            // HITUNG TOTAL FINAL
            // =========================

            $totalHarga =

                $totalPaket +

                $subtotalTiketTambahan +

                $totalFasilitas;

            // =========================
            // UPDATE TOTAL BOOKING
            // =========================

            $booking->update([

                'total_harga' =>
                    $totalHarga,

                'diskon_manual' =>
                    0,

                'total_harga_final' =>
                    $totalHarga
            ]);

            DB::commit();

            return response()->json([

                'message' =>
                    'Booking berhasil dibuat',

                'booking_id' =>
                    $booking->id,

                'kode_booking' =>
                    $booking->kode_booking,

                'status_booking' =>
                    $booking->status_booking,

                'total_harga' =>
                    $booking->total_harga_final
            ]);

        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([

                'message' =>
                    $e->getMessage()

            ], 500);
        }
    }
}