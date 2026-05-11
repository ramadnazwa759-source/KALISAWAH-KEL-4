<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\KategoriPaketController;
use App\Http\Controllers\Api\PaketWisataController;
use App\Http\Controllers\Api\ProfilWisataController;
use App\Http\Controllers\Api\FasilitasController;
use App\Http\Controllers\Api\PaketFasilitasController;

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