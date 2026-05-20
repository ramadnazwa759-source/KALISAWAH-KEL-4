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
                'required|string',

            'jenis_pembayaran' =>
                'required|in:dp,lunas',

            'nominal' =>
                'required|numeric|min:1',

            'bukti_pembayaran' =>
                'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $booking = Booking::find($request->booking_id);

        // upload bukti
        $path = $request->file('bukti_pembayaran')
                        ->store('pembayaran', 'public');

        // simpan pembayaran
        $pembayaran = Pembayaran::create([

            'booking_id' =>
                $booking->id,

            'metode_pembayaran' =>
                $request->metode_pembayaran,

            'jenis_pembayaran' =>
                $request->jenis_pembayaran,

            'nominal' =>
                $request->nominal,

            'bukti_pembayaran' =>
                $path,

            'status_verifikasi' =>
                'menunggu',

            'tanggal_bayar' =>
                now()
        ]);

        // update status booking
        $booking->update([

            'status_pembayaran' =>
                'menunggu_verifikasi'
        ]);

        return response()->json([

            'message' =>
                'Bukti pembayaran berhasil dikirim',

            'data' =>
                $pembayaran
        ], 201);
    }
}