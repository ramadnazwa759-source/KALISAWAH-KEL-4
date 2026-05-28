<?php

namespace App\Http\Controllers\API\Kelola_landingpage\experience;

use App\Http\Controllers\Controller;
use App\Models\ClientLogo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClientLogosController extends Controller
{
    /**
     * Ambil semua logo perusahaan
     */
    public function index()
    {
        $logos = ClientLogo::latest()->get();

        return response()->json([
            'success' => true,
            'data' => $logos
        ]);
    }

    /**
     * Tambah logo perusahaan
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'logo_image_path' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $path = $request->file('logo_image_path')->store(
            'private/logos',
            'local'
        );

        $logo = ClientLogo::create([
            'company_name' => $validated['company_name'],
            'logo_image_path' => $path,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Logo perusahaan berhasil ditambahkan',
            'data' => $logo
        ], 201);
    }

    /**
     * Update logo perusahaan
     */
    public function update(Request $request, $id)
    {
        $logo = ClientLogo::find($id);

        if (!$logo) {
            return response()->json([
                'success' => false,
                'message' => 'Logo perusahaan tidak ditemukan'
            ], 404);
        }

        $validated = $request->validate([
            'company_name' => 'sometimes|required|string|max:255',
            'logo_image_path' => 'sometimes|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('logo_image_path')) {

            if (
                $logo->logo_image_path &&
                Storage::disk('local')->exists($logo->logo_image_path)
            ) {
                Storage::disk('local')->delete($logo->logo_image_path);
            }

            $validated['logo_image_path'] = $request
                ->file('logo_image_path')
                ->store(
                    'private/logos',
                    'local'
                );
        }

        $logo->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Logo perusahaan berhasil diperbarui',
            'data' => $logo->fresh()
        ]);
    }

    /**
     * Hapus logo perusahaan
     */
    public function destroy($id)
    {
        $logo = ClientLogo::find($id);

        if (!$logo) {
            return response()->json([
                'success' => false,
                'message' => 'Logo perusahaan tidak ditemukan'
            ], 404);
        }

        if (
            $logo->logo_image_path &&
            Storage::disk('local')->exists($logo->logo_image_path)
        ) {
            Storage::disk('local')->delete($logo->logo_image_path);
        }

        $logo->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logo perusahaan berhasil dihapus'
        ]);
    }
}