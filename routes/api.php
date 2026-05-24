<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// AUTH
use App\Http\Controllers\API\Auth\AuthController;

// LANDING PAGE & PROFIL
use App\Http\Controllers\API\ProfilWisataController;
use App\Http\Controllers\API\Kelola_landingpage\berita\BeritaController;
use App\Http\Controllers\API\Kelola_landingpage\experience\ClientLogosController;
use App\Http\Controllers\API\Kelola_landingpage\hero_section\LandingSettingsController;

// PAKET
use App\Http\Controllers\API\Kelola_landingpage\paket\KategoriPaketController;
use App\Http\Controllers\API\Kelola_landingpage\paket\PaketWisataController;
use App\Http\Controllers\API\Kelola_landingpage\paket\PaketFasilitasController;

// FASILITAS
use App\Http\Controllers\API\Kelola_fasilitas\KategoriFasilitasController;
use App\Http\Controllers\API\Kelola_fasilitas\FasilitasController;

// BOOKING
use App\Http\Controllers\API\Kelola_booking\AdminBookingController;
use App\Http\Controllers\API\Booking_pengunjung\BookingController;
use App\Http\Controllers\API\Booking_pengunjung\TrackingBookingController;

// PEMBAYARAN
use App\Http\Controllers\API\Pembayaran\PembayaranPengunjungController;
use App\Http\Controllers\API\Pembayaran\PembayaranAdminController;

// INVENTARIS
use App\Http\Controllers\API\Inventaris\KategoriInventarisController;
use App\Http\Controllers\API\Inventaris\SubkategoriInventarisController;
use App\Http\Controllers\API\Inventaris\LokasiPenyimpananController;
use App\Http\Controllers\API\Inventaris\JenisInventarisController;
use App\Http\Controllers\API\Inventaris\InventarisPerUnitController;

// PENGELUARAN
use App\Http\Controllers\API\Kelola_pengeluaran\KategoriPengeluaranController;
use App\Http\Controllers\API\Kelola_pengeluaran\PengeluaranOperasionalController;

/*
|--------------------------------------------------------------------------
| API TEST
|--------------------------------------------------------------------------
*/

Route::get('/test', function () {
    return "API WORKING";
});

/*
|--------------------------------------------------------------------------
| ROUTE PUBLIC
|--------------------------------------------------------------------------
*/

// login
Route::post('/login', [AuthController::class, 'login']);

// booking pengunjung
Route::post('/bookings', [BookingController::class, 'store']);

// upload pembayaran
Route::post('/pembayaran/{bookingId}/upload', [
    PembayaranPengunjungController::class,
    'uploadBukti'
]);

// tracking booking
Route::post('/tracking-booking', [
    TrackingBookingController::class,
    'track'
]);

Route::get('/tracking-booking/{id}', [
    TrackingBookingController::class,
    'detail'
]);

/*
|--------------------------------------------------------------------------
| ROUTE PROTECTED
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

/*
|--------------------------------------------------------------------------
| ROUTE ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth:sanctum', 'admin'])
    ->prefix('admin')
    ->group(function () {

    // paket wisata
    Route::apiResource('kategori-paket', KategoriPaketController::class);
    Route::apiResource('paket-wisata', PaketWisataController::class);
    Route::apiResource('paket-fasilitas', PaketFasilitasController::class);

    // landing page
    Route::apiResource('profil-wisata', ProfilWisataController::class);
    Route::apiResource('berita', BeritaController::class);
    Route::apiResource('client-logos', ClientLogosController::class);
    Route::apiResource('landing-settings', LandingSettingsController::class);

    // booking
    Route::apiResource('bookings', AdminBookingController::class);

    Route::post('/bookings/{id}/fasilitas', [
        AdminBookingController::class,
        'tambahFasilitas'
    ]);

    // pembayaran
    Route::apiResource('pembayaran', PembayaranAdminController::class);

    // fasilitas
    Route::apiResource('kategori-fasilitas', KategoriFasilitasController::class);
    Route::apiResource('fasilitas', FasilitasController::class);

    // inventaris
    Route::apiResource('kategori-inventaris', KategoriInventarisController::class);
    Route::apiResource('subkategori-inventaris', SubkategoriInventarisController::class);
    Route::apiResource('lokasi-penyimpanan', LokasiPenyimpananController::class);
    Route::apiResource('jenis-inventaris', JenisInventarisController::class);
    Route::apiResource('inventaris-unit', InventarisPerUnitController::class);

    // pengeluaran
    Route::apiResource('kategori-pengeluaran', KategoriPengeluaranController::class);
    Route::apiResource('pengeluaran-operasional', PengeluaranOperasionalController::class);
});
