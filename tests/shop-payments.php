<?php
require __DIR__ . '/../app/Support/Payments/PaymentMoney.php';
require __DIR__ . '/../app/Support/Payments/StripeSignature.php';
use App\Support\Payments\PaymentMoney;
use App\Support\Payments\StripeSignature;
function checkPayment($condition, $message) { if (!$condition) { throw new RuntimeException('Shop payment check failed: ' . $message); } }

// Provider minor units: USD uses cents, zero-decimal currencies do not.
checkPayment(PaymentMoney::stripeMinor('19.99', 'usd') === 1999, 'Stripe USD minor units');
checkPayment(PaymentMoney::stripeMinor('0.1', 'USD') + PaymentMoney::stripeMinor('0.2', 'USD') === 30, 'Stripe float rounding');
checkPayment(PaymentMoney::stripeMinor('170000', 'VND') === 170000, 'Stripe zero-decimal currency');
checkPayment(PaymentMoney::paypalMinor('42.50', 'USD') === 4250, 'PayPal USD minor units');
checkPayment(PaymentMoney::paypalValue(4250, 'USD') === '42.50' && PaymentMoney::paypalValue(500, 'JPY') === '500', 'PayPal value formatting');
foreach (['-1', 'abc', null] as $bad) {
    try { PaymentMoney::stripeMinor($bad, 'USD'); } catch (InvalidArgumentException $e) { continue; }
    throw new RuntimeException('Invalid payment amount accepted');
}

// Stripe webhook signature: valid, tampered body, wrong secret, replayed timestamp and missing secret.
$payload = '{"id":"evt_1","type":"payment_intent.succeeded"}';
$secret = 'whsec_test';
$time = 1761600000;
$header = "t={$time},v1=" . hash_hmac('sha256', "{$time}.{$payload}", $secret) . ',v0=ignored';
StripeSignature::verify($payload, $header, $secret, 300, $time + 10);
foreach ([[$payload . ' ', $secret, $time], [$payload, 'whsec_other', $time], [$payload, $secret, $time + 301], [$payload, '', $time]] as [$body, $key, $now]) {
    try { StripeSignature::verify($body, $header, $key, 300, $now); } catch (UnexpectedValueException $e) { continue; }
    throw new RuntimeException('Invalid Stripe signature accepted');
}

echo "Passed shop payment amount and Stripe signature checks.\n";
