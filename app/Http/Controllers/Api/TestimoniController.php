<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Testimoni;
use Illuminate\Http\Request;

class TestimoniController extends Controller
{
    /**
     * GET semua testimoni
     */
    public function index()
    {
        $testimoni = Testimoni::latest()->get();

        return response()->json([
            'success' => true,
            'data' => $testimoni
        ]);
    }

    /**
     * GET detail testimoni
     */
    public function show($id)
    {
        $testimoni = Testimoni::find($id);

        if (!$testimoni) {
            return response()->json([
                'success' => false,
                'message' => 'Testimoni tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $testimoni
        ]);
    }

    /**
     * POST tambah testimoni
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap'      => 'required|string|max:255',
            'instansi_sekolah'  => 'required|string|max:255',
            'rating_pengalaman' => 'required|integer|min:1|max:5',
            'ulasan_testimoni'  => 'required|string',
        ]);

        $testimoni = Testimoni::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Testimoni berhasil ditambahkan',
            'data' => $testimoni
        ], 201);
    }

    /**
     * PUT/PATCH update testimoni
     */
    public function update(Request $request, $id)
    {
        $testimoni = Testimoni::find($id);

        if (!$testimoni) {
            return response()->json([
                'success' => false,
                'message' => 'Testimoni tidak ditemukan'
            ], 404);
        }

        $validated = $request->validate([
            'nama_lengkap'      => 'sometimes|required|string|max:255',
            'instansi_sekolah'  => 'sometimes|required|string|max:255',
            'rating_pengalaman' => 'sometimes|required|integer|min:1|max:5',
            'ulasan_testimoni'  => 'sometimes|required|string',
        ]);

        $testimoni->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Testimoni berhasil diperbarui',
            'data' => $testimoni->fresh()
        ]);
    }

    /**
     * DELETE testimoni
     */
    public function destroy($id)
    {
        $testimoni = Testimoni::find($id);

        if (!$testimoni) {
            return response()->json([
                'success' => false,
                'message' => 'Testimoni tidak ditemukan'
            ], 404);
        }

        $testimoni->delete();

        return response()->json([
            'success' => true,
            'message' => 'Testimoni berhasil dihapus'
        ]);
    }
}