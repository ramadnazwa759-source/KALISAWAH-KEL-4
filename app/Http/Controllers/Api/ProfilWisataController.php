<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProfilWisata;
use Illuminate\Support\Facades\DB;

class ProfilWisataController extends Controller
{
    // GET /api/profil-wisata
    // GET /api/profil-wisata
public function index()
{
    try {
        $data = ProfilWisata::orderBy('id','desc')->get();

        return response()->json($data, 200);

    } catch (\Throwable $e) {
        return response()->json([
            'error' => $e->getMessage()
        ], 500);
    }
}

    // POST /api/profil-wisata
    public function store(Request $request)
    {
        try {
            $data = ProfilWisata::create($request->all());

            return response()->json([
                'message' => 'Profil wisata berhasil ditambahkan',
                'data' => $data
            ], 201);

        } catch (\Throwable $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // GET /api/profil-wisata/{id}
    public function show($id)
    {
        try {
            $data = ProfilWisata::findOrFail($id);

            return response()->json([
                'message' => 'Detail profil wisata',
                'data' => $data
            ], 200);

        } catch (\Throwable $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // PUT /api/profil-wisata/{id}
    public function update(Request $request, $id)
    {
        try {
            $data = ProfilWisata::findOrFail($id);
            $data->update($request->all());

            return response()->json([
                'message' => 'Profil wisata berhasil diupdate',
                'data' => $data
            ], 200);

        } catch (\Throwable $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // DELETE /api/profil-wisata/{id}
    public function destroy($id)
    {
        try {
            ProfilWisata::destroy($id);

            return response()->json([
                'message' => 'Profil wisata berhasil dihapus'
            ], 200);

        } catch (\Throwable $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}