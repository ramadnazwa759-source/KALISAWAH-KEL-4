<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// Controller Imports
use App\Http\Controllers\API\Admin\DashboardController;
use App\Http\Controllers\API\Kelola_landingpage\ProfilWisataController;
use App\Http\Controllers\API\Kelola_landingpage\paket\{KategoriPaketController, PaketwisataController, PaketFasilitasController};
use App\Http\Controllers\API\Inventaris\{KategoriInventarisController, SubKategoriInventarisController, JenisInventarisController, LokasiPenyimpananController, InventarisPerUnitController};
use App\Http\Controllers\API\Kelola_fasilitas\{KategoriFasilitasController, FasilitasController};
use App\Http\Controllers\API\Kelola_booking\AdminBookingController;
use App\Http\Controllers\API\Pembayaran\PembayaranAdminController;
use App\Http\Controllers\API\Booking_pengunjung\PengunjungBookingController;
use App\Http\Controllers\API\Booking_pengunjung\TrackingBookingController;

/* 1. SEKTOR ADMIN */
Route::get('/admin/login', function () { return view('auth.login'); })->name('login');

Route::post('/admin/login', function (Request $request) {
    if (Auth::attempt($request->only('email', 'password'))) {
        $request->session()->regenerate();
        return redirect('/admin/dashboard');
    }
    return back()->with('error', 'Email atau password salah');
});

Route::prefix('admin')->middleware(['auth', 'admin'])->as('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    })->name('logout');

    Route::resource('kategori-paket', KategoriPaketController::class);
    Route::resource('paket-wisata', PaketwisataController::class);
    Route::resource('paket-fasilitas', PaketFasilitasController::class);
    Route::resource('kategori-inventaris', KategoriInventarisController::class);
    Route::resource('subkategori-inventaris', SubKategoriInventarisController::class);
    Route::resource('jenis-inventaris', JenisInventarisController::class);
    Route::resource('lokasi-penyimpanan', LokasiPenyimpananController::class);
    Route::resource('inventaris-perunit', InventarisPerUnitController::class);
    Route::resource('kategori-fasilitas', KategoriFasilitasController::class);
    Route::resource('fasilitas', FasilitasController::class);

    Route::get('fasilitas-booking', [FasilitasController::class, 'fasilitasBooking']);
    Route::resource('booking-admin', AdminBookingController::class);
    Route::resource('pembayaran', PembayaranAdminController::class);
});

/* 2. SEKTOR PENGUNJUNG */
Route::get('/', function () { return view('welcome'); });
Route::get('/home', [ProfilWisataController::class, 'index'])->name('landing-page.home');

// SISTEM BOOKING PENGUNJUNG
Route::prefix('booking')->as('pengunjung.booking.')->group(function () {
    Route::get('/', [PengunjungBookingController::class, 'showForm'])->name('booking-form');
    
    // Alur Booking: Form -> Review -> Confirm
    Route::post('/review', [PengunjungBookingController::class, 'review'])->name('review');
    Route::get('/review', [PengunjungBookingController::class, 'showReview'])->name('review.show');
    Route::post('/confirm', [PengunjungBookingController::class, 'confirmStore'])->name('confirm');
    
    // Detail & Payment
    Route::get('/{id}/detail', [PengunjungBookingController::class, 'showDetail'])->name('booking-detail');
    Route::get('/{id}/payment', [PengunjungBookingController::class, 'showPayment'])->name('booking-payment');
    Route::post('/{id}/update-payment', [PengunjungBookingController::class, 'updatePaymentMethod'])->name('update-payment');
    Route::get('/{id}/success', [PengunjungBookingController::class, 'showSuccess'])->name('booking-success');
    Route::post('/{id}/upload-bukti', [PengunjungBookingController::class, 'uploadBukti'])->name('upload-bukti');
    
    // Edit & Update
    Route::get('/{id}/edit', [PengunjungBookingController::class, 'edit'])->name('edit');
    Route::put('/{id}/update', [PengunjungBookingController::class, 'update'])->name('update');
});

// API AJAX
Route::get('/get-paket-by-kategori/{id}', [PengunjungBookingController::class, 'getPaketByKategori']);
Route::get('/get-fasilitas-by-kategori/{id}', [PengunjungBookingController::class, 'getFasilitasByKategori']);

// Halaman Statis

Route::get('/panduan-booking', function () {
    return view('pengunjung.landing-page.panduan.panduan-booking');
})->name('panduan.booking');
Route::get('/kabar', function () {
    return view('pengunjung.landing-page.kabar.kabar');
})->name('kabar.index');
Route::get('/testimoni', function () {
    return view('pengunjung.landing-page.testimoni.review');
})->name('testimoni.create');

// DETAIL KATEGORI PAKET
Route::get('/kategori/{slug}', [ProfilWisataController::class, 'showKategori'])
    ->name('kategori.detail');

// TRACKING BOOKING
Route::get('/cari-booking', function () {
    return view('pengunjung.landing-page.pencarian.search-results');
})->name('cari.booking');

Route::post(
    '/cari-booking',
    [TrackingBookingController::class, 'tracking']
)->name('cari.booking.proses');

Route::post(
    '/booking/{id}/upload-bukti',
    [TrackingBookingController::class, 'uploadBukti']
)->name('booking.upload-bukti');
