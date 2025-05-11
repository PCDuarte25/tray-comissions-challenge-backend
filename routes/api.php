<?php

use App\Http\Controllers\api\v1\SaleController;
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
Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::post('/seller', [SellerController::class, 'store']);
    Route::get('/seller', [SellerController::class, 'index']);
    Route::get('/seller/{id}', [SellerController::class, 'show']);
    Route::get('/seller/{id}/sale', [SellerController::class, 'getSalesBySellerId']);

    Route::post('/sale', [SaleController::class, 'store']);
    Route::get('/sale', [SaleController::class, 'index']);
    Route::get('/sale/{id}', [SaleController::class, 'show']);
});

// Auth routes.
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
