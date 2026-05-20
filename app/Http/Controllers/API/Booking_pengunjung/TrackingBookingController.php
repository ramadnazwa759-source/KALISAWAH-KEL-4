<?php

namespace App\Http\Controllers\API\Booking_pengunjung;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Booking;

class TrackingBookingController extends Controller
{
    // ======================================================
    // CARI BOOKING
    // ======================================================
    public function track(Request $request)
{
    $request->validate([

        'nama_pemesan' =>
            'required|string',

        'no_hp' =>
            'required|string',

        'tanggal_kunjungan' =>
            'required|date'
    ]);

    $booking = Booking::with([
        'pembayaran'
    ])
    ->where(
        'nama_pemesan',
        $request->nama_pemesan
    )
    ->where(
        'no_hp',
        $request->no_hp
    )
    ->where(
        'tanggal_kunjungan',
        $request->tanggal_kunjungan
    )
    ->latest()
    ->first();

    if (!$booking) {

        return response()->json([

            'message' =>
                'Data booking tidak ditemukan'
        ], 404);
    }

    // pembayaran terakhir
    $pembayaran =
        $booking->pembayaran
                ->sortByDesc('created_at')
                ->first();

    return response()->json([

        'message' =>
            'Data ditemukan',

        'data' => [

            'id' =>
                $booking->id,

            // ==================================
            // KODE BOOKING HANYA MUNCUL
            // JIKA SUDAH VALID
            // ==================================
            'kode_booking' =>

                $pembayaran &&
                $pembayaran->status_verifikasi
                == 'valid'

                ? $booking->kode_booking

                : null,

            'nama_pemesan' =>
                $booking->nama_pemesan,

            'tanggal_kunjungan' =>
                $booking->tanggal_kunjungan,

            // ==================================
            // STATUS BOOKING
            // ==================================
            'status_booking' =>
                $booking->status_booking,

            // ==================================
            // STATUS VERIFIKASI
            // ==================================
            'status_verifikasi' =>

                $pembayaran
                ? $pembayaran->status_verifikasi
                : null,

            // ==================================
            // CATATAN ADMIN
            // ==================================
            'catatan' =>

                $pembayaran
                ? $pembayaran->catatan
                : null
        ]
    ], 200);
}

    // ======================================================
    // DETAIL BOOKING
    // ======================================================
    public function detail($id)
    {
        $booking = Booking::with([

            // paket booking
            'bookingItem.paketWisata',

            // fasilitas tambahan
            'bookingFasilitas.fasilitas',

            // pembayaran
            'pembayaran'
        ])->find($id);

        if (!$booking) {

            return response()->json([

                'message' =>
                    'Booking tidak ditemukan'
            ], 404);
        }

        return response()->json([

            'message' =>
                'Detail booking ditemukan',

            'data' => [

                'id' =>
                    $booking->id,

                'kode_booking' =>
                    $booking->kode_booking,

                'nama_pemesan' =>
                    $booking->nama_pemesan,

                'no_hp' =>
                    $booking->no_hp,

                'tanggal_kunjungan' =>
                    $booking->tanggal_kunjungan,

                'jam' =>
                    $booking->jam,

                'jumlah_pengunjung' =>
                    $booking->jumlah_pengunjung,

                'jumlah_tiket_tambahan' =>
                    $booking->jumlah_tiket_tambahan,

                'subtotal_tiket_tambahan' =>
                    $booking->subtotal_tiket_tambahan,

                'catatan' =>
                    $booking->catatan,

                // ==================================
                // STATUS YANG BENAR
                // ==================================
                'status_booking' =>
                    $booking->status_booking,

                'status_pembayaran' =>
                    $booking->status_pembayaran,

                // ==================================
                // HARGA
                // ==================================
                'total_harga' =>
                    $booking->total_harga,

                'diskon_manual' =>
                    $booking->diskon_manual,

                'total_harga_final' =>
                    $booking->total_harga_final,

                // ==================================
                // ITEM BOOKING
                // ==================================
                'paket' =>
                    $booking->bookingItem,

                // ==================================
                // FASILITAS TAMBAHAN
                // ==================================
                'fasilitas' =>
                    $booking->bookingFasilitas,

                // ==================================
                // PEMBAYARAN
                // ==================================
                'pembayaran' =>
                    $booking->pembayaran
            ]
        ], 200);
    }
}