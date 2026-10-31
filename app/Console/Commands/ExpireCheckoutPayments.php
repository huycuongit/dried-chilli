<?php

namespace App\Console\Commands;

use App\Models\PaymentAttempt;
use Illuminate\Console\Command;

class ExpireCheckoutPayments extends Command
{
    protected $signature = 'payments:expire-checkouts';
    protected $description = 'Mark unpaid checkout attempts as expired without changing inventory';

    public function handle()
    {
        PaymentAttempt::where('status', PaymentAttempt::PENDING)->whereNotNull('expires_at')
            ->where('expires_at', '<=', now())->update(['status' => PaymentAttempt::EXPIRED]);
        return 0;
    }
}
