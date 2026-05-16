<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PaketWisata;
use Illuminate\Http\Request;

class PaketWisataController extends Controller
{
    // GET /api/paket-wisata
    public function index()
    {
        $data = PaketWisata::all(); // <-- TANPA with()

        return response()->json($data, 200);
    }

    // GET /api/paket-wisata/{id}
    public function show($id)
    {
        $paket = PaketWisata::find($id); // <-- TANPA with()

        if (!$paket) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json($paket, 200);
    }

    // POST
    public function store(Request $request)
    {
        $request->validate([
            'kategori_paket_id' => 'required|exists:kategori_paket,id',
            'nama_paket' => 'required|string',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric',
            'kapasitas' => 'required|integer',
            'durasi' => 'required|string',
            'status' => 'required|string',
        ]);

        $paket = PaketWisata::create($request->all());

        return response()->json($paket, 201);
    }

    // PUT
    public function update(Request $request, $id)
    {
        $paket = PaketWisata::find($id);

        if (!$paket) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $paket->update($request->all());

        return response()->json($paket, 200);
    }

    // DELETE
    public function destroy($id)
    {
        $paket = PaketWisata::find($id);

        if (!$paket) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $paket->delete();

        return response()->json(['message' => 'Berhasil dihapus'], 200);
    }
}