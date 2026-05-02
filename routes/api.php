<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BookingController;
use App\Http\Controllers\API\BookingFasilitasController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/test', function () {
    return "API WORKING";
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| Protected Routes (Login Required)
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    // logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // get user login
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    /*
    |--------------------------------------------------------------------------
    | Admin Booking Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')->group(function () {

        // CRUD booking
        Route::get('/bookings', [BookingController::class, 'index']);
        Route::get('/bookings/{id}', [BookingController::class, 'show']);
        Route::post('/bookings', [BookingController::class, 'store']);
        Route::put('/bookings/{id}', [BookingController::class, 'update']);
        Route::delete('/bookings/{id}', [BookingController::class, 'destroy']);

    });

});