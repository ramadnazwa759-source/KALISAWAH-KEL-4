<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\KategoriPaketController;
use App\Http\Controllers\Api\PaketWisataController;

// CRUD Kategori Paket
Route::apiResource('kategori-paket', KategoriPaketController::class);

// CRUD Paket Wisata
Route::apiResource('paket-wisata', PaketWisataController::class);