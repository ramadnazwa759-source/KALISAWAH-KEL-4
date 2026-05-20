<?php

namespace App\Http\Controllers\API\Booking_pengunjung;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Booking;
use App\Models\BookingItem;
use App\Models\BookingFasilitas;

use App\Models\PaketWisata;
use App\Models\Fasilitas;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([

            'nama_pemesan' => 'required|string|max:255',

            'no_hp' => 'required|string|max:20',

            'tanggal_kunjungan' => 'required|date',

            'jam' => 'required',

            'jumlah_pengunjung' => 'required|integer|min:1',

            'catatan' => 'nullable|string',

            // paket wisata
            'paket' => 'required|array|min:1',

            'paket.*.id_paket' => 'required|exists:paket_wisata,id',

            'paket.*.qty' => 'required|integer|min:1',

            // fasilitas tambahan
            'fasilitas' => 'nullable|array',

            'fasilitas.*.id_fasilitas' =>
                'required|exists:fasilitas,id',

            'fasilitas.*.qty' =>
                'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {

            // =========================
            // TOTAL HARGA
            // =========================

            $totalHarga = 0;

            $jumlahTiketTambahan = 0;

            $subtotalTiketTambahan = 0;

            // =========================
            // HITUNG PAKET
            // =========================

            foreach ($request->paket as $item) {

                $paket = PaketWisata::find($item['id_paket']);

                $subtotalPaket =
                    $paket->harga * $item['qty'];

                $totalHarga += $subtotalPaket;

                // =========================
                // CEK KAPASITAS
                // =========================

                $totalKapasitas =
                    $paket->kapasitas * $item['qty'];

                // jika pengunjung melebihi kapasitas
                if ($request->jumlah_pengunjung > $totalKapasitas) {

                    $jumlahTiketTambahan =
                        $request->jumlah_pengunjung
                        - $totalKapasitas;

                    $subtotalTiketTambahan =
                        $jumlahTiketTambahan * 25000;

                    $totalHarga +=
                        $subtotalTiketTambahan;
                }
            }

            // =========================
            // HITUNG FASILITAS TAMBAHAN
            // =========================

            if ($request->fasilitas) {

                foreach ($request->fasilitas as $item) {

                    $fasilitas =
                        Fasilitas::find($item['id_fasilitas']);

                    $subtotalFasilitas =
                        $fasilitas->harga * $item['qty'];

                    $totalHarga +=
                        $subtotalFasilitas;
                }
            }

            // =========================
            // BUAT BOOKING
            // =========================

            $booking = Booking::create([

                'kode_booking' =>
                    'KLS-' . strtoupper(Str::random(8)),

                'nama_pemesan' =>
                    $request->nama_pemesan,

                'no_hp' =>
                    $request->no_hp,

                'tanggal_kunjungan' =>
                    $request->tanggal_kunjungan,

                'jam' =>
                    $request->jam,

                'jumlah_pengunjung' =>
                    $request->jumlah_pengunjung,

                'jumlah_tiket_tambahan' =>
                    $jumlahTiketTambahan,

                'harga_tiket_tambahan' =>
                    25000,

                'subtotal_tiket_tambahan' =>
                    $subtotalTiketTambahan,

                'catatan' =>
                    $request->catatan,

                'total_harga' =>
                    $totalHarga,

                'diskon_manual' =>
                    0,

                'total_harga_final' =>
                    $totalHarga,

                'status_booking' =>
                    'pending',

                'status_pembayaran' =>
                    'belum_bayar',
            ]);

            // =========================
            // SIMPAN BOOKING ITEM
            // =========================

            foreach ($request->paket as $item) {

                $paket = PaketWisata::find($item['id_paket']);

                BookingItem::create([

                    'booking_id' =>
                        $booking->id,

                    'paket_wisata_id' =>
                        $paket->id,

                    'qty' =>
                        $item['qty'],

                    'harga' =>
                        $paket->harga,

                    'subtotal' =>
                        $paket->harga * $item['qty'],
                ]);
            }

            // =========================
            // SIMPAN BOOKING FASILITAS
            // =========================

            if ($request->fasilitas) {

                foreach ($request->fasilitas as $item) {

                    $fasilitas =
                        Fasilitas::find($item['id_fasilitas']);

                    BookingFasilitas::create([

                        'booking_id' =>
                            $booking->id,

                        'fasilitas_id' =>
                            $fasilitas->id,

                        'qty' =>
                            $item['qty'],

                        'harga' =>
                            $fasilitas->harga,

                        'subtotal' =>
                            $fasilitas->harga
                            * $item['qty'],
                    ]);
                }
            }

            DB::commit();

            return response()->json([

                'message' =>
                    'Booking berhasil dibuat',

                'booking_id' =>
                    $booking->id,

                'kode_booking' =>
                    $booking->kode_booking,

                'status_booking' =>
                    $booking->status_booking,

                'status_pembayaran' =>
                    $booking->status_pembayaran,

                'total_harga' =>
                    $booking->total_harga_final,

                'jumlah_tiket_tambahan' =>
                    $booking->jumlah_tiket_tambahan,
            ], 201);

        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([

                'message' => 'Booking gagal',

                'error' => $e->getMessage()

            ], 500);
        }
    }
}