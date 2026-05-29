<?php

namespace App\Http\Controllers\API\Booking_pengunjung;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\Models\Booking;
use App\Models\PaketWisata;
use App\Models\Fasilitas;
use App\Models\KategoriPaket;
use App\Models\KategoriFasilitas;

class PengunjungBookingController extends Controller
{
    /* =========================================================
        1. FORM
    ========================================================= */

    public function showForm()
    {
        return view('pengunjung.booking.booking-form', [
            'kategoriPaket' => KategoriPaket::all(),

            'paket' => PaketWisata::with('kategori')
                ->where('status', 'aktif')
                ->get(),

            'kategoriFasilitas' => KategoriFasilitas::all(),

            'fasilitas' => Fasilitas::with('kategori')
                ->where('tipe_fasilitas', 'sewa')
                ->where('stok', '>', 0)
                ->get(),
        ]);
    }

    public function getPaketByKategori($id)
    {
        return response()->json(
            PaketWisata::where('kategori_paket_id', $id)
                ->where('status', 'aktif')
                ->get()
        );
    }

    public function getFasilitasByKategori($kategoriId)
    {
        return response()->json(
            Fasilitas::where('kategori_fasilitas_id', $kategoriId)
                ->where('tipe_fasilitas', 'sewa')
                ->where('stok', '>', 0)
                ->get()
        );
    }

    /* =========================================================
        2. REVIEW BOOKING
    ========================================================= */

    public function review(Request $request)
    {
        $request->validate([
            'nama_pemesan' => 'required|string',
            'no_hp' => 'required',
            'tanggal_kunjungan' => 'required|date',
            'tanggal_checkout' => 'required|date',
            'jumlah_pengunjung' => 'required|integer|min:1',
            'jumlah_malam' => 'required|integer|min:1',
            'jam' => 'required'
        ]);

        session([
            'temp_booking_data' => $request->all()
        ]);

        $booking = (object) $request->all();

        $jumlahMalam = (int) $request->jumlah_malam;
        $jumlahHari = $jumlahMalam + 1;

        $structuredItems = collect();
        $structuredFasilitas = collect();

        $total = 0;

        $tanggalAwal = Carbon::parse($request->tanggal_kunjungan);

        /* =========================
           PAKET
        ========================= */

        if ($request->has('paket')) {

            foreach ($request->paket as $hari => $paketIds) {

                foreach ($paketIds as $paketId) {

                    $paket = PaketWisata::find($paketId);
                    if (!$paket) continue;

                    $qty = (int) ($request->paket_qty[$hari][$paketId] ?? 1);
                    $subtotal = $paket->harga * $qty;

                    $tanggalItem =
                        $tanggalAwal->copy()->addDays((int)$hari)->toDateString();

                    $structuredItems->push((object)[
                        'hari' => (int)$hari,
                        'tanggal' => $tanggalItem,
                        'paket_wisata_id' => $paketId,
                        'qty' => $qty,
                        'harga' => $paket->harga,
                        'subtotal' => $subtotal,
                        'paketWisata' => $paket
                    ]);

                    $total += $subtotal;
                }
            }
        }

        /* =========================
           FASILITAS
        ========================= */

        if ($request->has('fasilitas')) {

            foreach ($request->fasilitas as $hari => $fasList) {

                foreach ($fasList as $fasId => $qty) {

                    $qty = (int)$qty;
                    if ($qty <= 0) continue;

                    $fas = Fasilitas::find($fasId);
                    if (!$fas) continue;

                    $subtotal = $fas->harga * $qty;

                    $tanggalFasilitas =
                        $tanggalAwal->copy()->addDays((int)$hari)->toDateString();

                    $structuredFasilitas->push((object)[
                        'hari' => (int)$hari,
                        'tanggal' => $tanggalFasilitas,
                        'fasilitas_id' => $fasId,
                        'qty' => $qty,
                        'harga' => $fas->harga,
                        'subtotal' => $subtotal,
                        'fasilitas' => $fas
                    ]);

                    $total += $subtotal;
                }
            }
        }

        /* =========================
           ⭐ LAHAN (BWA TENDA SENDIRI)
        ========================= */

        if ($request->has('lahan')) {

            foreach ($request->lahan as $hari => $fasId) {

                if (!$fasId) continue;

                $fas = Fasilitas::find($fasId);
                if (!$fas) continue;

                $qty = 1;
                $subtotal = $fas->harga;

                $tanggalLahan =
                    $tanggalAwal->copy()->addDays((int)$hari)->toDateString();

                $structuredFasilitas->push((object)[
                    'hari' => (int)$hari,
                    'tanggal' => $tanggalLahan,
                    'fasilitas_id' => $fasId,
                    'qty' => $qty,
                    'harga' => $fas->harga,
                    'subtotal' => $subtotal,
                    'fasilitas' => $fas
                ]);

                $total += $subtotal;
            }
        }

        /* =========================
           HITUNG KAPASITAS
        ========================= */

        $jumlahPengunjung = (int) $request->jumlah_pengunjung;
        $kapasitasPerHari = [];

        foreach ($structuredItems as $item) {

            $hari = $item->hari;

            if (!isset($kapasitasPerHari[$hari])) {
                $kapasitasPerHari[$hari] = 0;
            }

            $kapasitasPerHari[$hari] +=
                ($item->paketWisata->kapasitas ?? 0) * $item->qty;
        }

        $kapasitasMaksimal = !empty($kapasitasPerHari)
            ? max($kapasitasPerHari)
            : 0;

        $kelebihan = 0;
        $extra = 0;

        if ($jumlahPengunjung > $kapasitasMaksimal) {

            $kelebihan = $jumlahPengunjung - $kapasitasMaksimal;
            $extra = $kelebihan * 25000;

            $total += $extra;
        }

        $booking->jumlah_hari = $jumlahHari;
        $booking->jumlah_tiket_tambahan = $kelebihan;
        $booking->subtotal_tiket_tambahan = $extra;
        $booking->harga_tiket = 25000;

        $booking->items = $structuredItems;
        $booking->fasilitas = $structuredFasilitas;

        $booking->total_harga_final = $total;
        $booking->tanggal_selesai = $request->tanggal_checkout;

        return view('pengunjung.booking.booking-detail', [
            'booking' => $booking,
            'is_preview' => true
        ]);
    }

