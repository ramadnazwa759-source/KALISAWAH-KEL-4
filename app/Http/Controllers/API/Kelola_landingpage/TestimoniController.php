<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestimoniController extends Controller
{
    // Menampilkan halaman form review bagi pengunjung
    public function create()
    {
        return view('pengunjung.landing-page.testimoni.review'); // Sesuaikan dengan lokasi view review kamu
    }

    // Menyimpan data review ke database via AJAX/Fetch
    public function store(Request $request)
    {
        // Validasi input form
        $request->validate([
            'nama' => 'required|string|max:255',
            'instansi' => 'required|string|max:255',
            'rating' => 'required|integer|between:1,5',
            'ulasan' => 'required|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $testimoni = new Testimoni();
        $testimoni->nama = $request->nama;
        $testimoni->instansi = $request->instansi;
        $testimoni->rating = $request->rating;
        $testimoni->ulasan = $request->ulasan;

        // Proses upload foto profil jika ada
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

            // Disimpan ke folder storage/app/public/testimonials
            $path = $file->storeAs('testimonials', $filename, 'public');
            $testimoni->foto_path = $path;
        }

        $testimoni->save();

        // Mengembalikan response JSON karena form kamu diproses via JavaScript
        // return response()->json([
        //     'success' => true,
        //     'message' => 'Review berhasil dikirim dan menunggu moderasi admin.'
        // ], 201);

        Return redirect()->back()->with('success', 'Review berhasil dikirim dan menunggu moderasi admin.');
    }
}
