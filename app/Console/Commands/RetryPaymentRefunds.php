<?php

namespace App\Console\Commands;

use App\Models\PaymentAttempt;
use App\Support\Payments\RefundService;
use Illuminate\Console\Command;

class RetryPaymentRefunds extends Command
{
    protected $signature = 'payments:retry-refunds';
    protected $description = 'Retry and reconcile outstanding refunds';

    public function handle(RefundService $refunds)
    {
        PaymentAttempt::where('status', PaymentAttempt::REFUND_PENDING)->orderBy('created_at')->each(function ($attempt) use ($refunds) {
            $refunds->retry($attempt->id);
        });
        return 0;
    }
}
