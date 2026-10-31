<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CouponController;
use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\Api\OrderController;

Route::middleware('web')->group(function () {
Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index']);
    Route::post('/add', [CartController::class, 'add']);
    Route::put('/update', [CartController::class, 'update']);
    Route::delete('/remove', [CartController::class, 'remove']);
});

Route::prefix('coupon')->group(function () {
    Route::post('/apply', [CouponController::class, 'apply']);
    Route::post('/remove', [CouponController::class, 'remove']);
    Route::post('/claim-voucher', [CouponController::class, 'claimVoucher'])->name('api.coupon.claim-voucher');
});

Route::post('checkout', [CheckoutController::class, 'process']);
Route::post('checkout/session', [CheckoutController::class, 'startSession']);
// Online payments (same flow as jojo-be): the order is created only after payment is confirmed.
Route::prefix('checkout')->where(['payment' => '[0-9a-f-]{36}'])->group(function () {
    Route::post('stripe', [CheckoutController::class, 'createStripe'])->name('api.checkout.stripe');
    Route::post('paypal', [CheckoutController::class, 'createPayPal'])->name('api.checkout.paypal');
    Route::post('paypal/{payment}/capture', [CheckoutController::class, 'capturePayPal'])->name('api.checkout.paypal.capture');
    Route::get('payments/{payment}', [CheckoutController::class, 'paymentStatus'])->name('api.checkout.payment');
});
});
Route::post('payments/stripe/webhook', [CheckoutController::class, 'stripeWebhook'])->name('api.payments.stripe.webhook');

Route::get('orders', [OrderController::class, 'index'])->middleware('web');
