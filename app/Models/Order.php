<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'total_amount',
        'shipping_address',
        'payment_method',
        'payment_status',
        'transaction_id',
        'coupon_code',
        'discount_amount',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
}
