<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\API\Admin\DashboardController;
use App\Http\Controllers\API\Kelola_landingpage\ProfilWisataController;

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

// Kelola Booking Admin & Pengunjung
use App\Http\Controllers\API\Kelola_booking\AdminBookingController;
use App\Http\Controllers\API\Pembayaran\PembayaranAdminController;
use App\Http\Controllers\API\Booking_pengunjung\PengunjungBookingController;

/*
|--------------------------------------------------------------------------
| 1. SEKTOR ADMIN
|--------------------------------------------------------------------------
*/

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

Route::prefix('admin')->middleware('auth')->as('admin.')->group(function () {
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
    Route::get('/booking-admin/create', function () { return view('admin.kelola_booking.create'); })->name('booking-admin.create');
    Route::resource('booking-admin', AdminBookingController::class);
    Route::resource('pembayaran', PembayaranAdminController::class);
});


/*
|--------------------------------------------------------------------------
| 2. SEKTOR PENGUNJUNG (LANDING PAGE & RESERVASI)
|--------------------------------------------------------------------------
*/

// Umum & Landing Page utama
Route::get('/', function () { return view('welcome'); });
Route::get('/home', [ProfilWisataController::class, 'index'])->name('landing-page.home');
Route::get('/kategori-detail/{id}', [ProfilWisataController::class, 'detailKategori'])->name('kategori.detail');

// Panduan & Pencarian
Route::get('/panduan-booking', function () { return view('pengunjung.landing-page.panduan.index'); })->name('panduan.booking');
Route::get('/search-results', function () { return view('pengunjung.landing-page.pencarian.index'); })->name('search.results');

// Fitur Informasi Wisata
Route::get('/kabar', [ProfilWisataController::class, 'kabarIndex'])->name('kabar.index');
Route::get('/kabar/{slug}', [ProfilWisataController::class, 'showKabar'])->name('kabar.detail');
Route::get('/testimoni', function () { return view('pengunjung.landing-page.testimoni.index'); })->name('testimoni.index');
Route::get('/buat-review', function () { return view('pengunjung.landing-page.testimoni.create'); })->name('testimoni.create');

// SISTEM BOOKING TERPUSAT
Route::get('/booking', [PengunjungBookingController::class, 'showForm'])->name('pengunjung.booking.booking-form');
Route::post('/booking/store', [PengunjungBookingController::class, 'store'])->name('pengunjung.booking.booking-store');

// Booking Edit & Update
Route::get('/booking/{id}/edit', [PengunjungBookingController::class, 'edit'])->name('pengunjung.booking.edit');
Route::put('/booking/{id}/update', [PengunjungBookingController::class, 'update'])->name('pengunjung.booking.update');
// Form POST ke review (Preview)
Route::post('/booking/review', [PengunjungBookingController::class, 'review'])->name('pengunjung.booking.review');

// Halaman Detail (Submit ke confirm)
Route::post('/booking/confirm', [PengunjungBookingController::class, 'confirmStore'])->name('pengunjung.booking.confirm');

// Detail & Pembayaran
Route::get('/booking/{id}/detail', [PengunjungBookingController::class, 'showDetail'])->name('pengunjung.booking.booking-detail');
Route::get('/booking/{id}/payment', [PengunjungBookingController::class, 'showPayment'])->name('pengunjung.booking.booking-payment');
Route::post('/booking/{id}/update-payment', [PengunjungBookingController::class, 'updatePaymentMethod'])->name('pengunjung.booking.update-payment');
Route::get('/booking/{id}/success', [PengunjungBookingController::class, 'showSuccess'])->name('pengunjung.booking.booking-success');
Route::post('/booking/{id}/upload-bukti', [PengunjungBookingController::class, 'uploadBukti'])->name('pengunjung.booking.upload-bukti');

// API INTERNAL (AJAX)
Route::get('/get-paket-by-kategori/{id}', [PengunjungBookingController::class, 'getPaketByKategori']);
Route::get('/get-fasilitas-by-kategori/{id}', [PengunjungBookingController::class, 'getFasilitasByKategori']);

// Halaman Paket Statis
Route::get('/camping', [ProfilWisataController::class, 'camping'])->name('camping');
Route::get('/rafting', function () { return view('pengunjung.landing-page.halaman-paket.rafting'); })->name('rafting');
Route::get('/outbound', function () { return view('pengunjung.landing-page.halaman-paket.outbound'); })->name('outbound');
Route::get('/adventure-game', [ProfilWisataController::class, 'adventureGame'])->name('adventure-game');
Route::get('/paintball', function () { return view('pengunjung.landing-page.halaman-paket.paintball'); })->name('paintball');
Route::get('/gathering', function () { return view('pengunjung.landing-page.halaman-paket.gathering'); })->name('gathering');
Route::get('/jeeptour', function () { return view('pengunjung.landing-page.halaman-paket.jeeptour'); })->name('jeeptour');