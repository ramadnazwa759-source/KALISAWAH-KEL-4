<?php

namespace App\Http\Controllers\API\Booking_pengunjung;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Booking;
use App\Models\BookingItem;
use App\Models\BookingFasilitas;
use App\Models\Pembayaran;

use App\Models\PaketWisata;
use App\Models\Fasilitas;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PengunjungBookingController extends Controller
{
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

            // =====================================
            // PAKET
            // =====================================
            'paket' =>
                'required|array|min:1',

            'paket.*.paket_wisata_id' =>
                'required|exists:paket_wisata,id',

            'paket.*.qty' =>
                'required|integer|min:1',

            // =====================================
            // FASILITAS
            // =====================================
            'fasilitas' =>
                'nullable|array',

            'fasilitas.*.fasilitas_id' =>
                'required|exists:fasilitas,id',

            'fasilitas.*.qty' =>
                'required|integer|min:1',

            // =====================================
            // PEMBAYARAN
            // =====================================
            'tipe_pembayaran' =>
                'required|in:dp,pelunasan',

            'metode_pembayaran' =>
                'required|in:transfer,cash,qris'
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

            $totalKapasitas = 0;

            // =====================================
            // HITUNG TOTAL KAPASITAS
            // =====================================
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

                    $fasilitas =
                        Fasilitas::findOrFail(
                            $item['fasilitas_id']
                        );

                    // =============================
                    // CEK STOK FASILITAS SEWA
                    // =============================
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

                'total_harga' =>
                    $totalHarga,

                'diskon_manual' =>
                    0,

                'total_harga_final' =>
                    $totalHarga,

                // =================================
                // MENUNGGU VERIFIKASI PEMBAYARAN
                // =================================
                'status_booking' =>
                    'pending',

                'status_pembayaran' =>
                    'belum_bayar'
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

                foreach ($request->fasilitas as $item) {

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
            // SIMPAN DATA PEMBAYARAN AWAL
            // =====================================
            Pembayaran::create([

                'booking_id' =>
                    $booking->id,

                'tipe_pembayaran' =>
                    $request->tipe_pembayaran,

                'metode_pembayaran' =>
                    $request->metode_pembayaran,

                // =================================
                // NOMINAL MASIH 0
                // NANTI DIINPUT ADMIN
                // =================================
                'nominal' =>
                    0,

                // =================================
                // BUKTI BELUM DIUPLOAD
                // =================================
                'bukti_pembayaran' =>
                    null,

                // =================================
                // BELUM ADA PEMBAYARAN
                // =================================
                'tanggal_pembayaran' =>
                    null,

                // =================================
                // MENUNGGU VERIFIKASI ADMIN
                // =================================
                'status_verifikasi' =>
                    'pending',

                'catatan' =>
                    null
            ]);

            DB::commit();

            return response()->json([

                'message' =>
                    'Booking berhasil dibuat',

                'booking_id' =>
                    $booking->id,

                'kode_booking' =>
                    $booking->kode_booking,

                'total_harga' =>
                    $booking->total_harga_final,

                'status_booking' =>
                    $booking->status_booking,

                'status_pembayaran' =>
                    $booking->status_pembayaran
            ], 201);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}