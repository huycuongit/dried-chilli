<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CouponController;
use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\Api\OrderController;

Route::get('users', [UserController::class, 'index']);
Route::get('users/{id}', [UserController::class, 'show']);

Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index']);
    Route::post('/add', [CartController::class, 'add']);
    Route::post('/add-bundle', [CartController::class, 'addBundle']);
    Route::put('/update', [CartController::class, 'update']);
    Route::delete('/remove', [CartController::class, 'remove']);
});

Route::prefix('coupon')->group(function () {
    Route::post('/apply', [CouponController::class, 'apply']);
    Route::post('/remove', [CouponController::class, 'remove']);
    Route::post('/claim-voucher', [CouponController::class, 'claimVoucher'])->name('api.coupon.claim-voucher');
});

Route::post('checkout', [CheckoutController::class, 'process']);
Route::get('checkout/paypal/success', [CheckoutController::class, 'paypalSuccess'])->middleware('web')->name('api.checkout.paypal.success');
Route::get('checkout/paypal/cancel', [CheckoutController::class, 'paypalCancel'])->middleware('web')->name('api.checkout.paypal.cancel');

Route::get('orders', [OrderController::class, 'index']);
Route::put('orders/{id}/status', [OrderController::class, 'updateStatus']);
