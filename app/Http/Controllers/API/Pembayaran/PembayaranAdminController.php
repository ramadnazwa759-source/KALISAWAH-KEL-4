<?php

namespace App\Http\Controllers\API\Pembayaran;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Pembayaran;
use App\Models\Booking;
use App\Models\Fasilitas;

class PembayaranAdminController extends Controller
{
    // =========================================
    // LIST SEMUA PEMBAYARAN
    // =========================================

    public function index()
    {
        return Pembayaran::with('booking')->get();
    }

    // =========================================
    // DETAIL PEMBAYARAN
    // =========================================

    public function show($id)
    {
        return Pembayaran::with('booking')->findOrFail($id);
    }

    // =========================================
    // VERIFIKASI PEMBAYARAN (ADMIN)
    // =========================================

    public function update(Request $request, $id)
    {
        $request->validate([
            'status_pembayaran' => 'required|in:dp,lunas,ditolak'
        ]);

        $pembayaran = Pembayaran::findOrFail($id);

        $pembayaran->update([
            'status_pembayaran' => $request->status_pembayaran
        ]);

        $booking = Booking::find($pembayaran->booking_id);

        // update status booking sesuai pembayaran
        if ($request->status_pembayaran == 'dp') {
            $booking->update([
                'status_booking' => 'dp_dibayar'
            ]);
        }

        if ($request->status_pembayaran == 'lunas') {
            $booking->update([
                'status_booking' => 'selesai'
            ]);
        }

        if ($request->status_pembayaran == 'ditolak') {
            $booking->update([
                'status_booking' => 'menunggu_pembayaran'
            ]);
        }

        return response()->json([
            'message' => 'Pembayaran berhasil diverifikasi'
        ]);
    }

    // =========================================
    // DELETE (opsional admin)
    // =========================================

    public function destroy($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->delete();

        return response()->json([
            'message' => 'Pembayaran dihapus'
        ]);
    }
}