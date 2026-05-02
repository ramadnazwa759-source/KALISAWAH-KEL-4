<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BookingController;
use App\Http\Controllers\API\KategoriPaketController;
use App\Http\Controllers\API\PaketWisataController;

    // route public
    Route::get('/test', function () {
        return "API WORKING";
    });

    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/bookings', [BookingController::class, 'storeUser']); //booking pengunjung

    // route protected
    Route::middleware('auth:sanctum')->group(function () {

        Route::post('/logout', [AuthController::class, 'logout']);

        Route::get('/user', function (Request $request) {
            return $request->user();
        });
    });

    Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {

    Route::apiResource('kategori-paket', KategoriPaketController::class);
    Route::apiResource('paket-wisata', PaketWisataController::class);
    Route::apiResource('bookings', BookingController::class);

});