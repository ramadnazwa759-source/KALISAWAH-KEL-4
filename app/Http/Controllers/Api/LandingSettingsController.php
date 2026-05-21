<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\LandingSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LandingSettingsController extends Controller
{
    /**
     * Ambil landing setting
     */
    public function index()
    {
        $setting = LandingSetting::first();

        return response()->json([
            'success' => true,
            'data' => $setting
        ]);
    }

    /**
     * Tambah landing setting
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'hero_title' => 'nullable|string|max:255',
            'hero_subtitle' => 'nullable|string',
            'hero_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // cek apakah sudah ada data lama
        $oldSetting = LandingSetting::first();

        // jika ada data lama, hapus file lama & data lama
        if ($oldSetting) {

            // hapus gambar lama
            if (
                $oldSetting->hero_image_path &&
                Storage::disk('local')->exists($oldSetting->hero_image_path)
            ) {
                Storage::disk('local')->delete($oldSetting->hero_image_path);
            }

            // hapus data lama
            $oldSetting->delete();
        }

        // buat data baru
        $setting = new LandingSetting();

        /**
         * Hero title
         */
        if ($request->filled('hero_title')) {
            $setting->hero_title = $request->hero_title;
        }

        /**
         * Hero subtitle
         */
        if ($request->filled('hero_subtitle')) {
            $setting->hero_subtitle = $request->hero_subtitle;
        }

        /**
         * Hero image
         */
        if ($request->hasFile('hero_image')) {

            // generate nama file aman
            $filename = Str::uuid() . '.' .
                $request->file('hero_image')->getClientOriginalExtension();

            // simpan file ke storage/app/landing
            $path = $request->file('hero_image')
                ->storeAs('landing', $filename, 'local');

            // simpan path file
            $setting->hero_image_path = $path;
        }

        // simpan data
        $setting->save();

        return response()->json([
            'success' => true,
            'message' => 'Landing setting berhasil ditambahkan',
            'data' => $setting
        ], 201);
    }

    /**
     * Update landing setting
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'hero_title' => 'nullable|string|max:255',
            'hero_subtitle' => 'nullable|string',
            'hero_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // ambil data berdasarkan id
        $setting = LandingSetting::findOrFail($id);

        /**
         * Update hero title
         */
        if ($request->filled('hero_title')) {
            $setting->hero_title = $request->hero_title;
        }

        /**
         * Update hero subtitle
         */
        if ($request->filled('hero_subtitle')) {
            $setting->hero_subtitle = $request->hero_subtitle;
        }

        /**
         * Update hero image
         */
        if ($request->hasFile('hero_image')) {

            // hapus file lama
            if (
                $setting->hero_image_path &&
                Storage::disk('local')->exists($setting->hero_image_path)
            ) {
                Storage::disk('local')->delete($setting->hero_image_path);
            }

            // generate nama file aman
            $filename = Str::uuid() . '.' .
                $request->file('hero_image')->getClientOriginalExtension();

            // simpan file baru
            $path = $request->file('hero_image')
                ->storeAs('landing', $filename, 'local');

            // simpan path file baru
            $setting->hero_image_path = $path;
        }

        // simpan perubahan
        $setting->save();

        return response()->json([
            'success' => true,
            'message' => 'Landing setting berhasil diperbarui',
            'data' => $setting
        ]);
    }
}