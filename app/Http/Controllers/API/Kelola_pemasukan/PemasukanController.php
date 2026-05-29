<?php

namespace App\Http\Controllers\API\Kelola_pemasukan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Pemasukan;

use Illuminate\Support\Facades\DB;

class PemasukanController extends Controller
{
    // ======================================================
    // LIST PEMASUKAN
    // ======================================================
    public function index()
    {
        $data = Pemasukan::latest()->get();

        return response()->json($data, 200);
    }

    // ======================================================
    // DETAIL PEMASUKAN
    // ======================================================
    public function show($id)
    {
        $data = Pemasukan::find($id);

        if (!$data) {

            return response()->json([
                'message' => 'Data pemasukan tidak ditemukan'
            ], 404);
        }

        return response()->json($data, 200);
    }

    // ======================================================
    // TAMBAH PEMASUKAN MANUAL
    // ======================================================
    public function store(Request $request)
    {
        $request->validate([

            'sumber_pemasukan' =>
                'required|string|max:255',

            'keterangan' =>
                'nullable|string',

            'jumlah_uang' =>
                'required|numeric|min:1',

            'tanggal_pemasukan' =>
                'required|date'
        ]);

        DB::beginTransaction();

        try {

            $pemasukan = Pemasukan::create([

                'sumber_pemasukan' =>
                    $request->sumber_pemasukan,

                'keterangan' =>
                    $request->keterangan,

                'jumlah_uang' =>
                    $request->jumlah_uang,

                'tanggal_pemasukan' =>
                    $request->tanggal_pemasukan,

                'dicatat_oleh' =>
                    auth()->user()->name
            ]);

            DB::commit();

            return response()->json([

                'message' =>
                    'Pemasukan berhasil ditambahkan',

                'data' =>
                    $pemasukan
            ], 201);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // ======================================================
    // UPDATE PEMASUKAN
    // ======================================================
    public function update(Request $request, $id)
    {
        $request->validate([

            'sumber_pemasukan' =>
                'required|string|max:255',

            'keterangan' =>
                'nullable|string',

            'jumlah_uang' =>
                'required|numeric|min:1',

            'tanggal_pemasukan' =>
                'required|date'
        ]);

        DB::beginTransaction();

        try {

            $pemasukan = Pemasukan::find($id);

            if (!$pemasukan) {

                return response()->json([
                    'message' => 'Data pemasukan tidak ditemukan'
                ], 404);
            }

            $pemasukan->update([

                'sumber_pemasukan' =>
                    $request->sumber_pemasukan,

                'keterangan' =>
                    $request->keterangan,

                'jumlah_uang' =>
                    $request->jumlah_uang,

                'tanggal_pemasukan' =>
                    $request->tanggal_pemasukan
            ]);

            DB::commit();

            return response()->json([

                'message' =>
                    'Pemasukan berhasil diupdate',

                'data' =>
                    $pemasukan
            ], 200);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // ======================================================
    // HAPUS PEMASUKAN
    // ======================================================
    public function destroy($id)
    {
        $data = Pemasukan::find($id);

        if (!$data) {

            return response()->json([
                'message' => 'Data pemasukan tidak ditemukan'
            ], 404);
        }

        $data->delete();

        return response()->json([
            'message' => 'Pemasukan berhasil dihapus'
        ], 200);
    }
}