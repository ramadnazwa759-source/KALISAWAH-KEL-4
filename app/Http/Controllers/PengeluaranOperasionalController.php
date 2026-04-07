<?php

namespace App\Http\Controllers;

use App\Models\PengeluaranOperasional;
use App\Models\KategoriPengeluaran;
use Illuminate\Http\Request;

class PengeluaranOperasionalController extends Controller
{
    public function index()
    {
        $data = PengeluaranOperasional::with('kategori')->get();
        return view('pengeluaran.index', compact('data'));
    }

    public function create()
    {
        $kategori = KategoriPengeluaran::all();
        return view('pengeluaran.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        PengeluaranOperasional::create([
            'id_kategori' => $request->id_kategori,
            'nama_pengeluaran' => $request->nama_pengeluaran,
            'jumlah' => $request->jumlah,
            'tanggal' => $request->tanggal
        ]);

        return redirect('/pengeluaran');
    }

    public function edit($id)
    {
        $data = PengeluaranOperasional::findOrFail($id);
        $kategori = KategoriPengeluaran::all();
        return view('pengeluaran.edit', compact('data','kategori'));
    }

    public function update(Request $request, $id)
    {
        PengeluaranOperasional::findOrFail($id)->update([
            'id_kategori' => $request->id_kategori,
            'nama_pengeluaran' => $request->nama_pengeluaran,
            'jumlah' => $request->jumlah,
            'tanggal' => $request->tanggal
        ]);

        return redirect('/pengeluaran');
    }

    public function destroy($id)
    {
        PengeluaranOperasional::destroy($id);
        return redirect()->back();
    }
}
