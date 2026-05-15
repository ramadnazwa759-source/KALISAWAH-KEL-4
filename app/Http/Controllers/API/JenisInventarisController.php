<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JenisInventaris;

class JenisInventarisController extends Controller
{
    public function index()
    {
       $data = JenisInventaris::all();

        return view('admin.operasional.jenisInventaris.index', compact('data'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_barang' => 'required',
            'kategori' => 'required',
            'keterangan' => 'nullable'
        ]);

        JenisInventaris::create($data);

        return redirect()->route('admin.jenisInventaris.index')->with('success', 'Data inventaris berhasil ditambahkan!'); //frondend
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

        return redirect() ->route('admin.jenisInventaris.index')->with('success', 'Data inventaris berhasil diperbarui!');
    }

   public function destroy($id)
    {
    $item = JenisInventaris::findOrFail($id);

    $item->delete();


    return redirect()->route('admin.jenisInventaris.index')->with('success', 'Jenis inventaris "' . $item->nama_barang . '" berhasil dihapus!');
    }
}
