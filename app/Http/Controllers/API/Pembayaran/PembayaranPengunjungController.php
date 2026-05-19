<?php

namespace App\Http\Controllers\API\Pembayaran;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\Models\Booking;
use App\Models\Pembayaran;

class PembayaranPengunjungController extends Controller
{
    // ======================================================
    // UPLOAD PEMBAYARAN PENGUNJUNG
    // ======================================================

    public function store(Request $request)
    {
        $request->validate([

            'kode_booking' =>
                'required|exists:booking,kode_booking',

            'metode_pembayaran' =>
                'required',

            'jenis_pembayaran' =>
                'required|in:dp,lunas',

            'bukti_pembayaran' =>
                'required|image|max:2048'
        ]);

        DB::beginTransaction();

        try {

            // ==============================================
            // CARI BOOKING
            // ==============================================

            $booking = Booking::where(
                'kode_booking',
                $request->kode_booking
            )->first();

            // ==============================================
            // CEK STATUS BOOKING
            // ==============================================

            if (
                $booking->status_booking
                == 'dibatalkan'
            ) {

                return response()->json([

                    'message' =>
                        'Booking sudah dibatalkan'

                ], 400);
            }

            // ==============================================
            // UPLOAD FILE
            // ==============================================

            $file = $request->file(
                'bukti_pembayaran'
            );

            $path = $file->store(
                'pembayaran',
                'public'
            );

            // ==============================================
            // HITUNG NOMINAL
            // ==============================================

            if (
                $request->jenis_pembayaran
                == 'dp'
            ) {

                $nominal =

                    $booking->total_harga_final
                    * 0.5;

            } else {

                $nominal =
                    $booking->total_harga_final;
            }

            // ==============================================
            // SIMPAN PEMBAYARAN
            // ==============================================

            $pembayaran = Pembayaran::create([

                'booking_id' =>
                    $booking->id,

                'metode_pembayaran' =>
                    $request->metode_pembayaran,

                'jenis_pembayaran' =>
                    $request->jenis_pembayaran,

                'nominal' =>
                    $nominal,

                'bukti_pembayaran' =>
                    $path,

                'status_pembayaran' =>
                    'menunggu_verifikasi'
            ]);

            // ==============================================
            // UPDATE STATUS BOOKING
            // ==============================================

            $booking->update([

                'status_booking' =>
                    'menunggu_verifikasi'
            ]);

            DB::commit();

            return response()->json([

                'message' =>
                    'Pembayaran berhasil dikirim',

                'data' => [

                    'kode_booking' =>
                        $booking->kode_booking,

                    'nominal' =>
                        $nominal,

                    'status_pembayaran' =>
                        'menunggu_verifikasi'
                ]
            ]);

        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([

                'message' =>
                    $e->getMessage()

            ], 500);
        }
    }
}