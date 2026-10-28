<?php

namespace App\Support\Payments;

use InvalidArgumentException;

/**
 * Converts decimal shop amounts to provider minor units.
 * Kept free of framework dependencies so it can be checked by tests/shop-payments.php.
 */
class PaymentMoney
{
    // https://docs.stripe.com/currencies#zero-decimal
    private const STRIPE_ZERO_DECIMAL = ['BIF', 'CLP', 'DJF', 'GNF', 'JPY', 'KMF', 'KRW', 'MGA', 'PYG', 'RWF', 'UGX', 'VND', 'VUV', 'XAF', 'XOF', 'XPF'];
    // https://developer.paypal.com/reference/currency-codes/
    private const PAYPAL_ZERO_DECIMAL = ['HUF', 'JPY', 'TWD'];

    public static function stripeMinor($amount, string $currency): int
    {
        return self::toMinor($amount, in_array(strtoupper($currency), self::STRIPE_ZERO_DECIMAL, true) ? 0 : 2);
    }

    public static function paypalDecimals(string $currency): int
    {
        return in_array(strtoupper($currency), self::PAYPAL_ZERO_DECIMAL, true) ? 0 : 2;
    }

    public static function paypalMinor($amount, string $currency): int
    {
        return self::toMinor($amount, self::paypalDecimals($currency));
    }

    public static function paypalValue(int $minor, string $currency): string
    {
        $decimals = self::paypalDecimals($currency);
        return number_format($minor / (10 ** $decimals), $decimals, '.', '');
    }

    private static function toMinor($amount, int $decimals): int
    {
        if (!is_numeric($amount) || (float) $amount < 0) {
            throw new InvalidArgumentException('Payment amount must be a non-negative number');
        }
        return (int) round((float) $amount * (10 ** $decimals));
    }
}
