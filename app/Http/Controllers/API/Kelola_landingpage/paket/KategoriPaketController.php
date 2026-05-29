<?php

namespace App\Http\Controllers\API\Kelola_landingpage\paket;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KategoriPaket;
use Illuminate\Support\Facades\Storage;

class KategoriPaketController extends Controller
{
<<<<<<< HEAD

    // MENAMPILKAN SEMUA DATA
    public function index()
    {
        // // ambil semua data dari tabel kategori_paket
        // return response()->json(KategoriPaket::all(), 200);

        // Mengambil data dari database (sesuaikan dengan desain pagination di Figma)
        $kategoris = KategoriPaket::paginate(6);

        // 'admin.kategori.index' adalah lokasi file .blade.php kamu
        // 'compact' digunakan untuk melempar data agar bisa dibaca oleh @foreach
        return view('admin.layanan.kategoriPaket.index', compact('kategoris'));

=======
    /**
     * Menampilkan semua kategori paket
     */
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => KategoriPaket::all()
        ]);
>>>>>>> e97c2c2188fc6e4fafeedbb9efc1480778ecdf6b
    }

    /**
     * Menampilkan detail kategori berdasarkan ID
     */
    public function show($id)
    {
        $data = KategoriPaket::find($id);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Menambahkan kategori paket
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi'     => 'nullable|string',
            'gambar'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

<<<<<<< HEAD
        $path = null;

        // jika ada file gambar yang dikirim
=======
        /**
         * Upload gambar ke private storage
         */
>>>>>>> e97c2c2188fc6e4fafeedbb9efc1480778ecdf6b
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store(
                'private/kategori_paket',
                'local'
            );
        }

        $data = KategoriPaket::create($validated);

<<<<<<< HEAD
        // kirim response berhasil
        return redirect()->route('admin.kategori-paket.index')->with('success', 'Kategori berhasil ditambah!');
    }


    // UPDATE DATA + GANTI GAMBAR
=======
        return response()->json([
            'success' => true,
            'message' => 'Kategori paket berhasil ditambahkan',
            'data'    => $data
        ], 201);
    }

    /**
     * Update kategori paket
     */
>>>>>>> e97c2c2188fc6e4fafeedbb9efc1480778ecdf6b
    public function update(Request $request, $id)
    {
        $data = KategoriPaket::find($id);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi'     => 'nullable|string',
            'gambar'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        /**
         * Jika ada gambar baru
         */
        if ($request->hasFile('gambar')) {

            /**
             * Hapus gambar lama
             */
            if (
                $data->gambar &&
                Storage::disk('local')->exists($data->gambar)
            ) {
                Storage::disk('local')->delete($data->gambar);
            }

            /**
             * Simpan gambar baru
             */
            $validated['gambar'] = $request->file('gambar')->store(
                'private/kategori_paket',
                'local'
            );
        }

        $data->update($validated);

<<<<<<< HEAD
        return redirect()->route('admin.kategori-paket.index')->with('success', 'Kategori berhasil diperbarui!');
=======
        return response()->json([
            'success' => true,
            'message' => 'Kategori paket berhasil diperbarui',
            'data'    => $data->fresh()
        ]);
>>>>>>> e97c2c2188fc6e4fafeedbb9efc1480778ecdf6b
    }

    /**
     * Hapus kategori paket
     */
    public function destroy($id)
    {
        $data = KategoriPaket::find($id);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        /**
         * Hapus file gambar dari storage
         */
        if (
            $data->gambar &&
            Storage::disk('local')->exists($data->gambar)
        ) {
            Storage::disk('local')->delete($data->gambar);
        }

        $data->delete();

<<<<<<< HEAD
        return redirect()->route('admin.kategori-paket.index')->with('success', 'Kategori berhasil dihapus!');
=======
        return response()->json([
            'success' => true,
            'message' => 'Kategori paket berhasil dihapus'
        ]);
>>>>>>> e97c2c2188fc6e4fafeedbb9efc1480778ecdf6b
    }
}
