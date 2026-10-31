<?php

namespace App\Console\Commands;

use App\Models\PaymentAttempt;
use App\Support\Payments\CheckoutPaymentService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Throwable;

class ReconcilePayPalPayments extends Command
{
    protected $signature = 'payments:reconcile-paypal';
    protected $description = 'Reconcile PayPal captures that were not confirmed by the browser';

    public function handle(CheckoutPaymentService $payments)
    {
        PaymentAttempt::where('provider', PaymentAttempt::PAYPAL)
            ->whereIn('status', [PaymentAttempt::PENDING, PaymentAttempt::PROCESSING, PaymentAttempt::EXPIRED])
            ->whereNotNull('provider_payment_id')
            ->where(function ($query) { $query->whereNull('paypal_checked_at')->orWhere('paypal_checked_at', '<=', now()->subMinutes(5)); })
            ->orderBy('paypal_checked_at')->limit(50)->get()
            ->each(function ($attempt) use ($payments) {
                try { $payments->reconcilePayPal($attempt); }
                catch (Throwable $exception) { Log::error('PayPal payment reconciliation failed', ['attempt_id' => $attempt->id, 'exception' => $exception]); }
            });
        return 0;
    }
}
