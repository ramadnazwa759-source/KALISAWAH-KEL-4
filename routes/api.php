<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/test', function () {
    return "API WORKING";
});

// route metrics
Route::get('/metrics', function () {

    $status = app()->isDownForMaintenance() ? "maintenance" : "running";

    return response()->json([
        "app_name" => "kalisawah",
        "status" => $status,
        "timestamp" => now(),
        "memory_usage" => memory_get_usage()
    ]);

});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

});