<?php

namespace App\Http\Controllers\API\Booking_pengunjung;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;

class TrackingBookingController extends Controller
{
    // =========================================
    // STEP 1: SEARCH BOOKING
    // =========================================

    public function track(Request $request)
    {
        $request->validate([
            'nama_pemesan' => 'required',
            'no_hp' => 'required',
            'tanggal_kunjungan' => 'required'
        ]);

        $bookings = Booking::where('nama_pemesan', $request->nama_pemesan)
            ->where('no_hp', $request->no_hp)
            ->where('tanggal_kunjungan', $request->tanggal_kunjungan)
            ->get();

        if ($bookings->isEmpty()) {
            return response()->json([
                'message' => 'Data booking tidak ditemukan'
            ], 404);
        }

        // return list (AMAN, tidak ada data sensitif)
        return response()->json([
            'message' => 'Data ditemukan',
            'data' => $bookings->map(function ($b) {
                return [
                    'id' => $b->id,
                    'kode_booking' => $b->kode_booking,
                    'nama_pemesan' => $b->nama_pemesan,
                    'tanggal_kunjungan' => $b->tanggal_kunjungan,
                    'status_booking' => $b->status_booking
                ];
            })
        ]);
    }

    // =========================================
    // STEP 2: DETAIL BOOKING (UNTUK UPLOAD DP PAGE)
    // =========================================

    public function detail($id)
    {
            with([
        'bookingItem.paketWisata',
        'bookingFasilitas.fasilitas',
        'pembayaran.pembayaranPengunjung'
    ])
            ->find($id);

        if (!$booking) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'data' => [
                'kode_booking' => $booking->kode_booking,
                'status_booking' => $booking->status_booking,

                'paket' => $booking->paket,
                'fasilitas' => $booking->fasilitas,

                'total_harga' => $booking->total_harga,
                'total_final' => $booking->total_harga_final,

                'pembayaran' => $booking->pembayaran
            ]
        ]);
    }
}