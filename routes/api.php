<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/test', function () {
    return "API WORKING";
});

// route metrics (tugas sistem terdistribusi)
Route::get('/metrics', function () {
    $memory = memory_get_usage();

    $metrics = "
# HELP app_status Application status
# TYPE app_status gauge
app_status 1

# HELP memory_usage Memory usage in bytes
# TYPE memory_usage gauge
memory_usage $memory
";

    return response($metrics, 200)
        ->header('Content-Type', 'text/plain');
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

});