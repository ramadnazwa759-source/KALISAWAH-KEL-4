<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;

class GaleriController extends Controller
{
    public function index()
    {
        $data = Galeri::all();
        return view('galeri.index', compact('data'));
    }

    public function create()
    {
        return view('galeri.create');
    }

    public function store(Request $request)
    {
        $file = $request->file('gambar');
        $nama_file = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('gambar'), $nama_file);

        Galeri::create([
            'judul' => $request->judul,
            'gambar' => $nama_file
        ]);

        return redirect('/galeri');
    }

    public function destroy($id)
    {
        Galeri::destroy($id);
        return redirect()->back();
    }
}
