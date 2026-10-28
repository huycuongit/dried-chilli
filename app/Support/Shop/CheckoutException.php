<?php

namespace App\Support\Shop;

use RuntimeException;

/** A checkout problem whose message is safe to show to the customer (empty cart, stock, coupon). */
class CheckoutException extends RuntimeException
{
}
