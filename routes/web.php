<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\API\KategoriPaketController;
use App\Http\Controllers\API\PaketWisataController;
use App\Http\Controllers\ProfilWisataController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\API\Inventaris\KategoriInventarisController;
use App\Http\Controllers\API\Inventaris\SubKategoriInventarisController;
use App\Http\Controllers\API\Inventaris\JenisInventarisController;
use App\Http\Controllers\API\Inventaris\LokasiPenyimpananController;
use App\Http\Controllers\API\Inventaris\InventarisPerUnitController;

// ADMIN
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

// (Bagian login tetap sama)

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


// Pengunjung
Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [ProfilWisataController::class, 'index'])->name('home');

// FITUR CERITA SERU (Dynamic)
Route::get('/kabar', [ProfilWisataController::class, 'kabarIndex'])->name('kabar.index');
Route::get('/kabar/{slug}', [ProfilWisataController::class, 'showKabar'])->name('kabar.detail');

// TESTIMONI
Route::get('/testimoni', function () {
    return view('testimoni.detail-review');
})->name('testimoni.index');

Route::get('/buat-review', function () {
    return view('testimoni.review');
})->name('testimoni.create');

Route::get('/panduan-booking', function () {
    return view('panduan-booking');
})->name('panduan.booking');

// HALAMAN PAKET
// camping
Route::get('/camping', [ProfilWisataController::class, 'camping'])->name('camping');

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

// adventure game
Route::get('/adventure-game', [ProfilWisataController::class, 'adventureGame'])->name('adventure-game');

Route::get('/booking-adventure-game', [ProfilWisataController::class, 'bookingAdventureGame'])->name('booking-adventure-game');

Route::get('/detail-booking-adventure-game', function () {
    return view('detail-booking-adventure-game');
})->name('detail-booking-adventure-game');

Route::get('/pembayaran-adventure-game', function () {
    return view('pembayaran-adventure-game');
})->name('pembayaran.adventure');

Route::get('/status-booking-adventure-game', function () {
    return view('status-booking-adventure-game');
})->name('status.booking.adventure');


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
})->name('status.booking.paintball');

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

Route::get('/booking-jeeptour', function () {
    return view('booking-jeeptour');
})->name('booking.jeeptour');

Route::get('/detail-booking-jeeptour', function () {
    return view('detail-booking-jeeptour');
})->name('detail.booking.jeeptour');

Route::get('/pembayaran-jeeptour', function () {
    return view('pembayaran-jeeptour');
})->name('pembayaran.jeeptour');

Route::get('/status-booking-jeeptour', function () {
    return view('status-booking-jeeptour');
})->name('status.booking.jeeptour');
