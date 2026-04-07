<?php

namespace App\Http\Controllers;

use App\Models\KategoriPaket;
use Illuminate\Http\Request;

class KategoriPaketController extends Controller
{
    public function index()
    {
        $data = KategoriPaket::all();
        return view('kategori.index', compact('data'));
    }

    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        KategoriPaket::create([
            'nama_kategori' => $request->nama_kategori
        ]);

        return redirect('/kategori');
    }

    public function edit($id)
    {
        $data = KategoriPaket::findOrFail($id);
        return view('kategori.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        KategoriPaket::findOrFail($id)->update([
            'nama_kategori' => $request->nama_kategori
        ]);

        return redirect('/kategori');
    }

    public function destroy($id)
    {
        KategoriPaket::destroy($id);
        return redirect()->back();
    }
}
