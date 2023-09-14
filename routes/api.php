<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
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

// Order
Route::resource('/order', OrderController::class)->middleware('auth:sanctum');

// Order Item
Route::resource('/order-item', OrderItemController::class)->except('index')->middleware('auth:sanctum');

// User
Route::prefix('/user')->group(function () {
    // User Profile
    Route::prefix('/profile')->group(function () {
        Route::post('/alter');
    })->middleware('auth:sanctum');

    // Other User Routes
    Route::post('/login');
    Route::post('/register');
    Route::get('/')->middleware('auth:sanctum');

});

// Admin
Route::prefix('/admin')->group(function () {
    Route::post('/login');
});

Route::get('/test', function () {
    return successResponse([
        'message' => 'hello'
    ]);
});
