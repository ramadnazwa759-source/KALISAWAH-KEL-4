<?php

namespace App\Http\Controllers;

use App\Models\JenisInventaris;
use Illuminate\Http\Request;

class JenisInventarisController extends Controller
{
    public function index()
    {
        $data = JenisInventaris::all();
        return view('jenis_inventaris.index', compact('data'));
    }

    public function create()
    {
        return view('jenis_inventaris.create');
    }

    public function store(Request $request)
    {
        JenisInventaris::create([
            'nama_jenis' => $request->nama_jenis
        ]);

        return redirect('/jenis-inventaris');
    }

    public function edit($id)
    {
        $data = JenisInventaris::findOrFail($id);
        return view('jenis_inventaris.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        JenisInventaris::findOrFail($id)->update([
            'nama_jenis' => $request->nama_jenis
        ]);

        return redirect('/jenis-inventaris');
    }

    public function destroy($id)
    {
        JenisInventaris::destroy($id);
        return redirect()->back();
    }
}
