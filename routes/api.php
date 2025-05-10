<?php

use App\Http\Controllers\api\v1\SellerController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// This is the API route file for the application.
Route::prefix('v1')->group(function () {
    Route::post('/seller', [SellerController::class, 'store'])->middleware('auth:sanctum');
    Route::get('/seller', [SellerController::class, 'index'])->middleware('auth:sanctum');
    Route::get('/seller/{id}', [SellerController::class, 'show'])->middleware('auth:sanctum');
});

// Auth routes.
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
