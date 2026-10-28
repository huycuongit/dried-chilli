<?php

namespace App\Support\Payments;

use UnexpectedValueException;

/**
 * Verifies the Stripe-Signature header against the untouched request body.
 * https://docs.stripe.com/webhooks#verify-manually
 */
class StripeSignature
{
    public static function verify(string $payload, string $header, string $secret, int $tolerance = 300, ?int $now = null): void
    {
        $timestamp = null;
        $signatures = [];
        foreach (explode(',', $header) as $part) {
            [$key, $value] = array_pad(explode('=', trim($part), 2), 2, '');
            if ($key === 't') $timestamp = ctype_digit($value) ? (int) $value : null;
            if ($key === 'v1') $signatures[] = $value;
        }
        if ($secret === '' || $timestamp === null || !$signatures) {
            throw new UnexpectedValueException('Stripe signature header is invalid');
        }

        $expected = hash_hmac('sha256', $timestamp . '.' . $payload, $secret);
        $matched = false;
        foreach ($signatures as $signature) {
            $matched = $matched || hash_equals($expected, $signature);
        }
        if (!$matched) throw new UnexpectedValueException('Stripe signature does not match');
        if (abs(($now ?? time()) - $timestamp) > $tolerance) {
            throw new UnexpectedValueException('Stripe signature timestamp is outside the tolerance');
        }
    }
}
