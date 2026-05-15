<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookingFasilitas;
use App\Models\Fasilitas;

class BookingFasilitasController extends Controller
{
    // GET /api/booking-fasilitas
    public function index()
    {
        return response()->json(BookingFasilitas::all(), 200);
    }

    // POST /api/booking-fasilitas
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_booking'   => 'required|exists:booking,id',
            'id_fasilitas' => 'required|exists:fasilitas,id',
            'jumlah'       => 'required|integer|min:1',
        ]);

        $fasilitas = Fasilitas::findOrFail($validated['id_fasilitas']);

        // CEK STOK DULU
        if ($fasilitas->stok < $validated['jumlah']) {
            return response()->json([
                'message' => 'Stok fasilitas tidak mencukupi'
            ], 400);
        }

        // SIMPAN booking_fasilitas
        $data = BookingFasilitas::create($validated);

        // KURANGI STOK
        $fasilitas->stok -= $validated['jumlah'];
        $fasilitas->save();

        return response()->json([
            'message' => 'Booking fasilitas berhasil & stok berkurang',
            'data'    => $data
        ], 201);
    }

    // GET /api/booking-fasilitas/{id}
    public function show($id)
    {
        return response()->json(BookingFasilitas::findOrFail($id), 200);
    }

    // PUT /api/booking-fasilitas/{id}
    public function update(Request $request, $id)
    {
        $bookingFasilitas = BookingFasilitas::findOrFail($id);

        $validated = $request->validate([
            'id_fasilitas' => 'required|exists:fasilitas,id',
            'jumlah'       => 'required|integer|min:1',
        ]);

        $fasilitas = Fasilitas::findOrFail($validated['id_fasilitas']);

        // KEMBALIKAN STOK LAMA DULU
        $fasilitas->stok += $bookingFasilitas->jumlah;

        // CEK STOK BARU
        if ($fasilitas->stok < $validated['jumlah']) {
            return response()->json([
                'message' => 'Stok fasilitas tidak mencukupi untuk update'
            ], 400);
        }

        // KURANGI SESUAI JUMLAH BARU
        $fasilitas->stok -= $validated['jumlah'];
        $fasilitas->save();

        // UPDATE DATA
        $bookingFasilitas->update($validated);

        return response()->json([
            'message' => 'Booking fasilitas berhasil diupdate & stok disesuaikan',
            'data'    => $bookingFasilitas
        ], 200);
    }

    // DELETE /api/booking-fasilitas/{id}
    public function destroy($id)
    {
        $bookingFasilitas = BookingFasilitas::findOrFail($id);
        $fasilitas = Fasilitas::findOrFail($bookingFasilitas->id_fasilitas);

        // KEMBALIKAN STOK
        $fasilitas->stok += $bookingFasilitas->jumlah;
        $fasilitas->save();

        $bookingFasilitas->delete();

        return response()->json([
            'message' => 'Booking fasilitas dihapus & stok dikembalikan'
        ], 200);
    }
}