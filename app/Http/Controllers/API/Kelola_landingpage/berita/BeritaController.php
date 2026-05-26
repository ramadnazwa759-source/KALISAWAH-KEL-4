<?php

namespace App\Http\Controllers\API\Kelola_landingpage\berita;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    // GET semua berita
    public function index()
    {
        // return response()->json(Berita::all(), 200);
        $beritas = Berita::paginate(10);
        return view('admin.kelola_halaman.berita', compact('beritas'));
    }

    // GET detail berita
    public function show($id)
    {
        $berita = Berita::find($id);

        if (!$berita) {
            return response()->json(['message' => 'Berita tidak ditemukan'], 404);
        }

        return response()->json($berita, 200);
    }

    // POST tambah berita
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'       => 'required|string|max:255',
            'isi_berita'  => 'required',
            'tanggal'     => 'required|date',
            'foto'        => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // simpan foto ke storage private
        $path = $request->file('foto')->store('berita');

        $berita = Berita::create([
            'judul'       => $validated['judul'],
            'isi_berita'  => $validated['isi_berita'],
            'tanggal'     => $validated['tanggal'],
            'foto'        => $path,
        ]);

        // return response()->json([
        //     'message' => 'Berita berhasil ditambahkan',
        //     'data'    => $berita
        // ], 201);

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil ditambahkan');
    }

    // PUT update berita
    public function update(Request $request, $id)
    {
        $berita = Berita::find($id);

        if (!$berita) {
            return response()->json(['message' => 'Berita tidak ditemukan'], 404);
        }

        $validated = $request->validate([
            'judul'       => 'sometimes|required|string|max:255',
            'isi_berita'  => 'sometimes|required',
            'tanggal'     => 'sometimes|required|date',
            'foto'        => 'sometimes|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            // hapus foto lama
            if ($berita->foto && Storage::exists($berita->foto)) {
                Storage::delete($berita->foto);
            }

            $path = $request->file('foto')->store('berita');
            $berita->foto = $path;
        }

        $berita->update($validated);

        return response()->json([
            'message' => 'Berita berhasil diperbarui',
            'data'    => $berita
        ], 200);
    }

    // DELETE berita
    public function destroy($id)
    {
        $berita = Berita::find($id);

        if (!$berita) {
            return response()->json(['message' => 'Berita tidak ditemukan'], 404);
        }

        // hapus foto dari storage
        if ($berita->foto && Storage::exists($berita->foto)) {
            Storage::delete($berita->foto);
        }

        $berita->delete();

        return response()->json(['message' => 'Berita berhasil dihapus'], 200);
    }

    // GET tampilkan foto (private access)
    public function getFoto($id)
    {
        $berita = Berita::find($id);

        if (!$berita || !Storage::exists($berita->foto)) {
            return response()->json(['message' => 'Foto tidak ditemukan'], 404);
        }

        $file = Storage::get($berita->foto);
        $type = Storage::mimeType($berita->foto);

        return response($file, 200)->header('Content-Type', $type);
    }
}
