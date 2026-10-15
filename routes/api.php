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


use App\Http\Controllers\Api\CouponController;
Route::prefix('coupon')->group(function () {
    Route::post('/apply', [CouponController::class, 'apply']);
    Route::post('/remove', [CouponController::class, 'remove']);
});
use App\Http\Controllers\Api\CheckoutController;
Route::post('checkout', [CheckoutController::class, 'process']);
Route::get('checkout/paypal/success', [CheckoutController::class, 'paypalSuccess'])->name('api.checkout.paypal.success');
Route::get('checkout/paypal/cancel', [CheckoutController::class, 'paypalCancel'])->name('api.checkout.paypal.cancel');

use App\Http\Controllers\Api\OrderController;
Route::get('orders', [OrderController::class, 'index']);
Route::put('orders/{id}/status', [OrderController::class, 'updateStatus']);
