<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    // GET all booking
    public function index()
    {
        return Booking::with(['paket', 'pembayaran', 'fasilitas'])->get();
    }

    // GET detail booking
    public function show($id)
    {
        return Booking::with(['paket', 'pembayaran', 'fasilitas'])
            ->findOrFail($id); // ✔ FIX
    }

    // CREATE booking
    public function store(Request $request)
    {
        $request->validate([
            'kode_booking' => 'required',
            'nama_pemesan' => 'required',
            'no_hp' => 'required',
            'id_paket' => 'required|exists:paket_wisata,id',
            'tanggal_kunjungan' => 'required|date',
            'jam' => 'required',
            'jumlah_orang' => 'required|integer',
            'status_booking' => 'required'
        ]);

        $booking = Booking::create($request->all());

        return response()->json([
            'message' => 'Booking berhasil masuk',
            'data' => $booking
        ]);
    }

    // booking untuk pengunjung
    public function storeUser(Request $request)
{
    $request->validate([
        'nama_pemesan' => 'required',
        'no_hp' => 'required',
        'id_paket' => 'required|exists:paket_wisata,id',
        'tanggal_kunjungan' => 'required|date',
        'jam' => 'required',
        'jumlah_orang' => 'required|integer',
    ]);

    $booking = Booking::create([
        'kode_booking' => 'KB-' . time(), // auto generate
        'nama_pemesan' => $request->nama_pemesan,
        'no_hp' => $request->no_hp,
        'id_paket' => $request->id_paket,
        'tanggal_kunjungan' => $request->tanggal_kunjungan,
        'jam' => $request->jam,
        'jumlah_orang' => $request->jumlah_orang,
        'jumlah_tenda' => $request->jumlah_tenda,
        'catatan' => $request->catatan,
        'status_booking' => 'pending' // default
    ]);

    return response()->json([
        'message' => 'Booking berhasil, menunggu konfirmasi admin',
        'data' => $booking
    ]);
}

    // UPDATE booking
    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id); // ✔ FIX

        $booking->update($request->all());

        return response()->json([
            'message' => 'Booking berhasil diupdate',
            'data' => $booking
        ]);
    }

    // DELETE booking
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id); // ✔ FIX
        $booking->delete();

        return response()->json([
            'message' => 'Booking berhasil dihapus'
        ]);
    }
}