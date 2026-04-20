<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

// Halaman awal
Route::get('/', function () {
    return view('welcome');
});

// redirect ke login admin
Route::get('/admin', function () {
    return redirect('/admin/login');
});

Route::prefix('admin')->group(function () {

    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');
    Route::post('/logout', [AuthController::class, 'logout']);

});
