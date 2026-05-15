<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\API\JenisInventarisController;
use App\Http\Controllers\API\KategoriPaketController;
use App\Http\Controllers\API\PaketWisataController;

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

    // Inventaris
    Route::resource('jenisInventaris', JenisInventarisController::class);

    // Kategori Paket
    Route::resource('kategori-paket', KategoriPaketController::class);

    // Paket Wisata
    Route::resource('paket-wisata', PaketWisataController::class);

});
