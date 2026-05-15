<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Fasilitas;
use Illuminate\Http\Request;

class FasilitasController extends Controller
{
    // GET /api/fasilitas
    public function index()
    {
        return response()->json(Fasilitas::all(), 200);
    }

    // POST /api/fasilitas
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_fasilitas' => 'required|string|max:255',
            'keterangan'     => 'required|string',
            'harga_satuan'   => 'required|numeric|min:0',
            'kategori'       => 'required|string|max:100',
            'stok'           => 'required|integer|min:0',
        ]);

        $data = Fasilitas::create($validated);

        return response()->json([
            'message' => 'Fasilitas berhasil ditambahkan',
            'data' => $data
        ], 201);
    }

    // GET /api/fasilitas/{id}
    public function show($id)
    {
        return response()->json(Fasilitas::findOrFail($id), 200);
    }

    // PUT /api/fasilitas/{id}
    public function update(Request $request, $id)
    {
        $fasilitas = Fasilitas::findOrFail($id);

        $validated = $request->validate([
            'nama_fasilitas' => 'required|string|max:255',
            'keterangan'     => 'required|string',
            'harga_satuan'   => 'required|numeric|min:0',
            'kategori'       => 'required|string|max:100',
            'stok'           => 'required|integer|min:0',
        ]);

        $fasilitas->update($validated);

        return response()->json([
            'message' => 'Fasilitas berhasil diupdate',
            'data' => $fasilitas
        ], 200);
    }

    // DELETE /api/fasilitas/{id}
    public function destroy($id)
    {
        Fasilitas::destroy($id);

        return response()->json([
            'message' => 'Fasilitas berhasil dihapus'
        ], 200);
    }
}