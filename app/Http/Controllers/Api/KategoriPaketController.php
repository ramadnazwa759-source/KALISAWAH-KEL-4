<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller; // controller dasar Laravel
use Illuminate\Http\Request; // menangkap request dari Postman / client
use App\Models\KategoriPaket; // model tabel kategori_paket
use Illuminate\Support\Facades\Storage; // untuk hapus & simpan file gambar

class KategoriPaketController extends Controller
{
 
    // MENAMPILKAN SEMUA DATA
    // GET /api/kategori-paket

    public function index()
    {
        // ambil semua data dari tabel kategori_paket
        return response()->json(KategoriPaket::all(), 200);
    }

    // MENAMPILKAN 1 DATA BERDASARKAN ID
    // GET /api/kategori-paket/{id}
 
    public function show($id)
    {
        // cari data berdasarkan id
        $data = KategoriPaket::find($id);

        // jika tidak ditemukan kirim error 404
        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // jika ada tampilkan datanya
        return response()->json($data, 200);
    }

    // MENAMBAH DATA BARU + UPLOAD GAMBAR
    // POST /api/kategori-paket
    public function store(Request $request)
    {
        // validasi input dari Postman
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi'     => 'nullable|string',
            'gambar'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $path = null; // penampung path gambar

        // jika ada file gambar yang dikirim
        if ($request->hasFile('gambar')) {
            // simpan file ke storage/public/kategori_paket
            $path = $request->file('gambar')->store('kategori_paket', 'public');
        }

        // simpan data ke database
        $data = KategoriPaket::create([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi'     => $request->deskripsi,
            'gambar'        => $path
        ]);

        // kirim response berhasil
        return response()->json($data, 201);
    }

  
    // UPDATE DATA + GANTI GAMBAR
    // PUT /api/kategori-paket/{id}
    public function update(Request $request, $id)
    {
        // cari data berdasarkan id
        $data = KategoriPaket::find($id);

        // jika tidak ada kirim 404
        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // validasi input
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi'     => 'nullable|string',
            'gambar'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // jika upload gambar baru
        if ($request->hasFile('gambar')) {

            // hapus gambar lama dari storage
            if ($data->gambar) {
                Storage::disk('public')->delete($data->gambar);
            }

            // simpan gambar baru
            $data->gambar = $request->file('gambar')->store('kategori_paket', 'public');
        }

        // update data selain gambar
        $data->update($request->only('nama_kategori','deskripsi'));

        return response()->json($data, 200);
    }

    // MENGHAPUS DATA + GAMBAR
    // DELETE /api/kategori-paket/{id}
    public function destroy($id)
    {
        // cari data
        $data = KategoriPaket::find($id);

        // jika tidak ada
        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // hapus gambar dari storage jika ada
        if ($data->gambar) {
            Storage::disk('public')->delete($data->gambar);
        }

        // hapus data dari database
        $data->delete();

        return response()->json(['message' => 'Berhasil dihapus'], 200);
    }
}