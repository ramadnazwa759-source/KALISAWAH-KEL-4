<?php

namespace App\Http\Controllers\API\Pembayaran;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Pembayaran;
use App\Models\Booking;

class PembayaranAdminController extends Controller
{
    // ======================================================
    // LIST PEMBAYARAN
    // ======================================================
    public function index()
    {
        return response()->json(
            Pembayaran::with('booking')->latest()->get(),
            200
        );
    }

    // ======================================================
    // DETAIL PEMBAYARAN
    // ======================================================
    public function show($id)
    {
        $data = Pembayaran::with('booking')->find($id);

        if (!$data) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json($data, 200);
    }

    // ======================================================
    // UPDATE / VERIFIKASI PEMBAYARAN
    // ======================================================
    public function update(Request $request, $id)
    {
        $request->validate([
            'status_verifikasi' => 'required|in:valid,ditolak',
            'catatan' => 'nullable|string'
        ]);

        $pembayaran = Pembayaran::find($id);

        if (!$pembayaran) {
            return response()->json([
                'message' => 'Pembayaran tidak ditemukan'
            ], 404);
        }

        // update pembayaran
        $pembayaran->update([
            'status_verifikasi' => $request->status_verifikasi,
            'catatan' => $request->catatan
        ]);

        $booking = Booking::find($pembayaran->booking_id);

        if (!$booking) {
            return response()->json([
                'message' => 'Booking tidak ditemukan'
            ], 404);
        }

        // ======================================================
        // JIKA VALID
        // ======================================================
        if ($request->status_verifikasi === 'valid') {

            $booking->update([
                'status_booking' => 'dikonfirmasi',
                'status_pembayaran' => 'dp'
            ]);
        }

        // ======================================================
        // JIKA DITOLAK
        // ======================================================
        else {

            $booking->update([
                'status_booking' => 'pending',
                'status_pembayaran' => 'belum_bayar'
            ]);
        }

        return response()->json([
            'message' => 'Verifikasi berhasil',
            'data' => $pembayaran->load('booking')
        ], 200);
    }

    // ======================================================
    // TAMBAH PEMBAYARAN (ADMIN CASH / LUNAS)
    // ======================================================
    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:booking,id',
            'tipe_pembayaran' => 'required|in:dp,pelunasan',
            'metode_pembayaran' => 'required|in:transfer,cash',
            'nominal' => 'required|numeric|min:1',
            'catatan' => 'nullable|string'
        ]);

        $booking = Booking::find($request->booking_id);

        $pembayaran = Pembayaran::create([
            'booking_id' => $booking->id,
            'tipe_pembayaran' => $request->tipe_pembayaran,
            'metode_pembayaran' => $request->metode_pembayaran,
            'nominal' => $request->nominal,
            'status_verifikasi' => 'valid',
            'tanggal_pembayaran' => now(),
            'catatan' => $request->catatan
        ]);

        // hitung total valid pembayaran
        $total = Pembayaran::where('booking_id', $booking->id)
            ->where('status_verifikasi', 'valid')
            ->sum('nominal');

        // update booking otomatis
        if ($total >= $booking->total_harga_final) {

            $booking->update([
                'status_booking' => 'dikonfirmasi',
                'status_pembayaran' => 'lunas'
            ]);
        } else {

            $booking->update([
                'status_booking' => 'dikonfirmasi',
                'status_pembayaran' => 'dp'
            ]);
        }

        return response()->json([
            'message' => 'Pembayaran admin berhasil ditambahkan',
            'data' => $pembayaran
        ], 201);
    }

    // ======================================================
    // HAPUS PEMBAYARAN
    // ======================================================
    public function destroy($id)
    {
        $data = Pembayaran::find($id);

        if (!$data) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $data->delete();

        return response()->json([
            'message' => 'Berhasil dihapus'
        ], 200);
    }
}