<?php

namespace App\Http\Controllers;

use App\Models\ProfilWisata;
use Illuminate\Http\Request;

class ProfilWisataController extends Controller
{
    public function index()
    {
        $categories = \App\Models\KategoriPaket::all();
        $kabars = \App\Models\Berita::latest('tanggal')->get();
        return view('home', compact('categories', 'kabars'));
    }

    public function showKabar($slug)
    {
        $berita = \App\Models\Berita::all()->first(function ($item) use ($slug) {
            return \Illuminate\Support\Str::slug($item->judul) === $slug;
        });

        if (!$berita) {
            abort(404);
        }

        return view('kabar-detail', compact('berita'));
    }

    public function camping()
    {
        $kategori = \App\Models\KategoriPaket::where('nama_kategori', 'like', '%camping%')->first();
        
        if ($kategori) {
            $pakets = \App\Models\PaketWisata::where('id_kategori', $kategori->id_kategori ?? $kategori->id)
                ->orWhere('kategori_paket_id', $kategori->id)
                ->with('fasilitas')
                ->get();
        } else {
            $pakets = collect();
        }

        return view('camping', compact('pakets'));
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
