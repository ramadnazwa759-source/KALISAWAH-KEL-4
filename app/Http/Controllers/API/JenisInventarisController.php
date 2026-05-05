<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JenisInventaris;

class JenisInventarisController extends Controller
{
    public function index()
    {
        return JenisInventaris::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_barang' => 'required',
            'kategori' => 'required',
            'keterangan' => 'nullable'
        ]);

        return JenisInventaris::create($data);
    }

    public function show($id)
    {
        return JenisInventaris::with('units')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nama_barang' => 'required',
            'kategori' => 'required',
            'keterangan' => 'nullable'
        ]);

        $item = JenisInventaris::findOrFail($id);
        $item->update($data);

        return $item;
    }

    public function destroy($id)
    {
        JenisInventaris::destroy($id);
        return response()->json(['message' => 'Data dihapus']);
    }
}