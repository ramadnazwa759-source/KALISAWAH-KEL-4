<?php

namespace App\Http\Controllers\API\Pembayaran;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Storage;

class PembayaranAdminController extends Controller
{
    public function index()
    {
        $data = Pembayaran::with('booking')->get();

        return response()->json($data);
    }

    public function show($id)
    {
        $pembayaran = Pembayaran::with('booking')
            ->findOrFail($id);

        return response()->json($pembayaran);
    }

    public function updatePembayaran(Request $request, $id)
    {
        $request->validate([

            'bukti_pembayaran_dp' =>
                'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',

            'bukti_pelunasan' =>
                'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',

            'id_diskon' =>
                'nullable|exists:diskon,id_diskon',

            'total_harga_akhir' =>
                'nullable|numeric|min:0',

            'status' =>
                'required|in:menunggu_verifikasi,diterima,ditolak,lunas',
        ]);

        $pembayaran = Pembayaran::findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | Upload ulang bukti DP
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('bukti_pembayaran_dp')) {

            if (!$request->file('bukti_pembayaran_dp')->isValid()) {

                return response()->json([
                    'message' => 'File DP tidak valid'
                ], 400);
            }

            if ($pembayaran->bukti_pembayaran_dp) {

                Storage::disk('public')
                    ->delete($pembayaran->bukti_pembayaran_dp);
            }

            $pathDP = $request
                ->file('bukti_pembayaran_dp')
                ->store('bukti-pembayaran/dp', 'public');

            $pembayaran->bukti_pembayaran_dp = $pathDP;
        }

        /*
        |--------------------------------------------------------------------------
        | Upload bukti pelunasan
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('bukti_pelunasan')) {

            if (!$request->file('bukti_pelunasan')->isValid()) {

                return response()->json([
                    'message' => 'File pelunasan tidak valid'
                ], 400);
            }

            if ($pembayaran->bukti_pelunasan) {

                Storage::disk('public')
                    ->delete($pembayaran->bukti_pelunasan);
            }

            $pathPelunasan = $request
                ->file('bukti_pelunasan')
                ->store('bukti-pembayaran/pelunasan', 'public');

            $pembayaran->bukti_pelunasan = $pathPelunasan;

            $pembayaran->tanggal_pelunasan = now();
        }

        /*
        |--------------------------------------------------------------------------
        | Update Data Pembayaran
        |--------------------------------------------------------------------------
        */

        $pembayaran->id_diskon =
            $request->id_diskon;

        $pembayaran->total_harga_akhir =
            $request->total_harga_akhir
            ?? $pembayaran->total_harga_akhir;

        $pembayaran->status =
            $request->status;

        $pembayaran->save();

        return response()->json([
            'message' => 'Data pembayaran berhasil diperbarui',
            'data' => $pembayaran
        ]);
    }

    public function destroy($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);

        if ($pembayaran->bukti_pembayaran_dp) {

            Storage::disk('public')
                ->delete($pembayaran->bukti_pembayaran_dp);
        }

        if ($pembayaran->bukti_pelunasan) {

            Storage::disk('public')
                ->delete($pembayaran->bukti_pelunasan);
        }

        $pembayaran->delete();

        return response()->json([
            'message' => 'Data pembayaran berhasil dihapus'
        ]);
    }
}