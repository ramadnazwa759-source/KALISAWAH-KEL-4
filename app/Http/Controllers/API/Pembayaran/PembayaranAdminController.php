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
        return view('admin.kelola_pembayaran.pembayaran', [
            'pembayaran' => Pembayaran::with('booking')->latest()->get()
        ]);
    }

    // ======================================================
    // DETAIL PEMBAYARAN (JSON)
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
    // UPDATE VERIFIKASI PEMBAYARAN (ADMIN)
    // ======================================================
    public function update(Request $request, $id)
    {
        $request->validate([
            'status_verifikasi' => 'required|in:pending,valid,ditolak',
            'nominal' => 'required_if:status_verifikasi,valid|nullable|numeric|min:1',
            'catatan' => 'nullable|string'
        ]);

        DB::beginTransaction();

        try {

            $pembayaran = Pembayaran::find($id);

            if (!$pembayaran) {
                return response()->json([
                    'message' => 'Pembayaran tidak ditemukan'
                ], 404);
            }

            $booking = Booking::find($pembayaran->booking_id);

            if (!$booking) {
                return response()->json([
                    'message' => 'Booking tidak ditemukan'
                ], 404);
            }

            // UPDATE PEMBAYARAN
            $pembayaran->update([
                'status_verifikasi' => $request->status_verifikasi,
                'nominal' => $request->status_verifikasi == 'valid'
                    ? $request->nominal
                    : null,
                'catatan' => $request->catatan
            ]);

            $this->syncBooking($booking);

            DB::commit();

            return response()->json([
                'message' => 'Verifikasi pembayaran berhasil',
                'data' => $pembayaran->load('booking')
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // ======================================================
    // STORE PEMBAYARAN MANUAL ADMIN
    // ======================================================
    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:booking,id',
            'tipe_pembayaran' => 'required|in:dp,lunas',
            'metode_pembayaran' => 'required|in:transfer,cash,qris',
            'nominal' => 'required|numeric|min:1',
            'bukti_pembayaran' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'catatan' => 'nullable|string'
        ]);

        DB::beginTransaction();

        try {

            $booking = Booking::findOrFail($request->booking_id);

            $path = $request->file('bukti_pembayaran')
                ->store('pembayaran', 'public');

            $pembayaran = Pembayaran::create([
                'booking_id' => $booking->id,
                'tipe_pembayaran' => $request->tipe_pembayaran,
                'metode_pembayaran' => $request->metode_pembayaran,
                'nominal' => $request->nominal,
                'bukti_pembayaran' => $path,
                'status_verifikasi' => 'valid',
                'tanggal_pembayaran' => now(),
                'catatan' => $request->catatan
            ]);

            $this->syncBooking($booking);

            DB::commit();

            return response()->json([
                'message' => 'Pembayaran berhasil ditambahkan',
                'data' => $pembayaran
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // ======================================================
    // DELETE PEMBAYARAN
    // ======================================================
    public function destroy($id)
    {
        $data = Pembayaran::find($id);

        if (!$data) {
            return response()->json([
                'message' => 'Data pembayaran tidak ditemukan'
            ], 404);
        }

        if ($data->bukti_pembayaran) {
            Storage::disk('public')->delete($data->bukti_pembayaran);
        }

        $data->delete();

        return response()->json([
            'message' => 'Pembayaran berhasil dihapus'
        ], 200);
    }

    // ======================================================
    // SYNC STATUS BOOKING (FIX INTI)
    // ======================================================
    private function syncBooking($booking)
    {
        $total = Pembayaran::where('booking_id', $booking->id)
            ->where('status_verifikasi', 'valid')
            ->sum('nominal');

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
    }
}