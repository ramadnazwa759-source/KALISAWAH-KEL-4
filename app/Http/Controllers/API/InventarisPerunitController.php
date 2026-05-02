<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InventarisPerUnit;

class InventarisPerUnitController extends Controller
{
    public function index()
    {
        return InventarisPerUnit::with('jenis')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_jenis' => 'required|exists:jenis_inventaris,id_jenis_inventaris',
            'kode_unit' => 'required',
            'tanggal_beli' => 'required|date',
            'harga_beli' => 'required|numeric',
            'kondisi_unit' => 'required'
        ]);

        return InventarisPerUnit::create($data);
    }

    public function show($id)
    {
        return InventarisPerUnit::with('jenis')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'id_jenis' => 'required|exists:jenis_inventaris,id_jenis_inventaris',
            'kode_unit' => 'required',
            'tanggal_beli' => 'required|date',
            'harga_beli' => 'required|numeric',
            'kondisi_unit' => 'required'
        ]);

        $item = InventarisPerUnit::findOrFail($id);
        $item->update($data);

        return $item;
    }

    public function destroy($id)
    {
        InventarisPerUnit::destroy($id);
        return response()->json(['message' => 'Data dihapus']);
    }
}