    /* =========================================================
        3. DETAIL BOOKING
    ========================================================= */

    public function showDetail($id)
    {
        $booking = Booking::with([
            'items.paketWisata',
            'fasilitas.fasilitas'
        ])->findOrFail($id);

        $total = 0;

        foreach ($booking->items as $item) {
            $item->subtotal = $item->harga * $item->qty;
            $total += $item->subtotal;
        }

        foreach ($booking->fasilitas as $fas) {
            $fas->subtotal = $fas->harga * $fas->qty;
            $total += $fas->subtotal;
        }

        $kapasitasPerHari = [];

        foreach ($booking->items as $item) {

            $hari = $item->hari;

            if (!isset($kapasitasPerHari[$hari])) {
                $kapasitasPerHari[$hari] = 0;
            }

            $kapasitasPerHari[$hari] +=
                ($item->paketWisata->kapasitas ?? 0) * $item->qty;
        }

        $kapasitasMaksimal = !empty($kapasitasPerHari)
            ? max($kapasitasPerHari)
            : 0;

        $extraCharge = 0;
        $jumlahTiketTambahan = 0;

        if ($booking->jumlah_pengunjung > $kapasitasMaksimal) {

            $jumlahTiketTambahan =
                $booking->jumlah_pengunjung - $kapasitasMaksimal;

            $extraCharge = $jumlahTiketTambahan * 25000;

            $total += $extraCharge;
        }

        $booking->jumlah_tiket_tambahan = $jumlahTiketTambahan;
        $booking->subtotal_tiket_tambahan = $extraCharge;
        $booking->harga_tiket = 25000;
        $booking->total_harga_final = $total;

        return view('pengunjung.booking.booking-detail', compact('booking'));
    }

    /* =========================================================
        4. STORE BOOKING
    ========================================================= */

