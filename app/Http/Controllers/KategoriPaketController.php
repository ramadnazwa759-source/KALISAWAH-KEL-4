<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriPaket;

class KategoriPaketController extends Controller
{
    // READ semua data
    public function index()
    {
        $data = KategoriPaket::all();
        return view('kategori.index', compact('data'));
    }

    // Form tambah data
    public function create()
    {
        return view('kategori.create');
    }

    // Simpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'required|image'
        ]);

        $file = $request->gambar;
        $namaFile = time().'.'.$file->extension();
        $file->move(public_path('gambar_kategori'), $namaFile);

        KategoriPaket::create([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi' => $request->deskripsi,
            'gambar' => $namaFile
        ]);

        return redirect('/kategori');
    }

    // Form edit data
    public function edit($id)
    {
        $data = KategoriPaket::find($id);
        return view('kategori.edit', compact('data'));
    }

    // Update data
    public function update(Request $request, $id)
    {
       $data = KategoriPaket::findOrFail($id);

        if (!$data) {
            // kalau data tidak ditemukan, redirect aja
            return redirect('/kategori')->with('error', 'Data tidak ditemukan');
        }

        $request->validate([
            'nama_kategori' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'nullable|image'

        ]);

        $data->nama_kategori = $request->nama_kategori;
        $data->deskripsi = $request->deskripsi;

        if ($request->hasFile('gambar')) {
           $file = $request->file('gambar');
            $namaFile = time().'.'.$file->extension();
            $file->move(public_path('gambar_kategori'), $namaFile);

            $data->gambar = $namaFile;
        }

        $data->save();

        return redirect('/kategori');
    }

    // Hapus data
    public function destroy($id)
    {
        $data = KategoriPaket::find($id);

        if ($data) {
            $data->delete();
        }

        return redirect('/kategori');
    }
}