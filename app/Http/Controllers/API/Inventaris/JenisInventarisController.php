<?php

namespace App\Http\Controllers\API\Inventaris;

use App\Http\Controllers\Controller;
use App\Models\JenisInventaris;
use Illuminate\Http\Request;

class JenisInventarisController extends Controller
{
    /**
     * Menampilkan semua jenis inventaris
     */
    public function index()
    {
        $jenisInventaris = JenisInventaris::with([
            'subkategori.kategori'
        ])->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Data jenis inventaris berhasil diambil',
            'data' => $jenisInventaris
        ], 200);
    }

    /**
     * Menambahkan jenis inventaris baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'id_subkategori' =>
                'required|exists:subkategori_inventaris,id_subkategori',

            'nama_barang' =>
                'required|string|max:255',

            'spesifikasi' =>
                'nullable|string'
        ]);

        $jenisInventaris = JenisInventaris::create([

            'id_subkategori' =>
                $validated['id_subkategori'],

            'nama_barang' =>
                trim($validated['nama_barang']),

            'spesifikasi' =>
                $validated['spesifikasi'] ?? null
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Jenis inventaris berhasil ditambahkan',
            'data' => $jenisInventaris
        ], 201);
    }

    /**
     * Menampilkan detail jenis inventaris
     */
    public function show($id)
    {
        $jenisInventaris = JenisInventaris::with([
            'subkategori.kategori'
        ])->find($id);

        if (!$jenisInventaris) {
            return response()->json([
                'success' => false,
                'message' => 'Jenis inventaris tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $jenisInventaris
        ], 200);
    }

    /**
     * Mengupdate jenis inventaris
     */
    public function update(Request $request, $id)
    {
        $jenisInventaris = JenisInventaris::find($id);

        if (!$jenisInventaris) {
            return response()->json([
                'success' => false,
                'message' => 'Jenis inventaris tidak ditemukan'
            ], 404);
        }

        $validated = $request->validate([

            'id_subkategori' =>
                'required|exists:subkategori_inventaris,id_subkategori',

            'nama_barang' =>
                'required|string|max:255',

            'spesifikasi' =>
                'nullable|string'
        ]);

        $jenisInventaris->update([

            'id_subkategori' =>
                $validated['id_subkategori'],

            'nama_barang' =>
                trim($validated['nama_barang']),

            'spesifikasi' =>
                $validated['spesifikasi'] ?? null
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Jenis inventaris berhasil diupdate',
            'data' => $jenisInventaris
        ], 200);
    }

    /**
     * Menghapus jenis inventaris
     */
    public function destroy($id)
    {
        $jenisInventaris = JenisInventaris::find($id);

        if (!$jenisInventaris) {
            return response()->json([
                'success' => false,
                'message' => 'Jenis inventaris tidak ditemukan'
            ], 404);
        }

        $jenisInventaris->delete();

        return response()->json([
            'success' => true,
            'message' => 'Jenis inventaris berhasil dihapus'
        ], 200);
    }
}