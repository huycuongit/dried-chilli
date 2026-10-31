<?php

namespace App\Support\Payments;

use App\Models\PaymentAttempt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use Throwable;

class RefundService
{
    public function __construct(private StripeGateway $stripe, private PayPalGateway $paypal) {}

    public function retry(string $attemptId): void
    {
        $attempt = PaymentAttempt::find($attemptId);
        if (!$attempt || $attempt->status !== PaymentAttempt::REFUND_PENDING) return;
        try {
            if ($attempt->provider === PaymentAttempt::STRIPE) {
                $refund = $attempt->provider_refund_id
                    ? $this->stripe->retrieveRefund($attempt->provider_refund_id)
                    : $this->stripe->refundIntent($attempt->provider_payment_id, $attempt->id);
                $completed = ($refund['status'] ?? '') === 'succeeded';
            } else {
                if (!$attempt->provider_capture_id) throw new \RuntimeException('PayPal capture ID is missing.');
                $refund = $attempt->provider_refund_id
                    ? $this->paypal->retrieveRefund($attempt->provider_refund_id)
                    : $this->paypal->refundCapture($attempt->provider_capture_id, $attempt->id);
                $completed = ($refund['status'] ?? '') === 'COMPLETED';
            }
            if (empty($refund['id'])) throw new \RuntimeException('Refund response is missing its ID.');
            $refundStatus = strtoupper((string) ($refund['status'] ?? 'UNKNOWN'));
            $refundFailed = in_array($refundStatus, ['FAILED', 'CANCELED', 'CANCELLED'], true);
            if ($refundFailed) Log::error('Provider reported an unsuccessful refund; manual investigation required', ['attempt_id' => $attemptId, 'refund_id' => $refund['id'], 'status' => $refundStatus]);
            DB::transaction(function () use ($attempt, $attemptId, $refund, $completed, $refundFailed) {
                $updated = PaymentAttempt::whereKey($attemptId)->where('status', PaymentAttempt::REFUND_PENDING)->update([
                    'provider_refund_id' => $refund['id'],
                    'refund_status' => $refund['status'] ?? 'UNKNOWN',
                    'refund_requested_at' => $attempt->refund_requested_at ?? now(),
                    'refund_last_error' => $refundFailed ? 'The provider reported an unsuccessful refund; manual investigation required.' : null,
                    'status' => $completed ? PaymentAttempt::REFUNDED : PaymentAttempt::REFUND_PENDING,
                ]);
                if ($updated && $completed && $attempt->order_id) Order::whereKey($attempt->order_id)->update(['payment_status' => 'refunded']);
            });
        } catch (Throwable $exception) {
            Log::error('Payment refund requires retry', ['attempt_id' => $attemptId, 'exception' => $exception]);
            PaymentAttempt::whereKey($attemptId)->where('status', PaymentAttempt::REFUND_PENDING)
                ->update(['refund_last_error' => 'Refund request failed; retry required.']);
        }
    }
}
