<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Booking;
use App\Models\Fasilitas;

use App\Services\BookingService;

class AdminBookingController extends Controller
{
    protected $service;

    public function __construct(BookingService $service)
    {
        $this->service = $service;
    }

    // =========================================
    // LIST BOOKING
    // =========================================
    public function index()
    {
        return Booking::with([
            'paket',
            'fasilitas',
            'pembayaran'
        ])->get();
    }

    // =========================================
    // DETAIL BOOKING
    // =========================================
    public function show($id)
    {
        return Booking::with([
            'paket',
            'fasilitas',
            'pembayaran'
        ])->findOrFail($id);
    }

    // =========================================
    // UPDATE STATUS / RESCHEDULE / DISKON
    // =========================================
    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $booking->update([
            'status_booking' =>
                $request->status_booking
                ?? $booking->status_booking,

            'tanggal_kunjungan' =>
                $request->tanggal_kunjungan
                ?? $booking->tanggal_kunjungan,

            'diskon_manual' =>
                $request->diskon_manual
                ?? $booking->diskon_manual
        ]);

        // =========================================
        // HITUNG ULANG TOTAL
        // =========================================
        $total = $this->service->hitungTotal($booking);

        $final = $this->service->hitungFinal(
            $total,
            $booking->diskon_manual
        );

        $booking->update([
            'total_harga' => $total,
            'total_harga_final' => $final
        ]);

        return response()->json([
            'message' => 'Booking berhasil diupdate'
        ]);
    }

    // =========================================
    // TAMBAH FASILITAS
    // =========================================
    public function tambahFasilitas(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $booking->fasilitas()->attach(
            $request->fasilitas_id,
            ['jumlah' => $request->qty]
        );

        return response()->json([
            'message' => 'Fasilitas ditambahkan'
        ]);
    }

    // =========================================
    // CANCEL BOOKING
    // =========================================
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);

        $booking->update([
            'status_booking' => 'dibatalkan'
        ]);

        return response()->json([
            'message' => 'Booking dibatalkan'
        ]);
    }
}