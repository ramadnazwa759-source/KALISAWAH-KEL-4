<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\KategoriPaketController;
use App\Http\Controllers\API\PaketWisataController;
use App\Http\Controllers\API\ProfilWisataController;
use App\Http\Controllers\API\FasilitasController;
use App\Http\Controllers\API\PaketFasilitasController;
use App\Http\Controllers\API\KategoriPengeluaranController;
use App\Http\Controllers\API\PengeluaranOperasionalController;
use App\Http\Controllers\API\BookingFasilitasController;
use App\Http\Controllers\API\BeritaController;
use App\Http\Controllers\API\ClientLogosController;
use App\Http\Controllers\API\LandingSettingsController ;
use App\Http\Controllers\API\TestimoniController;
use App\Http\Controllers\Api\DashboardController;

// CRUD Kategori Paket
Route::apiResource('kategori-paket', KategoriPaketController::class);

// CRUD Paket Wisata
Route::apiResource('paket-wisata', PaketWisataController::class);

//profil wisata
Route::apiResource('profil-wisata', ProfilWisataController::class);

// CRUD Fasilitas
Route::apiResource('fasilitas', FasilitasController::class);

// CRUD Paket Fasilitas 
Route::apiResource('paket-fasilitas', PaketFasilitasController::class);

//CRUD kategori pengeluaran
Route::apiResource('kategori-pengeluaran', KategoriPengeluaranController::class);

//CRUD pengeluaran operasional
Route::apiResource('pengeluaran-operasional', PengeluaranOperasionalController::class);

//CRUD booking fasilitas
Route::apiResource('booking-fasilitas', BookingFasilitasController::class);

//CRUD berita
Route::apiResource('berita', BeritaController::class);

//CRUD client logos
Route::apiResource('client-logos', ClientLogosController::class);

//CRUD landing page settings
Route::apiResource('landing-settings', LandingSettingsController::class);

//CRUD testimoni
Route::apiResource('testimoni', TestimoniController::class);

// Dashboard API
Route::get('dashboard', [App\Http\Controllers\Api\DashboardController::class, 'index']);

