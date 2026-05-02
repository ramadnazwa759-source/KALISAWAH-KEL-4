<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\PaketWisataController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\KategoriPaketController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AuthController;

// route metrics (tugas sistem terdistribusi)
Route::get('/metrics', function () {
    return response("
# HELP app_status Application status
# TYPE app_status gauge
app_status 1

# HELP memory_usage Memory usage in bytes
# TYPE memory_usage gauge
memory_usage " . memory_get_usage()
    , 200)
    ->header('Content-Type', 'text/plain; version=0.0.4');
});