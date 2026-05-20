<?php

namespace App\Http\Controllers\API\Pembayaran;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Pembayaran;
use App\Models\Booking;

class PembayaranAdminController extends Controller
{
    // ======================================================
    // MENAMPILKAN SEMUA PEMBAYARAN
    // ======================================================
    public function index()
    {
        $data = Pembayaran::with([
            'booking'
        ])->latest()->get();

        return response()->json($data, 200);
    }

    // ======================================================
    // DETAIL PEMBAYARAN
    // ======================================================
    public function show($id)
    {
        $data = Pembayaran::with([
            'booking'
        ])->find($id);

        if (!$data) {

            return response()->json([
                'message' => 'Data pembayaran tidak ditemukan'
            ], 404);
        }

        return response()->json($data, 200);
    }

    // ======================================================
    // TAMBAH PEMBAYARAN OLEH ADMIN
    // ======================================================
    public function store(Request $request)
    {
        $request->validate([

            'booking_id' =>
                'required|exists:booking,id',

            'tipe_pembayaran' =>
                'required|in:dp,pelunasan',

            'metode_pembayaran' =>
                'required|in:transfer,cash',

            'nominal' =>
                'required|numeric|min:1',

            'catatan' =>
                'nullable|string'
        ]);

        $booking = Booking::find(
            $request->booking_id
        );

        // ==========================================
        // SIMPAN PEMBAYARAN
        // ==========================================
        $pembayaran = Pembayaran::create([

            'booking_id' =>
                $request->booking_id,

            'tipe_pembayaran' =>
                $request->tipe_pembayaran,

            'metode_pembayaran' =>
                $request->metode_pembayaran,

            'nominal' =>
                $request->nominal,

            // admin otomatis valid
            'status_verifikasi' =>
                'valid',

            'tanggal_pembayaran' =>
                now(),

            'catatan' =>
                $request->catatan
        ]);

        // ==========================================
        // HITUNG TOTAL PEMBAYARAN VALID
        // ==========================================
        $totalPembayaran = Pembayaran::where(
                'booking_id',
                $booking->id
            )
            ->where(
                'status_verifikasi',
                'valid'
            )
            ->sum('nominal');

        // ==========================================
        // UPDATE STATUS BOOKING
        // ==========================================
        if (
            $totalPembayaran >=
            $booking->total_harga_final
        ) {

            $booking->update([

                'status_pembayaran' =>
                    'lunas',

                'status_booking' =>
                    'dikonfirmasi'
            ]);
        }

        else {

            $booking->update([

                'status_pembayaran' =>
                    'dp',

                'status_booking' =>
                    'dikonfirmasi'
            ]);
        }

        return response()->json([

            'message' =>
                'Pembayaran berhasil ditambahkan',

            'data' =>
                $pembayaran
        ], 201);
    }

    // ======================================================
    // VERIFIKASI PEMBAYARAN PENGUNJUNG
    // ======================================================
    public function update(Request $request, $id)
    {
        $request->validate([

            'status_verifikasi' =>
                'required|in:valid,ditolak',

            'catatan' =>
                'nullable|string'
        ]);

        $pembayaran = Pembayaran::find($id);

        if (!$pembayaran) {

            return response()->json([
                'message' => 'Data pembayaran tidak ditemukan'
            ], 404);
        }

        // ==========================================
        // UPDATE STATUS VERIFIKASI
        // ==========================================
        $pembayaran->update([

            'status_verifikasi' =>
                $request->status_verifikasi,

            'catatan' =>
                $request->catatan
        ]);

        $booking = Booking::find(
            $pembayaran->booking_id
        );

        // ==========================================
        // JIKA PEMBAYARAN VALID
        // ==========================================
        if (
            $request->status_verifikasi
            == 'valid'
        ) {

            // hitung total pembayaran valid
            $totalPembayaran = Pembayaran::where(
                    'booking_id',
                    $booking->id
                )
                ->where(
                    'status_verifikasi',
                    'valid'
                )
                ->sum('nominal');

            // jika lunas
            if (
                $totalPembayaran >=
                $booking->total_harga_final
            ) {

                $booking->update([

                    'status_pembayaran' =>
                        'lunas',

                    'status_booking' =>
                        'dikonfirmasi'
                ]);
            }

            // jika masih DP
            else {

                $booking->update([

                    'status_pembayaran' =>
                        'dp',

                    'status_booking' =>
                        'dikonfirmasi'
                ]);
            }
        }

        // ==========================================
        // JIKA DITOLAK
        // ==========================================
        else {

            $booking->update([

                'status_pembayaran' =>
                    'belum_bayar'
            ]);
        }

        return response()->json([

            'message' =>
                'Verifikasi pembayaran berhasil',

            'data' =>
                $pembayaran
        ], 200);
    }

    // ======================================================
    // HAPUS PEMBAYARAN
    // ======================================================
    public function destroy($id)
    {
        $pembayaran = Pembayaran::find($id);

        if (!$pembayaran) {

            return response()->json([
                'message' => 'Data pembayaran tidak ditemukan'
            ], 404);
        }

        $pembayaran->delete();

        return response()->json([

            'message' =>
                'Pembayaran berhasil dihapus'
        ], 200);
    }
}