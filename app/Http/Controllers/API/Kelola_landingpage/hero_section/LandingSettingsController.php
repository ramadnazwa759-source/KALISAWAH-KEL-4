<?php

namespace App\Http\Controllers\API\Kelola_landingpage\hero_section;
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LandingSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LandingSettingsController extends Controller
{
    /**
     * Ambil landing setting
     */
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => LandingSetting::first()
        ]);
    }

    /**
     * Tambah landing setting
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'hero_title'    => 'nullable|string|max:255',
            'hero_subtitle' => 'nullable|string',
            'hero_image'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'hero_image_2'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $oldSetting = LandingSetting::first();

        if ($oldSetting) {

            if (
                $oldSetting->hero_image_path &&
                Storage::disk('local')->exists($oldSetting->hero_image_path)
            ) {
                Storage::disk('local')->delete($oldSetting->hero_image_path);
            }

            if (
                $oldSetting->hero_image_path_2 &&
                Storage::disk('local')->exists($oldSetting->hero_image_path_2)
            ) {
                Storage::disk('local')->delete($oldSetting->hero_image_path_2);
            }

            $oldSetting->delete();
        }

        if ($request->hasFile('hero_image')) {
            $validated['hero_image_path'] = $request
                ->file('hero_image')
                ->store('private/landing', 'local');
        }

        if ($request->hasFile('hero_image_2')) {
            $validated['hero_image_path_2'] = $request
                ->file('hero_image_2')
                ->store('private/landing', 'local');
        }

        unset($validated['hero_image']);
        unset($validated['hero_image_2']);

        $setting = LandingSetting::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Landing setting berhasil ditambahkan',
            'data' => $setting
        ], 201);
    }

    /**
     * Update landing setting
     */
    public function update(Request $request, $id)
    {
        $setting = LandingSetting::find($id);

        if (!$setting) {
            return response()->json([
                'success' => false,
                'message' => 'Landing setting tidak ditemukan'
            ], 404);
        }

        $validated = $request->validate([
            'hero_title'    => 'sometimes|nullable|string|max:255',
            'hero_subtitle' => 'sometimes|nullable|string',
            'hero_image'    => 'sometimes|image|mimes:jpg,jpeg,png,webp|max:2048',
            'hero_image_2'  => 'sometimes|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('hero_image')) {

            if (
                $setting->hero_image_path &&
                Storage::disk('local')->exists($setting->hero_image_path)
            ) {
                Storage::disk('local')->delete($setting->hero_image_path);
            }

            $validated['hero_image_path'] = $request
                ->file('hero_image')
                ->store('private/landing', 'local');
        }

        if ($request->hasFile('hero_image_2')) {

            if (
                $setting->hero_image_path_2 &&
                Storage::disk('local')->exists($setting->hero_image_path_2)
            ) {
                Storage::disk('local')->delete($setting->hero_image_path_2);
            }

            $validated['hero_image_path_2'] = $request
                ->file('hero_image_2')
                ->store('private/landing', 'local');
        }

        unset($validated['hero_image']);
        unset($validated['hero_image_2']);

        $setting->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Landing setting berhasil diperbarui',
            'data' => $setting->fresh()
        ]);
    }
}