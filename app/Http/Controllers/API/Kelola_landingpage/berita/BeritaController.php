<?php

namespace App\Http\Controllers\API\Kelola_landingpage\berita;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    /**
     * Menampilkan semua berita
     */
    public function index()
    {
        $berita = Berita::orderBy('tanggal', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $berita
        ]);
    }

    /**
     * Menampilkan detail berita berdasarkan ID
     */
    public function show($id)
    {
        $berita = Berita::find($id);

        if (!$berita) {
            return response()->json([
                'success' => false,
                'message' => 'Berita tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $berita
        ]);
    }

    /**
     * Menambahkan berita baru
     */
    public function store(Request $request)
    {
        /**
         * Validasi input
         */
        $validated = $request->validate([
            'judul'      => 'required|string|max:255',
            'isi_berita' => 'required|string',
            'foto'       => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'tanggal'    => 'required|date',
        ]);

        /**
         * Upload foto ke private storage
         */
        $path = $request->file('foto')->store(
            'private/berita',
            'local'
        );

        /**
         * Simpan data berita ke database
         */
        $berita = Berita::create([
            'judul'      => $validated['judul'],
            'isi_berita' => $validated['isi_berita'],
            'foto'       => $path,
            'tanggal'    => $validated['tanggal'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berita berhasil ditambahkan',
            'data'    => $berita
        ], 201);
    }

    /**
     * Memperbarui data berita
     */
    public function update(Request $request, $id)
    {
        $berita = Berita::find($id);

        if (!$berita) {
            return response()->json([
                'success' => false,
                'message' => 'Berita tidak ditemukan'
            ], 404);
        }

        /**
         * Validasi data yang dikirim
         */
        $validated = $request->validate([
            'judul'      => 'sometimes|required|string|max:255',
            'isi_berita' => 'sometimes|required|string',
            'foto'       => 'sometimes|image|mimes:jpg,jpeg,png,webp|max:2048',
            'tanggal'    => 'sometimes|required|date',
        ]);

        /**
         * Jika ada foto baru yang diupload
         */
        if ($request->hasFile('foto')) {

            /**
             * Hapus foto lama dari storage
             */
            if (
                $berita->foto &&
                Storage::disk('local')->exists($berita->foto)
            ) {
                Storage::disk('local')->delete($berita->foto);
            }

            /**
             * Simpan foto baru ke storage
             */
            $validated['foto'] = $request->file('foto')->store(
                'private/berita',
                'local'
            );
        }

        /**
         * Update data berita
         */
        $berita->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Berita berhasil diperbarui',
            'data'    => $berita->fresh()
        ]);
    }

    /**
     * Menghapus berita
     */
    public function destroy($id)
    {
        $berita = Berita::find($id);

        if (!$berita) {
            return response()->json([
                'success' => false,
                'message' => 'Berita tidak ditemukan'
            ], 404);
        }

        /**
         * Hapus file foto dari storage
         */
        if (
            $berita->foto &&
            Storage::disk('local')->exists($berita->foto)
        ) {
            Storage::disk('local')->delete($berita->foto);
        }

        /**
         * Hapus data berita dari database
         */
        $berita->delete();

        return response()->json([
            'success' => true,
            'message' => 'Berita berhasil dihapus'
        ]);
    }
}