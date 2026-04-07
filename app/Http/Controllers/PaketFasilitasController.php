<?php

namespace App\Http\Controllers;

use App\Models\PaketFasilitas;
use App\Models\PaketWisata;
use App\Models\Fasilitas;
use Illuminate\Http\Request;

class PaketFasilitasController extends Controller
{
    public function index()
    {
        $data = PaketFasilitas::with('paket','fasilitas')->get();
        return view('paket_fasilitas.index', compact('data'));
    }

    public function create()
    {
        $paket = PaketWisata::all();
        $fasilitas = Fasilitas::all();
        return view('paket_fasilitas.create', compact('paket','fasilitas'));
    }

    public function store(Request $request)
    {
        PaketFasilitas::create($request->all());
        return redirect('/paket-fasilitas');
    }

    public function edit($id)
    {
        $data = PaketFasilitas::findOrFail($id);
        $paket = PaketWisata::all();
        $fasilitas = Fasilitas::all();
        return view('paket_fasilitas.edit', compact('data','paket','fasilitas'));
    }

    public function update(Request $request, $id)
    {
        PaketFasilitas::findOrFail($id)->update($request->all());
        return redirect('/paket-fasilitas');
    }

    public function destroy($id)
    {
        PaketFasilitas::destroy($id);
        return redirect()->back();
    }
}
