<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaketWisataController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\KategoriPaketController;

// Halaman awal
Route::get('/', function () {
    return view('welcome');
});

// Home
Route::get('/home', [HomeController::class, 'index'])->name('home');

// CRUD (BACKEND 2)

// LIST semua paket
Route::get('paket', [PaketWisataController::class, 'index'])->name('paket.index');

// FORM tambah paket
Route::get('paket/create', [PaketWisataController::class, 'create'])->name('paket.create');

// SIMPAN data baru
Route::post('paket', [PaketWisataController::class, 'store'])->name('paket.store');

// FORM edit paket
Route::get('paket/{id}/edit', [PaketWisataController::class, 'edit'])->name('paket.edit');

// UPDATE data paket
Route::put('paket/{id}', [PaketWisataController::class, 'update'])->name('paket.update');

// DELETE paket
Route::delete('paket/{id}', [PaketWisataController::class, 'destroy'])->name('paket.destroy');

//kategori paket
Route::get('kategori/create', [KategoriPaketController::class, 'create'])->name('kategori.create');
Route::post('kategori', [KategoriPaketController::class, 'store'])->name('kategori.store');
Route::get('kategori', [KategoriPaketController::class, 'index'])->name('kategori.index');

// Fasilitas
Route::get('fasilitas', [FasilitasController::class, 'index'])->name('fasilitas.index');
Route::get('fasilitas/create', [FasilitasController::class, 'create'])->name('fasilitas.create');
Route::post('fasilitas', [FasilitasController::class, 'store'])->name('fasilitas.store');
Route::get('fasilitas/{id}/edit', [FasilitasController::class, 'edit'])->name('fasilitas.edit');

// update (simpan perubahan)
Route::put('fasilitas/{id}', [FasilitasController::class, 'update'])->name('fasilitas.update');

// delete (hapus)
Route::delete('fasilitas/{id}', [FasilitasController::class, 'destroy'])->name('fasilitas.destroy');


Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


