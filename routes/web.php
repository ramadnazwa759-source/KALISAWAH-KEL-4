<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\DashboardController;


// Login (bebas diakses)
Route::get('/admin/login', function () {
    return view('auth.login');
})->name('login');


// Group yang WAJIB login
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');


});

