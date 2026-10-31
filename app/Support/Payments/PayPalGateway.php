<?php

namespace App\Support\Payments;

use Illuminate\Support\Facades\Http;

class PayPalGateway
{
    private function baseUrl(): string
    {
        return config('services.paypal.environment') === 'live' ? 'https://api-m.paypal.com' : 'https://api-m.sandbox.paypal.com';
    }

    public function createOrder(array $input): array
    {
        $response = $this->request('/v2/checkout/orders', 'shop-' . $input['attempt_id'], [
            'intent' => 'CAPTURE',
            'purchase_units' => [array_filter([
                'reference_id' => $input['attempt_id'],
                'description' => mb_substr((string) ($input['description'] ?? ''), 0, 127) ?: null,
                'amount' => [
                    'currency_code' => $input['currency'],
                    'value' => PaymentMoney::paypalValue($input['amount_minor'], $input['currency']),
                ],
            ])],
        ]);
        return ['id' => $response['id'], 'status' => $response['status']];
    }

    public function captureOrder(string $orderId): array
    {
        $response = $this->request('/v2/checkout/orders/' . rawurlencode($orderId) . '/capture', 'shop-capture-' . $orderId, []);
        $capture = $this->captureDetails($response);
        if (!$capture) abort(503, 'PayPal returned an incomplete payment result.');
        return $capture;
    }

    public function retrieveOrderCapture(string $orderId): ?array
    {
        $response = Http::withToken($this->accessToken())->timeout(20)
            ->get($this->baseUrl() . '/v2/checkout/orders/' . rawurlencode($orderId));
        if ($response->failed()) throw new \RuntimeException('Could not reconcile PayPal order status.');
        return $this->captureDetails($response->json());
    }

    private function captureDetails(array $response): ?array
    {
        $capture = $response['purchase_units'][0]['payments']['captures'][0] ?? null;
        if (!$capture || ($capture['status'] ?? null) !== 'COMPLETED') return null;
        $currency = $capture['amount']['currency_code'];
        return [
            'id' => $response['id'],
            'capture_id' => $capture['id'] ?? null,
            'captured_at' => $capture['create_time'] ?? null,
            'status' => $capture['status'],
            'amount_minor' => PaymentMoney::paypalMinor($capture['amount']['value'], $currency),
            'currency' => $currency,
        ];
    }

    public function refundCapture(string $captureId, string $attemptId): array
    {
        return $this->request('/v2/payments/captures/' . rawurlencode($captureId) . '/refund', 'refund-' . $attemptId, []);
    }

    public function retrieveRefund(string $refundId): array
    {
        $response = Http::withToken($this->accessToken())->timeout(20)
            ->get($this->baseUrl() . '/v2/payments/refunds/' . rawurlencode($refundId));
        if ($response->failed()) throw new \RuntimeException('Could not retrieve PayPal refund status.');
        return $response->json();
    }

    private function request(string $path, string $requestId, array $body): array
    {
        // PayPal expects a JSON object; an empty PHP array would be sent as "[]".
        $response = Http::withToken($this->accessToken())->timeout(20)
            ->withHeaders(['PayPal-Request-Id' => $requestId])
            ->withBody($body ? json_encode($body) : '{}', 'application/json')
            ->post($this->baseUrl() . $path);
        if ($response->failed()) {
            report(new \RuntimeException('PayPal request failed: ' . $response->status() . ' ' . $response->body()));
            abort(503, 'PayPal is temporarily unavailable. Please try again.');
        }
        return $response->json();
    }

    private function accessToken(): string
    {
        $response = Http::asForm()->timeout(20)
            ->withBasicAuth((string) config('services.paypal.client_id'), (string) config('services.paypal.client_secret'))
            ->post($this->baseUrl() . '/v1/oauth2/token', ['grant_type' => 'client_credentials']);
        $token = $response->successful() ? $response->json('access_token') : null;
        if (!$token) abort(503, 'PayPal authentication failed.');
        return $token;
    }
}
