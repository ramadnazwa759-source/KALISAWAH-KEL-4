<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Http\Controllers\Controller;

class BookingController extends Controller
{
    /**
     * Tampilkan form booking
     */
    public function create()
    {
        return view('booking');
    }

    /**
     * Proses validasi awal dan simpan ke session sebelum ke halaman detail
     */
    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'nama_pemesan' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'tanggal_kunjungan' => 'required|date',
            'jam' => 'required',
            'jumlah_orang' => 'required|integer|min:1',
            'jumlah_tenda' => 'nullable|integer|min:0',
            'catatan' => 'nullable|string',
        ]);

        // Simpan tambahan data seperti paket, fasilitas, makanan
        $validated['paket'] = $request->query('paket', $request->input('paket', 'Pilih Paket Camp'));
        $validated['fasilitas'] = $request->input('fasilitas', []);
        $validated['makanan'] = $request->input('makanan', []);

        // Simpan ke session
        session(['booking_data' => $validated]);

        return redirect()->route('booking.detail');
    }

    /**
     * Tampilkan halaman detail pemesanan (summary)
     */
    public function detail()
    {
        $data = session('booking_data');

        if (!$data) {
            return redirect()->route('booking.create');
        }

        return view('booking-detail', compact('data'));
    }

    /**
     * Simpan data booking ke database
     */
    public function store(Request $request)
    {
        $data = session('booking_data');

        if (!$data) {
            return redirect()->route('booking.create')->with('error', 'Data booking tidak ditemukan.');
        }

        // Simpan ke database
        $booking = Booking::create([
            'nama_pemesan' => $data['nama_pemesan'],
            'no_hp' => $data['no_hp'],
            'tanggal_kunjungan' => $data['tanggal_kunjungan'],
            'jam' => $data['jam'],
            'jumlah_orang' => $data['jumlah_orang'],
            'jumlah_tenda' => $data['jumlah_tenda'] ?? 0,
            'catatan' => $data['catatan'] ?? null,
            'status_booking' => 'pending',
            'kode_booking' => 'BK-' . strtoupper(uniqid()),
        ]);

        // Hapus session setelah berhasil
        session()->forget('booking_data');
        
        return redirect()->route('home')->with('success', 'Booking berhasil disimpan! Silakan hubungi admin untuk konfirmasi.');
    }
}
