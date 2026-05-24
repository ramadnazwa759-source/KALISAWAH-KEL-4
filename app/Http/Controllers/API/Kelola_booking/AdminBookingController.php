<?php

namespace App\Http\Controllers\API\Kelola_booking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Booking;
use App\Models\BookingItem;
use App\Models\BookingFasilitas;

use App\Models\PaketWisata;
use App\Models\Fasilitas;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AdminBookingController extends Controller
{
    // =========================================
    // TAMPIL SEMUA BOOKING
    // =========================================
    public function index()
    {
        $data = Booking::with([
            'bookingItem.paketWisata',
            'bookingFasilitas.fasilitas',
            'pembayaran'
        ])->latest()->get();

        // return response()->json($data, 200);
        return view('admin.kelola_booking.index', compact('data'));
    }

    // =========================================
    // DETAIL BOOKING
    // =========================================
    public function show($id)
    {
        $booking = Booking::with([
            'bookingItem.paketWisata',
            'bookingFasilitas.fasilitas',
            'pembayaran'
        ])->find($id);

        if (!$booking) {
            // return response()->json([
            //     'message' => 'Booking tidak ditemukan'
            // ], 404);
            return redirect()->route('admin.booking-admin.index')->with('error', 'Booking tidak ditemukan');
        }

        // return response()->json($booking, 200);
        return view('admin.kelola_booking.show', compact('booking'));
    }

    // =========================================
    // TAMBAH BOOKING MANUAL OLEH ADMIN
    // =========================================
    public function store(Request $request)
    {
        // JIKA ADMIN KLIK "+ TAMBAH" (REQUEST BERUPA GET)
        // ---------------------------------------------------------------
        if ($request->isMethod('get')) {
            $paketWisata = PaketWisata::all();
            // $fasilitas = Fasilitas::all();
            // wawa yang nambah
            $fasilitas = Fasilitas::where('tipe_fasilitas', 'sewa')
                          ->where('status', 'aktif')
                          ->where('stok', '>', 0)
                          ->get();

            return view('admin.kelola_booking.create', compact('paketWisata', 'fasilitas'));
        }

        $request->validate([

            'nama_pemesan' => 'required|string|max:255',

            'no_hp' => 'required|string|max:20',

            'tanggal_kunjungan' => 'required|date',

            'jam' => 'required',

            'jumlah_pengunjung' => 'required|integer|min:1',

            'catatan' => 'nullable|string',

            // paket wisata
            'paket' => 'required|array|min:1',

            'paket.*.paket_wisata_id' =>
                'required|exists:paket_wisata,id',

            'paket.*.qty' =>
                'required|integer|min:1',

            // fasilitas tambahan
            'fasilitas' => 'nullable|array',

            'fasilitas.*.fasilitas_id' =>
                'required|exists:fasilitas,id',

            'fasilitas.*.qty' =>
                'required|integer|min:1',

            // diskon
            'diskon_manual' =>
                'nullable|numeric|min:0'
        ]);

        DB::beginTransaction();

        try {

            // =====================================
            // GENERATE KODE BOOKING
            // =====================================
            $kodeBooking =
                'KLS-' . strtoupper(Str::random(8));

            // =====================================
            // VARIABLE TOTAL
            // =====================================
            $subtotalPaket = 0;

            $subtotalFasilitas = 0;

            $subtotalTiketTambahan = 0;

            $jumlahTiketTambahan = 0;

            // =====================================
            // HITUNG TOTAL KAPASITAS
            // =====================================
            $totalKapasitas = 0;

            foreach ($request->paket as $item) {

                $paket = PaketWisata::findOrFail(
                    $item['paket_wisata_id']
                );

                $totalKapasitas +=
                    $paket->kapasitas * $item['qty'];
            }

            // =====================================
            // HITUNG TIKET TAMBAHAN
            // =====================================
            if (
                $request->jumlah_pengunjung >
                $totalKapasitas
            ) {

                $jumlahTiketTambahan =
                    $request->jumlah_pengunjung -
                    $totalKapasitas;

                $subtotalTiketTambahan =
                    $jumlahTiketTambahan * 25000;
            }

            // =====================================
            // HITUNG TOTAL PAKET
            // =====================================
            foreach ($request->paket as $item) {

                $paket = PaketWisata::findOrFail(
                    $item['paket_wisata_id']
                );

                $subtotal =
                    $paket->harga * $item['qty'];

                $subtotalPaket += $subtotal;
            }

            // =====================================
            // HITUNG TOTAL FASILITAS
            // =====================================
            if ($request->fasilitas) {

                foreach ($request->fasilitas as $item) {

                    $fasilitas = Fasilitas::findOrFail(
                        $item['fasilitas_id']
                    );

                    // =================================
                    // CEK STOK FASILITAS SEWA
                    // =================================
                    if (
                        $fasilitas->tipe_fasilitas
                        == 'sewa'
                    ) {

                        if (
                            $fasilitas->stok <
                            $item['qty']
                        ) {

                            DB::rollBack();

                            return response()->json([
                                'message' =>
                                    'Stok fasilitas ' .
                                    $fasilitas->nama_fasilitas .
                                    ' tidak mencukupi'
                            ], 422);
                        }
                    }

                    $subtotal =
                        $fasilitas->harga *
                        $item['qty'];

                    $subtotalFasilitas +=
                        $subtotal;
                }
            }

            // =====================================
            // TOTAL HARGA
            // =====================================
            $totalHarga =
                $subtotalPaket +
                $subtotalFasilitas +
                $subtotalTiketTambahan;

            // =====================================
            // DISKON
            // =====================================
            $diskonManual =
                $request->diskon_manual ?? 0;

            // =====================================
            // TOTAL AKHIR + SAFEGUARD
            // =====================================
            $totalHargaFinal = max(
                0,
                $totalHarga - $diskonManual
            );

            // =====================================
            // SIMPAN BOOKING
            // =====================================
            $booking = Booking::create([

                'kode_booking' =>
                    $kodeBooking,

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
                    $diskonManual,

                'total_harga_final' =>
                    $totalHargaFinal,

                'status_booking' =>
                    'pending',

                'status_pembayaran' =>
                    'belum_bayar'
            ]);

            // =====================================
            // SIMPAN BOOKING ITEM
            // =====================================
            foreach ($request->paket as $item) {

                $paket = PaketWisata::findOrFail(
                    $item['paket_wisata_id']
                );

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
                        $paket->harga *
                        $item['qty']
                ]);
            }

            // =====================================
            // SIMPAN BOOKING FASILITAS
            // =====================================
            if ($request->fasilitas) {

                foreach (
                    $request->fasilitas
                    as $item
                ) {

                    $fasilitas =
                        Fasilitas::findOrFail(
                            $item['fasilitas_id']
                        );

                    // =============================
                    // KURANGI STOK FASILITAS SEWA
                    // =============================
                    if (
                        $fasilitas->tipe_fasilitas
                        == 'sewa'
                    ) {

                        $fasilitas->decrement(
                            'stok',
                            $item['qty']
                        );
                    }

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
                            $fasilitas->harga *
                            $item['qty']
                    ]);
                }
            }

            DB::commit();

            // return response()->json([

            //     'message' =>
            //         'Booking berhasil dibuat',

            //     'booking_id' =>
            //         $booking->id,

            //     'kode_booking' =>
            //         $booking->kode_booking,

            //     'total_harga' =>
            //         $booking->total_harga,

            //     'diskon_manual' =>
            //         $booking->diskon_manual,

            //     'total_harga_final' =>
            //         $booking->total_harga_final,

            //     'status_booking' =>
            //         $booking->status_booking,

            //     'status_pembayaran' =>
            //         $booking->status_pembayaran
            // ], 201);

            return redirect()
                ->route('admin.booking-admin.index')
                ->with('success', 'Booking berhasil dibuat');

        } catch (\Exception $e) {

            DB::rollBack();

            // return response()->json([
            //     'message' => $e->getMessage()
            // ], 500);



        }
    }

    // =========================================
    // UPDATE BOOKING
    // =========================================
    public function update(Request $request, $id)
    {
        $booking = Booking::with(
            'bookingFasilitas.fasilitas'
        )->find($id);

        if (!$booking) {

            // return response()->json([
            //     'message' => 'Booking tidak ditemukan'
            // ], 404);
            return redirect()->route('admin.booking-admin.edit', $id)->with('error', 'Booking tidak ditemukan');
        }

        $request->validate([

            'status_booking' =>
                'nullable|in:pending,dikonfirmasi,selesai,dibatalkan',

            'status_pembayaran' =>
                'nullable|in:belum_bayar,dp,lunas',

            'diskon_manual' =>
                'nullable|numeric|min:0',

            'catatan' =>
                'nullable|string'
        ]);

        DB::beginTransaction();

        try {

            // =====================================
            // KEMBALIKAN STOK
            // JIKA BOOKING DIBATALKAN
            // =====================================
            if (

                $booking->status_booking
                != 'dibatalkan'

                &&

                $request->status_booking
                == 'dibatalkan'

            ) {

                foreach (
                    $booking->bookingFasilitas
                    as $item
                ) {

                    $fasilitas =
                        $item->fasilitas;

                    if (

                        $fasilitas &&

                        $fasilitas->tipe_fasilitas
                        == 'sewa'

                    ) {

                        $fasilitas->increment(
                            'stok',
                            $item->qty
                        );
                    }
                }
            }

            // =====================================
            // UPDATE DISKON
            // =====================================
            $diskonManual =
                $request->diskon_manual
                ?? $booking->diskon_manual;

            // =====================================
            // HITUNG TOTAL FINAL
            // =====================================
            $totalHargaFinal = max(
                0,
                $booking->total_harga -
                $diskonManual
            );

            // =====================================
            // UPDATE BOOKING
            // =====================================
            $booking->update([

                'status_booking' =>
                    $request->status_booking
                    ?? $booking->status_booking,

                'status_pembayaran' =>
                    $request->status_pembayaran
                    ?? $booking->status_pembayaran,

                'catatan' =>
                    $request->catatan
                    ?? $booking->catatan,

                'diskon_manual' =>
                    $diskonManual,

                'total_harga_final' =>
                    $totalHargaFinal
            ]);

            DB::commit();

            // return response()->json([

            //     'message' =>
            //         'Booking berhasil diupdate',

            //     'data' => $booking
            // ], 200);

            return redirect()->route('admin.booking-admin.index')->with('success', 'Booking berhasil diupdate');

        } catch (\Exception $e) {

            DB::rollBack();

            // return response()->json([
            //     'message' => $e->getMessage()
            // ], 500);

            return redirect()->route('admin.booking-admin.index')->with('error', 'Terjadi kesalahan saat mengupdate booking: ' . $e->getMessage());
        }
    }

    // =========================================
    // HAPUS BOOKING
    // =========================================
    public function destroy($id)
    {
        $booking = Booking::with(
            'bookingFasilitas.fasilitas'
        )->find($id);

        if (!$booking) {

            // return response()->json([
            //     'message' => 'Booking tidak ditemukan'
            // ], 404);
            return redirect()->route('admin.booking-admin.index')->with('error', 'Booking tidak ditemukan');
        }

        DB::beginTransaction();

        try {

            // =====================================
            // KEMBALIKAN STOK
            // =====================================
            foreach (
                $booking->bookingFasilitas
                as $item
            ) {

                $fasilitas =
                    $item->fasilitas;

                if (

                    $fasilitas &&

                    $fasilitas->tipe_fasilitas
                    == 'sewa'

                ) {

                    $fasilitas->increment(
                        'stok',
                        $item->qty
                    );
                }
            }

            // =====================================
            // HAPUS RELASI
            // =====================================
            $booking->bookingItem()->delete();

            $booking->bookingFasilitas()->delete();

            $booking->pembayaran()->delete();

            // =====================================
            // HAPUS BOOKING
            // =====================================
            $booking->delete();

            DB::commit();

            // return response()->json([
            //     'message' => 'Booking berhasil dihapus'
            // ], 200);
            return redirect()->route('admin.booking-admin.index')->with('success', 'Booking berhasil dihapus');


        } catch (\Exception $e) {

            DB::rollBack();

            // return response()->json([
            //     'message' => $e->getMessage()
            // ], 500);
            return redirect()->route('admin.booking-admin.index')->with('error', 'Terjadi kesalahan saat menghapus booking: ' . $e->getMessage());
        }
    }
}
