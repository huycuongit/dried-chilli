<?php

namespace App\Support\Payments;

use Illuminate\Support\Facades\Http;
use UnexpectedValueException;

class StripeGateway
{
    private const API = 'https://api.stripe.com/v1';

    public function createIntent(array $input): array
    {
        return $this->toResult($this->request('post', '/payment_intents', [
            'amount' => $input['amount_minor'],
            'currency' => strtolower($input['currency']),
            'automatic_payment_methods' => ['enabled' => 'true'],
            'description' => $input['description'] ?? null,
            'receipt_email' => $input['receipt_email'] ?? null,
            'metadata' => [
                'paymentAttemptId' => $input['attempt_id'],
                'cartId' => (string) $input['cart_id'],
            ],
        ], 'shop-payment-attempt:' . $input['attempt_id']));
    }

    public function retrieveIntent(string $providerPaymentId): array
    {
        return $this->toResult($this->request('get', '/payment_intents/' . rawurlencode($providerPaymentId)));
    }

    public function parseWebhook(string $rawBody, string $signature): array
    {
        StripeSignature::verify($rawBody, $signature, (string) config('services.stripe.webhook_secret'));
        $event = json_decode($rawBody, true);
        if (!is_array($event) || empty($event['id']) || empty($event['type'])) {
            throw new UnexpectedValueException('Stripe event payload is invalid');
        }
        $intent = $event['data']['object'] ?? [];
        $error = $intent['last_payment_error'] ?? [];

        return [
            'event_id' => $event['id'],
            'type' => $event['type'],
            'provider_created_at' => isset($event['created']) ? date('Y-m-d H:i:s', (int) $event['created']) : null,
            'intent' => [
                'id' => $intent['id'] ?? null,
                'status' => $intent['status'] ?? null,
                'amount_minor' => (int) ($intent['amount'] ?? 0),
                'currency' => (string) ($intent['currency'] ?? ''),
                'metadata' => $intent['metadata'] ?? [],
                'failure_code' => $error['decline_code'] ?? $error['code'] ?? null,
                'failure_message' => $error['message'] ?? null,
            ],
        ];
    }

    private function request(string $method, string $path, array $data = [], ?string $idempotencyKey = null): array
    {
        $request = Http::withToken((string) config('services.stripe.secret'))->asForm()->timeout(20);
        if ($idempotencyKey) $request = $request->withHeaders(['Idempotency-Key' => $idempotencyKey]);
        $response = $request->{$method}(self::API . $path, array_filter($data, fn ($value) => $value !== null));
        if ($response->failed()) {
            report(new \RuntimeException('Stripe request failed: ' . $response->status() . ' ' . $response->json('error.message')));
            abort(503, 'Card payment is temporarily unavailable. Please try again.');
        }
        return $response->json();
    }

    private function toResult(array $intent): array
    {
        if (empty($intent['client_secret'])) throw new UnexpectedValueException('Stripe PaymentIntent has no client secret');
        return ['id' => $intent['id'], 'client_secret' => $intent['client_secret'], 'status' => $intent['status']];
    }
}
