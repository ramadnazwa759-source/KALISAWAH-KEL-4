<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', function () {
    return redirect('/admin/login');
});

Route::prefix('admin')->group(function () {

Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/login', function () {
    return view('admin.auth.login');
})->name('login');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

Route::get('/dashboard', function () {
    return "Dashboard Admin";
});

});
