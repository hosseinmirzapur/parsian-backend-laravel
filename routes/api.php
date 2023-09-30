<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\UserController;
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
Route::get('/order/special/{special}', [OrderController::class, 'special'])->middleware('auth:sanctum');

// Order Item
Route::resource('/order-item', OrderItemController::class)->except('index')->middleware('auth:sanctum');

// User
Route::prefix('/user')->group(function () {
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/register', [UserController::class, 'register']);
    Route::get('/', [UserController::class, 'info'])->middleware('auth:sanctum');
    Route::get('/orders', [UserController::class, 'orders'])->middleware('auth:sanctum');
    Route::put('/edit-name', [UserController::class, 'editName'])->middleware('auth:sanctum');;
});

// Admin
Route::prefix('/admin')->group(function () {
    Route::post('/login', [AdminController::class, 'login']);
    Route::post('/change-status/{id}', [AdminController::class, 'changeUserStatus'])->middleware('auth:sanctum');
});