    public function confirmStore(Request $request)
    {
        $input = session('temp_booking_data');

        if (!$input) {
            return redirect()
                ->route('pengunjung.booking.booking-form')
                ->with('error', 'Sesi habis, silakan isi ulang.');
        }

        try {

            $bookingRecord = DB::transaction(function () use ($input) {

                $kodeBooking = 'BK-' . strtoupper(Str::random(8));

                $jumlahMalam = (int) ($input['jumlah_malam'] ?? 1);
                $jumlahHari = $jumlahMalam + 1;

                $tanggal = Carbon::parse($input['tanggal_kunjungan']);
                $tanggalSelesai = Carbon::parse($input['tanggal_checkout']);

                $items = [];
                $fasilitas = [];

                $totalPaket = 0;
                $totalFasilitas = 0;

                /* =========================
                   PAKET
                ========================= */

                if (!empty($input['paket'])) {

                    foreach ($input['paket'] as $hari => $paketIds) {

                        foreach ($paketIds as $paketId) {

                            $paket = PaketWisata::findOrFail($paketId);

                            $qty = (int) ($input['paket_qty'][$hari][$paketId] ?? 1);

                            $subtotal = $paket->harga * $qty;

                            $items[] = [
                                'hari' => (int)$hari,
                                'tanggal' => $tanggal->copy()->addDays((int)$hari)->toDateString(),
                                'paket_wisata_id' => $paketId,
                                'qty' => $qty,
                                'harga' => $paket->harga,
                                'subtotal' => $subtotal
                            ];

                            $totalPaket += $subtotal;
                        }
                    }
                }

                /* =========================
                   FASILITAS
                ========================= */

                if (!empty($input['fasilitas'])) {

                    foreach ($input['fasilitas'] as $hari => $fasList) {

                        foreach ($fasList as $fasId => $qty) {

                            $qty = (int)$qty;
                            if ($qty <= 0) continue;

                            $fas = Fasilitas::findOrFail($fasId);

                            $fas->decrement('stok', $qty);

                            $subtotal = $fas->harga * $qty;

                            $fasilitas[] = [
                                'hari' => (int)$hari,
                                'tanggal' => $tanggal->copy()->addDays((int)$hari)->toDateString(),
                                'fasilitas_id' => $fasId,
                                'qty' => $qty,
                                'harga' => $fas->harga,
                                'subtotal' => $subtotal
                            ];

                            $totalFasilitas += $subtotal;
                        }
                    }
                }

                /* =========================
                   ⭐ LAHAN
                ========================= */

                if (!empty($input['lahan'])) {

                    foreach ($input['lahan'] as $hari => $fasId) {

                        $fas = Fasilitas::find($fasId);
                        if (!$fas) continue;

                        $fas->decrement('stok', 1);

                        $subtotal = $fas->harga;

                        $fasilitas[] = [
                            'hari' => (int)$hari,
                            'tanggal' => $tanggal->copy()->addDays((int)$hari)->toDateString(),
                            'fasilitas_id' => $fasId,
                            'qty' => 1,
                            'harga' => $fas->harga,
                            'subtotal' => $subtotal
                        ];

                        $totalFasilitas += $subtotal;
                    }
                }

                /* =========================
                   TIKET TAMBAHAN
                ========================= */

                $kapasitasPerHari = [];

                foreach ($items as $i) {

                    $hari = $i['hari'];

                    if (!isset($kapasitasPerHari[$hari])) {
                        $kapasitasPerHari[$hari] = 0;
                    }

                    $paket = PaketWisata::find($i['paket_wisata_id']);

                    if ($paket) {
                        $kapasitasPerHari[$hari] += ($paket->kapasitas ?? 0) * $i['qty'];
                    }
                }

                $kapasitasMaksimal = !empty($kapasitasPerHari)
                    ? max($kapasitasPerHari)
                    : 0;

                $jumlahPengunjung = (int) $input['jumlah_pengunjung'];

                $jumlahTiketTambahan = 0;
                $subtotalTiketTambahan = 0;

                if ($jumlahPengunjung > $kapasitasMaksimal) {
                    $jumlahTiketTambahan = $jumlahPengunjung - $kapasitasMaksimal;
                    $subtotalTiketTambahan = $jumlahTiketTambahan * 25000;
                }

                /* =========================
                   CREATE BOOKING
                ========================= */

                $booking = Booking::create([
                    'kode_booking' => $kodeBooking,
                    'nama_pemesan' => strip_tags($input['nama_pemesan']),
                    'no_hp' => strip_tags($input['no_hp']),
                    'tanggal_kunjungan' => $input['tanggal_kunjungan'],
                    'tanggal_selesai' => $tanggalSelesai->toDateString(),
                    'jumlah_malam' => $jumlahMalam,
                    'jumlah_hari' => $jumlahHari,
                    'jam' => $input['jam'],
                    'jumlah_pengunjung' => $input['jumlah_pengunjung'],
                    'jumlah_tiket_tambahan' => $jumlahTiketTambahan,
                    'harga_tiket_tambahan' => 25000,
                    'subtotal_tiket_tambahan' => $subtotalTiketTambahan,
                    'total_harga' => $totalPaket + $totalFasilitas + $subtotalTiketTambahan,
                    'total_harga_final' => $totalPaket + $totalFasilitas + $subtotalTiketTambahan,
                    'status_booking' => 'pending',
                    'status_pembayaran' => 'belum_bayar',
                ]);

                foreach ($items as $i) {
                    $booking->items()->create($i);
                }

                foreach ($fasilitas as $f) {
                    $booking->fasilitas()->create($f);
                }

                return $booking;
            });

            session()->forget('temp_booking_data');

            return redirect()->route('pengunjung.booking.booking-payment', $bookingRecord->id);

        } catch (\Exception $e) {

            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    /* =========================================================
        5. EDIT BOOKING
    ========================================================= */

    public function edit($id)
    {
        $booking = Booking::with([
            'items.paketWisata',
            'fasilitas.fasilitas'
        ])->findOrFail($id);

        return view('pengunjung.booking.booking-form', [
            'booking' => $booking,
            'paket' => PaketWisata::all(),
            'kategoriPaket' => KategoriPaket::all(),
            'fasilitas' => Fasilitas::with('kategori')->get()
        ]);
    }

    /* =========================================================
        6. UPDATE BOOKING
    ========================================================= */

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {

            $booking = Booking::findOrFail($id);

            $jumlahMalam = (int) $request->jumlah_malam;
            $jumlahHari = $jumlahMalam + 1;

            $tanggalAwal = Carbon::parse($request->tanggal_kunjungan);

            $booking->update([
                'nama_pemesan' => $request->nama_pemesan,
                'no_hp' => $request->no_hp,
                'tanggal_kunjungan' => $request->tanggal_kunjungan,
                'tanggal_selesai' => $request->tanggal_checkout,
                'jam' => $request->jam,
                'jumlah_malam' => $jumlahMalam,
                'jumlah_hari' => $jumlahHari,
                'jumlah_pengunjung' => $request->jumlah_pengunjung,
            ]);

            $booking->items()->delete();
            $booking->fasilitas()->delete();

            $total = 0;

            /* =========================
               PAKET
            ========================= */

            if ($request->has('paket')) {

                foreach ($request->paket as $hari => $paketIds) {

                    foreach ($paketIds as $paketId) {

                        $paket = PaketWisata::find($paketId);
                        if (!$paket) continue;

                        $qty = (int) ($request->paket_qty[$hari][$paketId] ?? 1);

                        $subtotal = $paket->harga * $qty;

                        $booking->items()->create([
                            'hari' => (int)$hari,
                            'tanggal' => $tanggalAwal->copy()->addDays((int)$hari)->toDateString(),
                            'paket_wisata_id' => $paketId,
                            'qty' => $qty,
                            'harga' => $paket->harga,
                            'subtotal' => $subtotal
                        ]);

                        $total += $subtotal;
                    }
                }
            }

            /* =========================
               FASILITAS
            ========================= */

            if ($request->has('fasilitas')) {

                foreach ($request->fasilitas as $hari => $fasList) {

                    foreach ($fasList as $fasId => $qty) {

                        $qty = (int)$qty;
                        if ($qty <= 0) continue;

                        $fas = Fasilitas::find($fasId);
                        if (!$fas) continue;

                        $subtotal = $fas->harga * $qty;

                        $booking->fasilitas()->create([
                            'hari' => (int)$hari,
                            'tanggal' => $tanggalAwal->copy()->addDays((int)$hari)->toDateString(),
                            'fasilitas_id' => $fasId,
                            'qty' => $qty,
                            'harga' => $fas->harga,
                            'subtotal' => $subtotal
                        ]);

                        $total += $subtotal;
                    }
                }
            }

            /* =========================
               ⭐ LAHAN UPDATE
            ========================= */

            if ($request->has('lahan')) {

                foreach ($request->lahan as $hari => $fasId) {

                    if (!$fasId) continue;

                    $fas = Fasilitas::find($fasId);
                    if (!$fas) continue;

                    $subtotal = $fas->harga;

                    $booking->fasilitas()->create([
                        'hari' => (int)$hari,
                        'tanggal' => $tanggalAwal->copy()->addDays((int)$hari)->toDateString(),
                        'fasilitas_id' => $fasId,
                        'qty' => 1,
                        'harga' => $fas->harga,
                        'subtotal' => $subtotal
                    ]);

                    $total += $subtotal;
                }
            }

            /* =========================
               TIKET TAMBAHAN
            ========================= */

            $kapasitasPerHari = [];

            foreach ($booking->items as $item) {

                $hari = $item->hari;

                if (!isset($kapasitasPerHari[$hari])) {
                    $kapasitasPerHari[$hari] = 0;
                }

                $kapasitasPerHari[$hari] +=
                    ($item->paketWisata->kapasitas ?? 0) * $item->qty;
            }

            $kapasitasMaksimal = !empty($kapasitasPerHari)
                ? max($kapasitasPerHari)
                : 0;

            $jumlahTiketTambahan = 0;
            $subtotalTiketTambahan = 0;

            if ($request->jumlah_pengunjung > $kapasitasMaksimal) {

                $jumlahTiketTambahan =
                    $request->jumlah_pengunjung - $kapasitasMaksimal;

                $subtotalTiketTambahan =
                    $jumlahTiketTambahan * 25000;

                $total += $subtotalTiketTambahan;
            }

            $booking->update([
                'jumlah_tiket_tambahan' => $jumlahTiketTambahan,
                'harga_tiket_tambahan' => 25000,
                'subtotal_tiket_tambahan' => $subtotalTiketTambahan,
                'total_harga' => $total,
                'total_harga_final' => $total
            ]);

            DB::commit();

            return redirect()->route('pengunjung.booking.booking-detail', $id)
                ->with('success', 'Berhasil diperbarui');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /* =========================================================
        7. PAYMENT
    ========================================================= */

    public function showPayment($id)
    {
        return view('pengunjung.booking.booking-payment', [
            'booking' => Booking::findOrFail($id)
        ]);
    }

    public function updatePaymentMethod(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $booking->update([
            'status_pembayaran' => $request->tipe_pembayaran,
            'catatan' => ($booking->catatan ?? '') . ' | ' . strip_tags($request->metode_pembayaran)
        ]);

        return redirect()->route('pengunjung.booking.booking-success', $id);
    }

    public function showSuccess($id)
    {
        return view('pengunjung.booking.booking-success', [
            'booking' => Booking::findOrFail($id)
        ]);
    }

    /* =========================================================
        8. UPLOAD BUKTI
    ========================================================= */

    public function uploadBukti(Request $request, $id)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $booking = Booking::findOrFail($id);

        if ($request->hasFile('bukti_pembayaran')) {

            $filename =
                'BUKTI-' . $booking->kode_booking . '-' . time() . '.' .
                $request->file('bukti_pembayaran')->getClientOriginalExtension();

            $request->file('bukti_pembayaran')
                ->storeAs('public/bukti_pembayaran', $filename);

            $booking->update([
                'catatan' => ($booking->catatan ?? '') . ' | Bukti: ' . $filename
            ]);

            return back()->with('success', 'Berhasil upload.');
        }

        return back()->with('error', 'Gagal upload.');
    }
}