<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaketWisata;
use App\Models\KategoriPaket;

class PaketWisataController extends Controller
{
    // Menampilkan semua paket wisata
    public function index()
    {
        $data = PaketWisata::with('kategori')->get();
        return view('paket.index', compact('data'));
    }

    // Menampilkan form tambah paket wisata
    public function create()
    {
        $kategori = KategoriPaket::all();
        return view('paket.create', compact('kategori'));
    }

    // Menyimpan paket wisata baru
    public function store(Request $request)
    {
        $request->validate([
            'kategori_paket_id' => 'required',
            'nama_paket' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required|numeric',
            'kapasitas' => 'required|numeric',
            'durasi' => 'required',
            'status' => 'required'
        ]);

        PaketWisata::create($request->all());

        return redirect()->route('paket.index')->with('success', 'Paket berhasil ditambahkan.');
    }

    
   // Menampilkan form edit paket wisata
public function edit($id)
{
    // Ambil paket berdasarkan id
    $data = PaketWisata::find($id);

    // Kalau tidak ditemukan, redirect ke index dengan pesan error
    if (!$data) {
        return redirect()->route('paket.index')->with('error', 'Data paket tidak ditemukan.');
    }

    // Ambil semua kategori untuk dropdown
    $kategori = KategoriPaket::all();

    // Kirim variabel ke view
    // Pastikan compact('data', 'kategori') sesuai dengan nama variabel di edit.blade.php
    return view('paket.edit', compact('data', 'kategori'));
}


    // Menyimpan perubahan paket wisata
    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori_paket_id' => 'required',
            'nama_paket' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required|numeric',
            'kapasitas' => 'required|numeric',
            'durasi' => 'required',
            'status' => 'required'
        ]);

        $data = PaketWisata::find($id);
        if (!$data) {
            return redirect()->route('paket.index')->with('error', 'Data paket tidak ditemukan.');
        }

        $data->update($request->all());

        return redirect()->route('paket.index')->with('success', 'Paket berhasil diupdate.');
    }

    // Menghapus paket wisata
    public function destroy($id)
    {
        $data = PaketWisata::find($id); // sebelumnya typo: $id_pak
        if ($data) {
            $data->delete();
            return redirect()->route('paket.index')->with('success', 'Paket berhasil dihapus.');
        }

        return redirect()->route('paket.index')->with('error', 'Data paket tidak ditemukan.');
    }
}
