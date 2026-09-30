<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

Route::get('users', [UserController::class, 'index']);
Route::get('users/{id}', [UserController::class, 'show']);

use App\Http\Controllers\Api\CartController;
Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index']);
    Route::post('/add', [CartController::class, 'add']);
    Route::put('/update', [CartController::class, 'update']);
    Route::delete('/remove', [CartController::class, 'remove']);
});

use App\Http\Controllers\Api\CheckoutController;
Route::post('checkout', [CheckoutController::class, 'process']);

use App\Http\Controllers\Api\OrderController;
Route::get('orders', [OrderController::class, 'index']);
Route::put('orders/{id}/status', [OrderController::class, 'updateStatus']);
