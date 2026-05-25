<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\DashboardController;
// Kelola Landing Page - Paket
use App\Http\Controllers\API\Kelola_landingpage\paket\KategoriPaketController;
use App\Http\Controllers\API\Kelola_landingpage\paket\PaketwisataController;
use App\Http\Controllers\API\Kelola_landingpage\paket\PaketFasilitasController;

// Inventaris
use App\Http\Controllers\API\Inventaris\KategoriInventarisController;
use App\Http\Controllers\API\Inventaris\SubKategoriInventarisController;
use App\Http\Controllers\API\Inventaris\JenisInventarisController;
use App\Http\Controllers\API\Inventaris\LokasiPenyimpananController;
use App\Http\Controllers\API\Inventaris\InventarisPerUnitController;

// Kelola fasilitas
use App\Http\Controllers\API\Kelola_fasilitas\KategoriFasilitasController;
use App\Http\Controllers\API\Kelola_fasilitas\FasilitasController;

// Kelola Booking
use App\Http\Controllers\API\Kelola_booking\AdminBookingController;
use App\Http\Controllers\API\Pembayaran\PembayaranAdminController;



Route::get('/admin/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/admin/login', function (Request $request) {

    if (Auth::attempt($request->only('email', 'password'))) {
        $request->session()->regenerate();
        return redirect('/admin/dashboard');
    }

    return back()->with('error', 'Email atau password salah');
});

// ... (Bagian login tetap sama)

Route::prefix('admin')->middleware('auth')->as('admin.')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard'); // Menjadi admin.dashboard

    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    })->name('logout'); // Menjadi admin.logout

    // Kategori Paket
    Route::resource('kategori-paket', KategoriPaketController::class);

    // Paket Wisata
    Route::resource('paket-wisata', PaketWisataController::class);
    Route::resource('paket-fasilitas', PaketFasilitasController::class);

    // Inventaris
    Route::resource('kategori-inventaris', KategoriInventarisController::class);
    Route::resource('subkategori-inventaris', SubKategoriInventarisController::class);
    Route::resource('jenis-inventaris', JenisInventarisController::class);
    Route::resource('lokasi-penyimpanan', LokasiPenyimpananController::class);
    Route::resource('inventaris-perunit', InventarisPerUnitController::class);

    // Kelola fasilitas
    Route::resource('kategori-fasilitas', KategoriFasilitasController::class);
    Route::resource('fasilitas', FasilitasController::class);

    // Kelola Booking
    // 1. Amankan rute URL 'admin/booking-admin/create' agar masuk ke method store()
    Route::get('fasilitas-booking',[FasilitasController::class, 'fasilitasBooking']);
    Route::get('/booking-admin/create', function () {return view('admin.kelola_booking.create');})->name('admin.booking-admin.create');
    Route::resource('booking-admin', AdminBookingController::class);

    // Pembayaran
    Route::resource('pembayaran', PembayaranAdminController::class);

});
