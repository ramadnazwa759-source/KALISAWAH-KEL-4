<?php

namespace App\Http\Controllers\API\Pembayaran;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Pembayaran;
use App\Models\Booking;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PembayaranAdminController extends Controller
{
    // ======================================================
    // LIST PEMBAYARAN
    // ======================================================
    public function index()
    {
        // return response()->json(
        //     Pembayaran::with('booking')->latest()->get(),
        //     200
        // );
        return view('admin.kelola_pembayaran.pembayaran', ['pembayaran' => Pembayaran::with('booking')->latest()->get()]);
    }

    // ======================================================
    // DETAIL PEMBAYARAN
    // ======================================================
    public function show($id)
    {
        $data = Pembayaran::with('booking')->find($id);

        if (!$data) {

            return response()->json([
                'message' => 'Data pembayaran tidak ditemukan'
            ], 404);
        }

        return response()->json($data, 200);
    }

    // ======================================================
    // ADMIN MENENTUKAN NOMINAL VALID
    // ======================================================
    public function update(Request $request, $id)
    {
        $request->validate([

            'status_verifikasi' =>
                'required|in:valid,ditolak',

            // ADMIN INPUT NOMINAL ASLI
            'nominal' =>
                'required_if:status_verifikasi,valid|nullable|numeric|min:1',
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

            $booking = Booking::find(
                $pembayaran->booking_id
            );

            if (!$booking) {

                return response()->json([
                    'message' => 'Booking tidak ditemukan'
                ], 404);
            }

            // =====================================
            // UPDATE PEMBAYARAN
            // =====================================
            $pembayaran->update([

                'status_verifikasi' =>
                    $request->status_verifikasi,

                // nominal asli diisi admin
                'nominal' =>
                    $request->status_verifikasi == 'valid'
                        ? $request->nominal
                        : null,

                'catatan' =>
                    $request->catatan
            ]);

            // =====================================
            // JIKA VALID
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

                // ================================
                // SUDAH LUNAS
                // ================================
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

                // ================================
                // MASIH DP
                // ================================
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
    // TAMBAH PEMBAYARAN MANUAL OLEH ADMIN
    // CASH / QRIS / TRANSFER DI TEMPAT
    // ======================================================
    public function store(Request $request)
    {
        $request->validate([

            'booking_id' =>
                'required|exists:booking,id',

            'tipe_pembayaran' =>
                'required|in:dp,lunas',

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
            // UPLOAD FOTO BUKTI
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

                // otomatis valid
                'status_verifikasi' =>
                    'valid',

                'tanggal_pembayaran' =>
                    now(),

                'catatan' =>
                    $request->catatan
            ]);

            // =====================================
            // TOTAL PEMBAYARAN VALID
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
                    'Pembayaran berhasil ditambahkan',

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
                'message' => 'Data pembayaran tidak ditemukan'
            ], 404);
        }

        // hapus file bukti
        if ($data->bukti_pembayaran) {

            Storage::disk('public')->delete(
                $data->bukti_pembayaran
            );
        }

        $data->delete();

        return response()->json([
            'message' => 'Pembayaran berhasil dihapus'
        ], 200);
    }
}
