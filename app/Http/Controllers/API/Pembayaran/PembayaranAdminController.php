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
    // UPDATE VERIFIKASI PEMBAYARAN (ADMIN) - FIX TOTAL
    // ======================================================
    public function update(Request $request, $id)
    {
        $request->validate([
            'status_verifikasi' => 'required|in:pending,valid,ditolak',
            'nominal' => 'nullable',
            'catatan' => 'nullable|string'
        ]);

        DB::beginTransaction();

        try {
            $pembayaran = Pembayaran::find($id);

            if (!$pembayaran) {
                return back()->with('error', 'Pembayaran tidak ditemukan');
            }

            $booking = Booking::find($pembayaran->booking_id);

            if (!$booking) {
                return back()->with('error', 'Booking tidak ditemukan');
            }

            // Bersihkan nominal dari teks format rupiah jika ada pengganggu string
            $nominalInput = $request->nominal;
            if ($nominalInput !== null) {
                $nominalCleaned = preg_replace('/[^0-9]/', '', $nominalInput);
                // Jika input bernilai 0 atau kosong, pertahankan nominal lama yang ada di data awal/database (jangan dipaksa 0)
                $nominalFinal = ($nominalCleaned !== '' && (int)$nominalCleaned > 0) ? (int)$nominalCleaned : $pembayaran->nominal;
            } else {
                $nominalFinal = $pembayaran->nominal;
            }

            // Update data pembayaran Anda
            $pembayaran->update([
                'status_verifikasi' => $request->status_verifikasi,
                'nominal'           => $nominalFinal,
                'catatan'           => $request->catatan
            ]);

            // Jalankan sinkronisasi status booking
            $this->syncBooking($booking);

            DB::commit();
            return back()->with('success', 'Status verifikasi pembayaran berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui status: ' . $e->getMessage());
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

            // return response()->json([
            //     'message' => 'Pembayaran berhasil ditambahkan',
            //     'data' => $pembayaran
            // ], 201);

            return redirect()->back()->with('success', 'Pembayaran berhasil ditambahkan!');

        } catch (\Exception $e) {
            DB::rollBack();

            // return response()->json([
            //     'message' => $e->getMessage()
            // ], 500);

            redirect()->back()->with('error', 'Gagal menambahkan pembayaran: ' . $e->getMessage());
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

        public function detailBooking($bookingId)
    {
        $booking = Booking::with('pembayaran')
                    ->findOrFail($bookingId);

        return view(
            'admin.kelola_booking.modal_pembayaran',
            compact('booking')
        );
    }

  private function syncBooking($booking)
{
    // 💡 JIKA STATUS SUDAH 'SELESAI' ATAU 'DIBATALKAN' SECARA MANUAL, JANGAN DIUBAH LAGI
    if (in_array($booking->status_booking, ['selesai', 'dibatalkan'])) {
        return; // Berhenti di sini, biarkan statusnya tetap seperti itu
    }

    // 1. Hitung total nominal pembayaran yang murni berstatus VALID
    $totalValid = (int) Pembayaran::where('booking_id', $booking->id)
        ->where('status_verifikasi', 'valid')
        ->sum('nominal');

    // 2. Hitung jumlah transaksi yang masih PENDING dan DITOLAK
    $jumlahPending = Pembayaran::where('booking_id', $booking->id)->where('status_verifikasi', 'pending')->count();
    $jumlahDitolak = Pembayaran::where('booking_id', $booking->id)->where('status_verifikasi', 'ditolak')->count();

    // 3. Bersihkan nilai total_harga_final agar menjadi angka integer murni
    $totalTagihan = (int) preg_replace('/[^0-9]/', '', $booking->total_harga_final);

    // Ambil data pembayaran terakhir yang valid untuk dicek tipenya
    $pembayaranTerakhir = Pembayaran::where('booking_id', $booking->id)
        ->where('status_verifikasi', 'valid')
        ->latest()
        ->first();

    // === JALANKAN LOGIKA PENENTUAN STATUS OTOMATIS ===
    if ($totalValid >= $totalTagihan && $totalTagihan > 0) {
        $booking->update([
            'status_booking'    => 'dikonfirmasi',
            'status_pembayaran' => 'lunas'
        ]);
    } elseif ($totalValid > 0) {
        $tipeStatus = ($pembayaranTerakhir && $pembayaranTerakhir->tipe_pembayaran === 'lunas') ? 'lunas' : 'dp';
        $booking->update([
            'status_booking'    => 'dikonfirmasi',
            'status_pembayaran' => $tipeStatus
        ]);
    } else {
        if ($jumlahDitolak > 0 && $jumlahPending == 0) {
            $booking->update([
                'status_booking'    => 'dibatalkan',
                'status_pembayaran' => 'dp'
            ]);
        } else {
            $booking->update([
                'status_booking'    => 'pending',
                'status_pembayaran' => 'dp'
            ]);
        }
    }
}
}
