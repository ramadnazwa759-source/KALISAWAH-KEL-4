<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\BookingController;
use App\Http\Controllers\API\KategoriPaketController;
use App\Http\Controllers\API\PaketWisataController;

use App\Http\Controllers\API\PaketFasilitasController;
use App\Http\Controllers\API\ProfilWisataController;

use App\Http\Controllers\API\Inventaris\KategoriInventarisController;
use App\Http\Controllers\API\Inventaris\SubkategoriInventarisController;
use App\Http\Controllers\API\Inventaris\LokasiPenyimpananController;
use App\Http\Controllers\API\Inventaris\JenisInventarisController;
use App\Http\Controllers\API\Inventaris\InventarisPerUnitController;

use App\Http\Controllers\API\Kelola_fasilitas\KategoriFasilitasController;
use App\Http\Controllers\API\Kelola_fasilitas\FasilitasController;
use App\Http\Controllers\API\Kelola_booking\BookingFasilitasController;



    // route public
    Route::get('/test', function () {
        return "API WORKING";
    });

    Route::post('/login', [AuthController::class, 'login']);

    Route::post('/bookings', [BookingController::class, 'storeUser']);
    Route::get('/bookings/{id}', [BookingController::class, 'showUser']);

    // route protected
    Route::middleware('auth:sanctum')->group(function () {

        Route::post('/logout', [AuthController::class, 'logout']);

        Route::get('/user', function (Request $request) {
            return $request->user();
        });
    });

    // route khusus admin
    Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {

        // pengelolaan paket wisata
        Route::apiResource('kategori-paket', KategoriPaketController::class);
        Route::apiResource('paket-wisata', PaketWisataController::class);
        
        // pengelolaan landing page (masih ngambang)
        Route::apiResource('profil-wisata', ProfilWisataController::class);

        // proses dan pengelolaan booking
        Route::apiResource('bookings', BookingController::class);
        Route::put('bookings/{id}/tambah-fasilitas', [
        BookingController::class,
        'tambahFasilitas'
        ]);


        // pengelolaan fasilitas
        Route::apiResource('kategori-fasilitas', KategoriFasilitasController::class);
        Route::apiResource('fasilitas', FasilitasController::class);
        Route::apiResource('paket-fasilitas', PaketFasilitasController::class);

        // pengelolaan inventaris
        Route::apiResource('kategori-inventaris', KategoriInventarisController::class);
        Route::apiResource('subkategori-inventaris', SubkategoriInventarisController::class);
        Route::apiResource('lokasi-penyimpanan', LokasiPenyimpananController::class);
        Route::apiResource('jenis-inventaris', JenisInventarisController::class);
        Route::apiResource('inventaris-unit', InventarisPerUnitController::class);
        


});
