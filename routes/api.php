<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\KategoriPaketController;
use App\Http\Controllers\Api\PaketWisataController;

// TEST
Route::get('/test', function () {
    return "API WORKING";
});

// AUTH
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// ROUTE YANG BUTUH LOGIN
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // KATEGORI PAKET
    Route::apiResource('kategori-paket', KategoriPaketController::class);

    // PAKET WISATA
    Route::apiResource('paket-wisata', PaketWisataController::class);
});
