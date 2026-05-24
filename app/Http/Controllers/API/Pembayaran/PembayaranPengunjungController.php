<?php

namespace App\Http\Controllers\API\Pembayaran;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Pembayaran;
use App\Models\Booking;

class PembayaranPengunjungController extends Controller
{
    // ======================================================
    // UPLOAD BUKTI PEMBAYARAN
    // ======================================================
    public function uploadBukti(
        Request $request,
        $bookingId
    ) {

        $request->validate([

            'nominal' =>
                'required|numeric|min:1',

            'bukti_pembayaran' =>
                'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // ==========================================
        // CEK BOOKING
        // ==========================================
        $booking = Booking::find($bookingId);

        if (!$booking) {

            return response()->json([
                'message' =>
                    'Booking tidak ditemukan'
            ], 404);
        }

        // ==========================================
        // CEK PEMBAYARAN
        // ==========================================
        $pembayaran = Pembayaran::where(
            'booking_id',
            $booking->id
        )->first();

        if (!$pembayaran) {

            return response()->json([
                'message' =>
                    'Data pembayaran tidak ditemukan'
            ], 404);
        }

        // ==========================================
        // UPLOAD BUKTI
        // ==========================================
        $path = $request
            ->file('bukti_pembayaran')
            ->store(
                'pembayaran',
                'public'
            );

        // ==========================================
        // UPDATE PEMBAYARAN
        // ==========================================
        $pembayaran->update([

            'nominal' =>
                $request->nominal,

            'bukti_pembayaran' =>
                $path,

            'tanggal_pembayaran' =>
                now(),

            'status_verifikasi' =>
                'pending'
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
                'Bukti pembayaran berhasil diupload',

            'data' =>
                $pembayaran
        ], 200);
    }
}
