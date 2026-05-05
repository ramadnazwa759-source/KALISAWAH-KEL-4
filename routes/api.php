<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BookingController;
use App\Http\Controllers\API\KategoriPaketController;
use App\Http\Controllers\API\PaketWisataController;
use App\Http\Controllers\API\JenisInventarisController;
use App\Http\Controllers\API\InventarisPerUnitController;

Route::get('/test', function () {
    return "API WORKING";
});

// Auth
Route::post('/register', [AuthController::class, 'register']); // dari kamu
Route::post('/login', [AuthController::class, 'login']);

// Booking user (pengunjung)
Route::post('/bookings', [BookingController::class, 'storeUser']);


Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

// Admin
Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {

    Route::apiResource('kategori-paket', KategoriPaketController::class);
    Route::apiResource('paket-wisata', PaketWisataController::class);
    Route::apiResource('bookings', BookingController::class);
    Route::apiResource('jenis-inventaris', JenisInventarisController::class);
    Route::apiResource('inventaris-unit', InventarisPerUnitController::class);
});
