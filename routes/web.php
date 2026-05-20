<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\API\KategoriPaketController;
use App\Http\Controllers\API\PaketWisataController;
use App\Http\Controllers\API\Inventaris\KategoriInventarisController;
use App\Http\Controllers\API\Inventaris\SubKategoriInventarisController;
use App\Http\Controllers\API\Inventaris\JenisInventarisController;
use App\Http\Controllers\API\Inventaris\LokasiPenyimpananController;
use App\Http\Controllers\API\Inventaris\InventarisPerUnitController;

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

    // Inventaris
    Route::resource('kategori-inventaris', KategoriInventarisController::class);
    Route::resource('subkategori-inventaris', SubKategoriInventarisController::class);
    Route::resource('jenis-inventaris', JenisInventarisController::class);
    Route::resource('lokasi-penyimpanan', LokasiPenyimpananController::class);
    Route::resource('inventaris-perunit', InventarisPerUnitController::class);

});
