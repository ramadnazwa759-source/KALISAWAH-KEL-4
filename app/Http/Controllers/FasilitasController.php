<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fasilitas;

class FasilitasController extends Controller
{
    // tampil data
    public function index()
    {
        $data = Fasilitas::all();
        return view('fasilitas.index', compact('data'));
    }

    // form tambah
    public function create()
    {
        return view('fasilitas.create');
    }

    // simpan data
    public function store(Request $request)
    {
        $request->validate([
            'nama_fasilitas' => 'required',
            'keterangan' => 'required',
            'harga_satuan' => 'required|numeric',
            'kategori' => 'required'
        ]);

        Fasilitas::create($request->all());

        return redirect('/fasilitas');
    }

    // form edit
    public function edit($id)
    {
        $data = Fasilitas::findOrFail($id);
        return view('fasilitas.edit', compact('data'));
    }

    // update data
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_fasilitas' => 'required',
            'keterangan' => 'required',
            'harga_satuan' => 'required|numeric',
            'kategori' => 'required'
        ]);

        $data = Fasilitas::findOrFail($id);
        $data->update($request->all());

        return redirect('/fasilitas');
    }

    // hapus data
    public function destroy($id)
    {
        Fasilitas::destroy($id);
        return redirect('/fasilitas');
    }
}
