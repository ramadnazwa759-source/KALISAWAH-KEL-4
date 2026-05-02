<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    //GET /api/admin/bookings
    public function index()
    {
        $bookings = Booking::with(['fasilitas', 'pembayaran'])->get();

        return response()->json([
            'success' => true,
            'message' => 'List booking berhasil diambil',
            'data' => $bookings
        ]);
    }

    //GET /api/admin/bookings/{id}
    public function show($id)
    {
        $booking = Booking::with(['fasilitas', 'pembayaran'])
                    ->findOrFail($id);

        return response()->json([
            'success' => true,
            'message' => 'Detail booking',
            'data' => $booking
        ]);
    }

    //POST /api/admin/bookings
    public function store(Request $request)
    {
        $request->validate([
            'nama_pemesan' => 'required',
            'tanggal_kunjungan' => 'required',
        ]);

        $booking = Booking::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Booking berhasil dibuat',
            'data' => $booking
        ]);
    }

    //PUT /api/admin/bookings/{id}
    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $booking->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Booking berhasil diupdate',
            'data' => $booking
        ]);
    }

    //DELETE /api/admin/bookings/{id}
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return response()->json([
            'success' => true,
            'message' => 'Booking berhasil dihapus'
        ]);
    }
}