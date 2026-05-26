<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\ProfilWisataController;

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

// Area Dashboard & Resource Admin
Route::prefix('admin')->middleware('auth')->as('admin.')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    })->name('logout');

    // Resource Management
    Route::resource('kategori-paket', KategoriPaketController::class);
    Route::resource('paket-wisata', PaketWisataController::class);
    Route::resource('paket-fasilitas', PaketFasilitasController::class);
    Route::resource('kategori-inventaris', KategoriInventarisController::class);
    Route::resource('subkategori-inventaris', SubKategoriInventarisController::class);
    Route::resource('jenis-inventaris', JenisInventarisController::class);
    Route::resource('lokasi-penyimpanan', LokasiPenyimpananController::class);
    Route::resource('inventaris-perunit', InventarisPerUnitController::class);
    Route::resource('kategori-fasilitas', KategoriFasilitasController::class);
    Route::resource('fasilitas', FasilitasController::class);

    // Kelola Booking Sisi Admin
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

// Umun & Landing Page utama
Route::get('/', function () { return view('welcome'); });
Route::get('/home', [ProfilWisataController::class, 'index'])->name('home');
Route::get('/panduan-booking', function () { return view('panduan-booking'); })->name('panduan.booking');
Route::get('/search-results', function () { return view('search-results'); })->name('search.results');

// Fitur Cerita Seru (Kabar Wisata)
Route::get('/kabar', [ProfilWisataController::class, 'kabarIndex'])->name('kabar.index');
Route::get('/kabar/{slug}', [ProfilWisataController::class, 'showKabar'])->name('kabar.detail');

// Testimoni / Ulasan Wisatawan
Route::get('/testimoni', function () { return view('testimoni.detail-review'); })->name('testimoni.index');
Route::get('/buat-review', function () { return view('testimoni.review'); })->name('testimoni.create');

// --- SUB-FITUR: CAMPING (YANG REVISI TOTAL) ---
Route::get('/camping', [ProfilWisataController::class, 'camping'])->name('camping');

Route::prefix('booking/camping')->name('booking.camping.')->group(function () {
    // Menampilkan Form Booking (GET)
    Route::get('/', [PengunjungBookingController::class, 'showForm'])->name('form');
    
    // Menyimpan Aksi POST data Form (Inilah route 'booking.camping.store' yang dicari)
    Route::post('/store', [PengunjungBookingController::class, 'store'])->name('store');
    
    // Alur ringkasan invoice, payment, dan halaman sukses bawaan database
    Route::get('/{booking}/detail', [PengunjungBookingController::class, 'showDetail'])->name('detail');
    Route::get('/{booking}/payment', [PengunjungBookingController::class, 'showPayment'])->name('payment');
    Route::get('/{booking}/success', [PengunjungBookingController::class, 'showSuccess'])->name('success');
});

// --- SUB-FITUR: RAFTING ---
Route::get('/rafting', function () { return view('rafting'); })->name('rafting');
Route::get('/booking-rafting', function () { return view('booking-rafting'); })->name('booking.rafting');
Route::get('/booking-rafting/detail', function () { return view('booking-detail-rafting'); })->name('booking.rafting.detail');
Route::get('/pembayaran/rafting', function () { return view('pembayaran-rafting'); })->name('pembayaran.rafting');

Route::get('/rafting/long-trip', function () { return redirect()->route('booking.rafting', ['paket' => 'long-trip']); })->name('rafting.long-trip');
Route::get('/rafting/adventure', function () { return redirect()->route('booking.rafting', ['paket' => 'adventure']); })->name('rafting.adventure');
Route::get('/rafting/wonderful', function () { return redirect()->route('booking.rafting', ['paket' => 'wonderful']); })->name('rafting.wonderful');

// --- SUB-FITUR: OUTBOUND ---
Route::get('/outbound', function () { return view('outbound'); })->name('outbound');
Route::get('/booking-outbound', function () { return view('booking-outbound'); })->name('booking.outbound');
Route::get('/detail-booking-outbound', function () { return view('detail-booking-outbound'); })->name('detail.booking.outbound');
Route::get('/pembayaran-outbound', function () { return view('pembayaran-outbound'); })->name('pembayaran.outbound');
Route::get('/status-booking-outbound', function () { return view('status-booking-outbound'); })->name('status.booking.outbound');

// --- SUB-FITUR: ADVENTURE GAME ---
Route::get('/adventure-game', [ProfilWisataController::class, 'adventureGame'])->name('adventure-game');
Route::get('/booking-adventure-game', [ProfilWisataController::class, 'bookingAdventureGame'])->name('booking-adventure-game');
Route::get('/detail-booking-adventure-game', function () { return view('detail-booking-adventure-game'); })->name('detail-booking-adventure-game');
Route::get('/pembayaran-adventure-game', function () { return view('pembayaran-adventure-game'); })->name('pembayaran.adventure');
Route::get('/status-booking-adventure-game', function () { return view('status-booking-adventure-game'); })->name('status.booking.adventure');

// --- SUB-FITUR: PAINTBALL ---
Route::get('/paintball', function () { return view('paintball'); })->name('paintball');
Route::get('/booking-paintball', function () { return view('booking-paintball'); })->name('booking.paintball');
Route::get('/detail-booking-paintball', function () { return view('detail-booking-paintball'); })->name('detail.booking.paintball');
Route::get('/pembayaran-paintball', function () { return view('pembayaran-paintball'); })->name('pembayaran.paintball');
Route::get('/status-booking-paintball', function () { return view('status-booking-paintball'); })->name('status.booking.paintball');

// --- SUB-FITUR: GATHERING ---
Route::get('/gathering', function () { return view('gathering'); })->name('gathering');
Route::get('/gathering/1day', function () { return view('gathering-1day'); })->name('gathering.1day');
Route::get('/gathering/2d1n', function () { return view('gathering-2d1n'); })->name('gathering.2d1n');
Route::get('/booking-gathering', function () { return view('booking-gathering'); })->name('booking.gathering');
Route::get('/detail-booking-gathering', function () { return view('detail-booking-gathering'); })->name('detail-booking-gathering');
Route::get('/pembayaran-gathering', function () { return view('pembayaran-gathering'); })->name('pembayaran-gathering');
Route::get('/status-booking-gathering', function () { return view('status-booking-gathering'); })->name('status-booking-gathering');

// --- SUB-FITUR: JEEP TOUR ---
Route::get('/jeeptour', function () { return view('jeeptour'); })->name('jeeptour');
Route::get('/booking-jeeptour', function () { return view('booking-jeeptour'); })->name('booking.jeeptour');
Route::get('/detail-booking-jeeptour', function () { return view('detail-booking-jeeptour'); })->name('detail.booking.jeeptour');
Route::get('/pembayaran-jeeptour', function () { return view('pembayaran-jeeptour'); })->name('pembayaran.jeeptour');
Route::get('/status-booking-jeeptour', function () { return view('status-booking-jeeptour'); })->name('status.booking.jeeptour');

Route::get('/test-camping', function () {
    // Membaca data dari model PaketWisata kamu
    $pakets = \App\Models\PaketWisata::where('status', 'aktif')->get(); 
    
    // Diubah dari 'camping' menjadi 'camping.camping' karena filenya ada di dalam folder camping
    return view('camping.camping', compact('pakets'));
});