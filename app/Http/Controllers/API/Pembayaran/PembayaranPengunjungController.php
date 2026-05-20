<?php

namespace App\Http\Controllers\API\Pembayaran;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Pembayaran;
use App\Models\Booking;

class PembayaranPengunjungController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([

            'booking_id' =>
                'required|exists:booking,id',

            'metode_pembayaran' =>
                'required|in:transfer,cash',

            'tipe_pembayaran' =>
                'required|in:dp,pelunasan',

            'nominal' =>
                'required|numeric|min:1',

            'bukti_pembayaran' =>
                'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $booking = Booking::find(
            $request->booking_id
        );

        // ==========================================
        // UPLOAD BUKTI
        // ==========================================
        $path = $request->file(
                    'bukti_pembayaran'
                )
                ->store(
                    'pembayaran',
                    'public'
                );

        // ==========================================
        // SIMPAN PEMBAYARAN
        // ==========================================
        $pembayaran = Pembayaran::create([

            'booking_id' =>
                $booking->id,

            'metode_pembayaran' =>
                $request->metode_pembayaran,

            'tipe_pembayaran' =>
                $request->tipe_pembayaran,

            'nominal' =>
                $request->nominal,

            'bukti_pembayaran' =>
                $path,

            'status_verifikasi' =>
                'pending',

            'tanggal_pembayaran' =>
                now()
        ]);

        // ==========================================
        // UPDATE STATUS BOOKING
        // ==========================================
        $booking->update([

            'status_booking' =>
                'pending'
        ]);

        return response()->json([

            'message' =>
                'Bukti pembayaran berhasil dikirim',

            'data' =>
                $pembayaran
        ], 201);
    }
}