<?php

namespace App\Http\Controllers\Api;
 
use App\Http\Controllers\Controller;
use App\Models\PaketFasilitas;
use Illuminate\Http\Request;


class PaketFasilitasController extends Controller
{
    // GET /api/paket-fasilitas
    public function index()
    {
        return response()->json(PaketFasilitas::all(), 200);
    }

    // POST /api/paket-fasilitas
    public function store(Request $request)
    {
        $request->validate([
            'id_paket'     => 'required|integer|exists:paket_wisata,id',
            'id_fasilitas' => 'required|integer|exists:fasilitas,id',
            'jumlah'       => 'required|integer|min:1',
            'keterangan'   => 'nullable|string',
        ]);

        $data = PaketFasilitas::create($request->all());

        return response()->json([
            'message' => 'Paket fasilitas berhasil ditambahkan',
            'data'    => $data
        ], 201);
    }

    // GET /api/paket-fasilitas/{id}
    public function show($id)
    {
        return response()->json(PaketFasilitas::findOrFail($id), 200);
    }

    // PUT /api/paket-fasilitas/{id}
    public function update(Request $request, $id)
    {
        $paketFasilitas = PaketFasilitas::findOrFail($id);

        $request->validate([
            'id_paket'     => 'required|integer|exists:paket_wisata,id',
            'id_fasilitas' => 'required|integer|exists:fasilitas,id',
            'jumlah'       => 'required|integer|min:1',
            'keterangan'   => 'nullable|string',
        ]);

        $paketFasilitas->update($request->all());

        return response()->json([
            'message' => 'Paket fasilitas berhasil diupdate',
            'data'    => $paketFasilitas
        ], 200);
    }

    // DELETE /api/paket-fasilitas/{id}
    public function destroy($id)
    {
        PaketFasilitas::destroy($id);

        return response()->json([
            'message' => 'Paket fasilitas berhasil dihapus'
        ], 200);
    }
}