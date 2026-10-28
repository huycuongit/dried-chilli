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
        $capture = $response['purchase_units'][0]['payments']['captures'][0] ?? null;
        if (!$capture) abort(503, 'PayPal returned an incomplete payment result.');
        $currency = $capture['amount']['currency_code'];
        return [
            'id' => $response['id'],
            'status' => $capture['status'],
            'amount_minor' => PaymentMoney::paypalMinor($capture['amount']['value'], $currency),
            'currency' => $currency,
        ];
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
