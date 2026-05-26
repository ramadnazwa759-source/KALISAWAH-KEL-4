<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LandingSetting;
use App\Models\PaketWisata;
use App\Models\Berita;
use App\Models\Testimoni;
use App\Models\ClientLogo;

class DashboardController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,

            'data' => [

                // Hero Section
                'landing_setting' => LandingSetting::first(),

                // Semua Paket Wisata
                'paket_wisata' => PaketWisata::latest()
                    ->get(),

                // 3 Berita Terbaru
                'berita_terbaru' => Berita::orderBy('tanggal', 'desc')
                    ->take(3)
                    ->get(),

                // 4 Testimoni Terbaru
                'testimoni_terbaru' => Testimoni::latest()
                    ->take(4)
                    ->get(),

                // Semua Logo Client / Partner
                'client_logo' => ClientLogo::all(),
            ]
        ], 200);
    }
}