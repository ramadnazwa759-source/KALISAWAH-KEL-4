<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;

class GaleriController extends Controller
{
    public function index()
    {
        $data = Galeri::all();
        return view('galeri.index', compact('data'));
    }

    public function create()
    {
        return view('galeri.create');
    }

    public function store(Request $request)
    {
        /**
         * FILE UPLOAD VULNERABILITY PREVENTION
         */
        $request->validate([
            'judul'  => 'required|string|max:255',
            'gambar' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $file = $request->file('gambar');

        /**
         * rename file agar aman
         */
        $nama_file = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        /**
         * simpan file ke public/gambar
         */
        $file->move(public_path('gambar'), $nama_file);

        Galeri::create([
            'judul'  => $request->judul,
            'gambar' => $nama_file
        ]);

        return redirect('/galeri');
    }

    public function destroy($id)
    {
        $galeri = Galeri::find($id);

        if ($galeri) {

            /**
             * ===============================
             * HAPUS FILE LAMA DI STORAGE
             * ===============================
             */
            $filePath = public_path('gambar/' . $galeri->gambar);

            if (file_exists($filePath)) {
                unlink($filePath); // hapus file fisik
            }

            /**
             * hapus data database
             */
            $galeri->delete();
        }

        return redirect()->back();
    }
}
