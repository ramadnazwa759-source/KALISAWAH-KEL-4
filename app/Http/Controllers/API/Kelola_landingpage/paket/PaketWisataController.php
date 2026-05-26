<?php

namespace App\Http\Controllers\API\Kelola_landingpage\paket;

use App\Http\Controllers\Controller;
use App\Models\PaketWisata;
use Illuminate\Http\Request;
use App\Models\KategoriPaket; // untuk ambil data kategori di dropdown modal

class PaketWisataController extends Controller
{
    // GET /api/paket-wisata
    public function index()
    {
        $data = PaketWisata::all();

        // Ambil data kategori untuk modal tambah
        $categories = KategoriPaket::all();

        // Pastikan nama di dalam compact sesuai dengan nama variabel di atas
        return view('admin.layanan.PaketWisata.index', compact('data', 'categories'));
    }


    public function show($id)
    {
        $paket = PaketWisata::find($id);

        if (!$paket) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json($paket, 200);
    }

    // POST
    public function store(Request $request)
    {
        $request->validate([
            'kategori_paket_id' => 'required|exists:kategori_paket,id',
            'nama_paket' => 'required|string',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric',
            'kapasitas' => 'required|integer',
            'durasi' => 'required|string',
            'status' => 'required|string',
        ]);

        $paket = PaketWisata::create($request->all());

        return redirect()->route('admin.paket-wisata.index')->with('success', 'Paket berhasil ditambah');

    }

    // PUT
    public function update(Request $request, $id)
    {
        $paket = PaketWisata::find($id);

        if (!$paket) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $paket->update($request->all());

        return redirect()->route('admin.paket-wisata.index')->with('success', 'Paket berhasil diedit');
    }

    // DELETE
    public function destroy($id)
    {
        $paket = PaketWisata::find($id);

        if (!$paket) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $paket->delete();

        return redirect()->route('admin.paket-wisata.index')->with('success', 'Paket berhasil dihapus');

    }
}
