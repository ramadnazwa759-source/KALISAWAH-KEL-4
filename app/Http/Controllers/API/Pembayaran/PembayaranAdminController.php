<?php

namespace App\Http\Controllers\API\Pembayaran;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Pembayaran;
use App\Models\Booking;

use Illuminate\Support\Facades\DB;

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

        DB::beginTransaction();

        try {

            $pembayaran = Pembayaran::find($id);

            if (!$pembayaran) {

                return response()->json([
                    'message' => 'Pembayaran tidak ditemukan'
                ], 404);
            }

            // =====================================
            // UPDATE STATUS VERIFIKASI
            // =====================================
            $pembayaran->update([

                'status_verifikasi' =>
                    $request->status_verifikasi,

                'catatan' =>
                    $request->catatan
            ]);

            $booking = Booking::find(
                $pembayaran->booking_id
            );

            if (!$booking) {

                return response()->json([
                    'message' => 'Booking tidak ditemukan'
                ], 404);
            }

            // =====================================
            // JIKA PEMBAYARAN VALID
            // =====================================
            if (
                $request->status_verifikasi
                == 'valid'
            ) {

                // total pembayaran valid
                $totalPembayaran =
                    Pembayaran::where(
                        'booking_id',
                        $booking->id
                    )
                    ->where(
                        'status_verifikasi',
                        'valid'
                    )
                    ->sum('nominal');

                // =================================
                // JIKA SUDAH LUNAS
                // =================================
                if (
                    $totalPembayaran >=
                    $booking->total_harga_final
                ) {

                    $booking->update([

                        'status_booking' =>
                            'dikonfirmasi',

                        'status_pembayaran' =>
                            'lunas'
                    ]);
                }

                // =================================
                // JIKA MASIH DP
                // =================================
                else {

                    $booking->update([

                        'status_booking' =>
                            'dikonfirmasi',

                        'status_pembayaran' =>
                            'dp'
                    ]);
                }
            }

            // =====================================
            // JIKA DITOLAK
            // =====================================
            else {

                $booking->update([

                    'status_booking' =>
                        'pending',

                    'status_pembayaran' =>
                        'belum_bayar'
                ]);
            }

            DB::commit();

            return response()->json([

                'message' =>
                    'Verifikasi pembayaran berhasil',

                'data' =>
                    $pembayaran->load('booking')
            ], 200);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
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
                'required|in:transfer,cash,qris',

            'nominal' =>
                'required|numeric|min:1',

            'bukti_pembayaran' =>
                'required|image|mimes:jpg,jpeg,png|max:2048',

            'catatan' =>
                'nullable|string'
        ]);

        DB::beginTransaction();

        try {

            $booking = Booking::findOrFail(
                $request->booking_id
            );

            // =====================================
            // UPLOAD BUKTI PEMBAYARAN
            // =====================================
            $path = $request->file(
                        'bukti_pembayaran'
                    )
                    ->store(
                        'pembayaran',
                        'public'
                    );

            // =====================================
            // SIMPAN PEMBAYARAN
            // =====================================
            $pembayaran = Pembayaran::create([

                'booking_id' =>
                    $booking->id,

                'tipe_pembayaran' =>
                    $request->tipe_pembayaran,

                'metode_pembayaran' =>
                    $request->metode_pembayaran,

                'nominal' =>
                    $request->nominal,

                'bukti_pembayaran' =>
                    $path,

                // admin otomatis valid
                'status_verifikasi' =>
                    'valid',

                'tanggal_pembayaran' =>
                    now(),

                'catatan' =>
                    $request->catatan
            ]);

            // =====================================
            // HITUNG TOTAL PEMBAYARAN VALID
            // =====================================
            $totalPembayaran =
                Pembayaran::where(
                    'booking_id',
                    $booking->id
                )
                ->where(
                    'status_verifikasi',
                    'valid'
                )
                ->sum('nominal');

            // =====================================
            // UPDATE STATUS BOOKING
            // =====================================
            if (
                $totalPembayaran >=
                $booking->total_harga_final
            ) {

                $booking->update([

                    'status_booking' =>
                        'dikonfirmasi',

                    'status_pembayaran' =>
                        'lunas'
                ]);
            }

            else {

                $booking->update([

                    'status_booking' =>
                        'dikonfirmasi',

                    'status_pembayaran' =>
                        'dp'
                ]);
            }

            DB::commit();

            return response()->json([

                'message' =>
                    'Pembayaran admin berhasil ditambahkan',

                'data' =>
                    $pembayaran
            ], 201);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
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
