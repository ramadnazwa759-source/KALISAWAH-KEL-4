<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Booking;
use App\Models\BookingItem;
use App\Models\BookingFasilitas;
use App\Models\PaketWisata;
use App\Models\Fasilitas;

class BookingController extends Controller
{
    public function storeUser(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'no_hp' => 'required|string',
            'tanggal' => 'required|date',
            'jam' => 'required',

            'paket' => 'required|array',
            'paket.*.paket_wisata_id' => 'required|exists:paket_wisata,id',
            'paket.*.qty' => 'required|integer|min:1',

            'fasilitas' => 'nullable|array',
            'fasilitas.*.fasilitas_id' => 'exists:fasilitas,id',
            'fasilitas.*.qty' => 'integer|min:1',
        ]);

        DB::beginTransaction();

        try {

            // 1. CREATE BOOKING
            $booking = Booking::create([
                'nama' => $request->nama,
                'no_hp' => $request->no_hp,
                'tanggal' => $request->tanggal,
                'jam' => $request->jam,
                'status' => 'pending',
                'total_harga' => 0
            ]);

            $total = 0;

            // 2. SIMPAN PAKET
            foreach ($request->paket as $item) {

                $paket = PaketWisata::find($item['paket_wisata_id']);

                $subtotal = $paket->harga * $item['qty'];

                BookingItem::create([
                    'booking_id' => $booking->id,
                    'paket_wisata_id' => $paket->id,
                    'qty' => $item['qty'],
                    'harga' => $paket->harga,
                    'subtotal' => $subtotal
                ]);

                $total += $subtotal;
            }

            // 3. SIMPAN FASILITAS + KURANGI STOK
            if ($request->fasilitas) {

                foreach ($request->fasilitas as $item) {

                    $fasilitas = Fasilitas::find($item['fasilitas_id']);

                    // cek tipe
                    if ($fasilitas->tipe_fasilitas !== 'sewa') {
                        continue; // skip kalau bukan sewa
                    }

                    // cek stok
                    if ($item['qty'] > $fasilitas->stok) {
                        return response()->json([
                            'message' => "Stok {$fasilitas->nama_fasilitas} tidak cukup"
                        ], 422);
                    }

                    $subtotal = $fasilitas->harga * $item['qty'];

                    BookingFasilitas::create([
                        'booking_id' => $booking->id,
                        'fasilitas_id' => $fasilitas->id,
                        'qty' => $item['qty'],
                        'harga' => $fasilitas->harga,
                        'subtotal' => $subtotal
                    ]);

                    // kurangi stok
                    $fasilitas->stok -= $item['qty'];
                    $fasilitas->save();

                    $total += $subtotal;
                }
            }

            // 4. UPDATE TOTAL BOOKING
            $booking->update([
                'total_harga' => $total
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Booking berhasil dibuat',
                'data' => $booking
            ], 201);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'message' => 'Booking gagal',
                'error' => $e->getMessage()
            ], 500);
        }
    }

        public function showUser($id)
    {
        $booking = Booking::with([
            'items.paketWisata',
            'fasilitas.fasilitas'
        ])->find($id);

        if (!$booking) {
            return response()->json([
                'message' => 'Booking tidak ditemukan'
            ], 404);
        }

        // hitung ulang (biar aman & update real-time)
        $totalPaket = $booking->items->sum('subtotal');
        $totalFasilitas = $booking->fasilitas->sum('subtotal');

        $grandTotal = $totalPaket + $totalFasilitas;

        return response()->json([
            'booking' => $booking,
            'detail' => [
                'total_paket' => $totalPaket,
                'total_fasilitas' => $totalFasilitas,
                'grand_total' => $grandTotal,
                'sudah_dibayar' => 0, // nanti dari payment
                'sisa_bayar' => $grandTotal
            ]
        ], 200);
    }
}