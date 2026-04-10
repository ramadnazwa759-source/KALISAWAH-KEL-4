<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfilWisataController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [App\Http\Controllers\ProfilWisataController::class, 'index'])->name('home');
    return view('home');



