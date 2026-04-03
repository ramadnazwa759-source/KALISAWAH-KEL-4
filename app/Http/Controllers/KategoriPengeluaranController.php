<?php

namespace App\Http\Controllers;

use App\Models\KategoriPengeluaran;
use Illuminate\Http\Request;

class KategoriPengeluaranController extends Controller
{
    public function index()
    {
        $data = KategoriPengeluaran::all();
        return view('kategori_pengeluaran.index', compact('data'));
    }

    public function store(Request $request)
    {
        KategoriPengeluaran::create($request->all());
        return redirect()->back();
    }

    public function destroy($id)
    {
        KategoriPengeluaran::destroy($id);
        return redirect()->back();
    }
}
