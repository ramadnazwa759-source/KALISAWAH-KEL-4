<?php

namespace App\Http\Controllers\API\Pembayaran;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\Booking;
use Illuminate\Support\Facades\Storage;

class PembayaranPengunjungController extends Controller
{
    public function uploadDP(Request $request, $id)
    {
        $request->validate([

            'bukti_pembayaran_dp' =>
                'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $booking = Booking::findOrFail($id);

        if (!$request->file('bukti_pembayaran_dp')->isValid()) {

            return response()->json([
                'message' => 'File tidak valid'
            ], 400);
        }

        $path = $request
            ->file('bukti_pembayaran_dp')
            ->store('bukti-pembayaran/dp', 'public');

        $pembayaran = Pembayaran::create([

            'id_booking' => $booking->id,

            'metode' => 'transfer',

            'bukti_pembayaran_dp' => $path,

            'tanggal_dp' => now(),

            // otomatis dari booking
            'total_harga_awal' => $booking->total_harga,

            'id_diskon' => null,

            // sementara sama dulu
            'total_harga_akhir' => $booking->total_harga,

            'bukti_pelunasan' => null,

            'status' => 'menunggu_verifikasi',

            'tanggal_pelunasan' => null,
        ]);

        return response()->json([
            'message' => 'Bukti pembayaran berhasil diupload',
            'data' => $pembayaran
        ]);
    }

    public function uploadUlangPelunasan(Request $request, $id)
    {
        $request->validate([

            'bukti_pelunasan' =>
                'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $pembayaran = Pembayaran::findOrFail($id);

        if (!$request->file('bukti_pelunasan')->isValid()) {

            return response()->json([
                'message' => 'File tidak valid'
            ], 400);
        }

        if ($pembayaran->bukti_pelunasan) {

            Storage::disk('public')
                ->delete($pembayaran->bukti_pelunasan);
        }

        $path = $request
            ->file('bukti_pelunasan')
            ->store('bukti-pembayaran/pelunasan', 'public');

        $pembayaran->update([

            'bukti_pelunasan' => $path,

            'tanggal_pelunasan' => now(),

            'status' => 'menunggu_verifikasi_pelunasan'
        ]);

        return response()->json([
            'message' => 'Bukti pelunasan berhasil diupload',
            'data' => $pembayaran
        ]);
    }
}