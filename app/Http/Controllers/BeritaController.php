<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function index()
    {
        $data = Berita::all();
        return view('berita.index', compact('data'));
    }

    public function store(Request $request)
    {
        Berita::create($request->all());
        return redirect()->back();
    }

    public function destroy($id)
    {
        Berita::destroy($id);
        return redirect()->back();
    }
}
