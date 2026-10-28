<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class PaymentAttempt extends Model
{
    public const STRIPE = 'stripe';
    public const PAYPAL = 'paypal';

    public const PENDING = 'PENDING';
    public const PROCESSING = 'PROCESSING';
    public const PAID = 'PAID';
    public const FAILED = 'FAILED';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'cart_id', 'user_id', 'idempotency_key', 'provider', 'provider_payment_id', 'status',
        'currency', 'total_amount', 'amount_minor', 'shipping_address', 'cart_snapshot',
        'failure_code', 'failure_message', 'order_id', 'paid_at',
    ];

    protected $casts = [
        'cart_snapshot' => 'array',
        'total_amount' => 'decimal:2',
        'amount_minor' => 'integer',
        'paid_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function (self $attempt) {
            $attempt->id = $attempt->id ?: (string) Str::uuid();
        });
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
