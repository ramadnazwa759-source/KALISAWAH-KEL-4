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
})->name('rafting');

Route::get('/rafting/long-trip', function () {
    return redirect()->route('booking.rafting', ['paket' => 'long-trip']);
})->name('rafting.long-trip');

Route::get('/rafting/adventure', function () {
    return redirect()->route('booking.rafting', ['paket' => 'adventure']);
})->name('rafting.adventure');

Route::get('/rafting/wonderful', function () {
    return redirect()->route('booking.rafting', ['paket' => 'wonderful']);
})->name('rafting.wonderful');

Route::get('/booking-rafting', function () {
    return view('booking-rafting');
})->name('booking.rafting');

Route::get('/booking-rafting/detail', function () {
    return view('booking-detail-rafting');
})->name('booking.rafting.detail');

// outbound
Route::get('/outbound', function () {
    return view('outbound');
})->name('outbound');

Route::get('/booking-outbound', function () {
    return view('booking-outbound');
})->name('booking.outbound');

Route::get('/detail-booking-outbound', function () {
    return view('detail-booking-outbound');
})->name('detail.booking.outbound');

Route::get('/pembayaran-outbound', function () {
    return view('pembayaran-outbound');
})->name('pembayaran.outbound');

Route::get('/status-booking-outbound', function () {
    return view('status-booking-outbound');
})->name('status.booking.outbound');

// paintball
Route::get('/paintball', function () {
    return view('paintball');
});

Route::get('/booking-paintball', function () {
    return view('booking-paintball');
});

Route::get('/detail-booking-paintball', function () {
    return view('detail-booking-paintball');
});

Route::get('/pembayaran-paintball', function () {
    return view('pembayaran-paintball');
});

Route::get('/status-booking-paintball', function () {
    return view('status-booking-paintball');
});

// halaman pembayaran
Route::get('/pembayaran/camping', function () {
    return view('pembayaran-camping');
})->name('pembayaran.camping');

Route::get('/pembayaran/rafting', function () {
    return view('pembayaran-rafting');
})->name('pembayaran.rafting');

Route::get('/status-booking', function () {
    return view('status-booking');
})->name('status.booking');

Route::get('/search-results', function () {
    return view('search-results');
})->name('search.results');

// gathering
Route::get('/gathering', function () {
    return view('gathering');
})->name('gathering');

Route::get('/gathering/1day', function () {
    return view('gathering-1day');
});

Route::get('/gathering/2d1n', function () {
    return view('gathering-2d1n');
});

Route::get('/booking-gathering', function () {
    return view('booking-gathering');
});

Route::get('/detail-booking-gathering', function () {
    return view('detail-booking-gathering');
})->name('detail-booking-gathering');

Route::get('/pembayaran-gathering', function () {
    return view('pembayaran-gathering');
})->name('pembayaran-gathering');

Route::get('/status-booking-gathering', function () {
    return view('status-booking-gathering');
})->name('status-booking-gathering');

Route::get('/jeeptour', function () {
    return view('jeeptour');
})->name('jeeptour');