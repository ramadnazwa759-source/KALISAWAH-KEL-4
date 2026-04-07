<?php

namespace App\Http\Controllers;

use App\Models\PaketWisata;
use Illuminate\Http\Request;

class PaketWisataController extends Controller
{
    public function index()
    {
        return PaketWisata::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_kategori' => 'required',
            'nama_paket' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required',
            'kapasitas' => 'required',
            'durasi' => 'required',
            'status' => 'required'
        ]);

        return PaketWisata::create($data);
    }

    public function show($id)
    {
        return PaketWisata::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $paket = PaketWisata::findOrFail($id);

        $paket->update($request->all());

        return $paket;
    }

    public function destroy($id)
    {
        PaketWisata::destroy($id);

        return response()->json(['message' => 'Deleted']);
    }
}
