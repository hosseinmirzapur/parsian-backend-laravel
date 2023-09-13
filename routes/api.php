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
Route::resource('/order', OrderController::class);

// Order Item
Route::resource('/order-item', OrderItemController::class)->except('index');

Route::get('/test', function () {
    return successResponse([
        'message' => 'hello'
    ]);
});
