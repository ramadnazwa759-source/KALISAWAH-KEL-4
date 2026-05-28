<?php

namespace App\Http\Controllers\API\Kelola_landingpage\paket;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KategoriPaket;
use Illuminate\Support\Facades\Storage;

class KategoriPaketController extends Controller
{
    /**
     * Menampilkan semua kategori paket
     */
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => KategoriPaket::all()
        ]);
    }

    /**
     * Menampilkan detail kategori berdasarkan ID
     */
    public function show($id)
    {
        $data = KategoriPaket::find($id);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Menambahkan kategori paket
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi'     => 'nullable|string',
            'gambar'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        /**
         * Upload gambar ke private storage
         */
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store(
                'private/kategori_paket',
                'local'
            );
        }

        $data = KategoriPaket::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Kategori paket berhasil ditambahkan',
            'data'    => $data
        ], 201);
    }

    /**
     * Update kategori paket
     */
    public function update(Request $request, $id)
    {
        $data = KategoriPaket::find($id);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi'     => 'nullable|string',
            'gambar'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        /**
         * Jika ada gambar baru
         */
        if ($request->hasFile('gambar')) {

            /**
             * Hapus gambar lama
             */
            if (
                $data->gambar &&
                Storage::disk('local')->exists($data->gambar)
            ) {
                Storage::disk('local')->delete($data->gambar);
            }

            /**
             * Simpan gambar baru
             */
            $validated['gambar'] = $request->file('gambar')->store(
                'private/kategori_paket',
                'local'
            );
        }

        $data->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Kategori paket berhasil diperbarui',
            'data'    => $data->fresh()
        ]);
    }

    /**
     * Hapus kategori paket
     */
    public function destroy($id)
    {
        $data = KategoriPaket::find($id);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        /**
         * Hapus file gambar dari storage
         */
        if (
            $data->gambar &&
            Storage::disk('local')->exists($data->gambar)
        ) {
            Storage::disk('local')->delete($data->gambar);
        }

        $data->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kategori paket berhasil dihapus'
        ]);
    }
}