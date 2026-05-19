<?php

namespace App\Http\Controllers;

use App\Models\ProfilWisata;
use Illuminate\Http\Request;

class ProfilWisataController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function create()
    {
        return view('profil.create');
    }

    public function store(Request $request)
    {
        ProfilWisata::create($request->all());
        return redirect('/profil');
    }

    public function edit($id)
    {
        $data = ProfilWisata::findOrFail($id);
        return view('profil.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        ProfilWisata::findOrFail($id)->update($request->all());
        return redirect('/profil');
    }

    public function destroy($id)
    {
        ProfilWisata::destroy($id);
        return redirect()->back();
    }
}
