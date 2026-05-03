<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfilWisataController;
use App\Http\Controllers\BookingController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [ProfilWisataController::class, 'index'])->name('home');

// HALAMAN PAKET
// camping
Route::get('/camping', function () {
    return view('camping');
})->name('camping');

// halaman form booking
Route::get('/booking', [BookingController::class, 'create'])->name('booking.create');
Route::post('/booking', function() { return redirect()->route('booking.create'); });

// halaman detail pemesanan (ringkasan)
Route::get('/booking/detail', function() {
    return view('booking-detail');
})->name('booking.detail');

// proses simpan data final ke database
Route::post('/booking/confirm', [BookingController::class, 'store'])->name('booking.store');

 // rafting
Route::get('/rafting', function () {
    return view('rafting');
});

// outbound
Route::get('/outbound', function () {
    return view('outbound');
});

// paintball
Route::get('/paintball', function () {
    return view('paintball');
});

// halaman pembayaran
Route::get('/pembayaran', function () {
    return view('pembayaran');
})->name('pembayaran');

Route::get('/status-booking', function () {
    return view('status-booking');
})->name('status.booking');

Route::get('/search-results', function () {
    return view('search-results');
})->name('search.results');