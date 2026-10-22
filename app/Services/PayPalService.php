<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalService
{
    /**
     * @var PayPalClient
     */
    protected $provider;

    public function __construct(PayPalClient $provider = null)
    {
        $this->provider = $provider ?? new PayPalClient;
        $this->initialize();
    }

    /**
     * Initialize PayPal client credentials from config.
     */
    protected function initialize(): void
    {
        $config = config('paypal');
        if (!empty($config)) {
            $this->provider->setApiCredentials($config);
        }
    }

    /**
     * Create a PayPal order for checkout and get approval URL.
     *
     * @param float $amount
     * @param int|string $orderId
     * @param string $returnUrl
     * @param string $cancelUrl
     * @return array Contains 'paypal_order_id' and 'approve_url'
     * @throws Exception
     */
    public function createOrder(float $amount, $orderId, string $returnUrl, string $cancelUrl): array
    {
        $token = $this->provider->getAccessToken();
        if (empty($token)) {
            throw new Exception('Unable to authenticate with PayPal API.');
        }

        $data = [
            'intent' => 'CAPTURE',
            'application_context' => [
                'return_url' => $returnUrl,
                'cancel_url' => $cancelUrl,
                'brand_name' => config('app.name', 'Dried Chili'),
                'user_action' => 'PAY_NOW',
            ],
            'purchase_units' => [
                [
                    'reference_id' => (string) $orderId,
                    'amount' => [
                        'currency_code' => config('paypal.currency', 'USD'),
                        'value' => number_format($amount, 2, '.', ''),
                    ],
                    'description' => "Order #{$orderId}",
                ],
            ],
        ];

        $response = $this->provider->createOrder($data);

        if (is_array($response) && isset($response['id']) && in_array($response['status'] ?? '', ['CREATED', 'SAVED', 'APPROVED'])) {
            $approveUrl = null;
            if (!empty($response['links']) && is_array($response['links'])) {
                foreach ($response['links'] as $link) {
                    if (isset($link['rel']) && $link['rel'] === 'approve') {
                        $approveUrl = $link['href'];
                        break;
                    }
                }
            }

            if (!$approveUrl) {
                throw new Exception('PayPal approval URL was not returned.');
            }

            return [
                'paypal_order_id' => $response['id'],
                'approve_url' => $approveUrl,
            ];
        }

        $errorMessage = $response['message'] ?? ($response['error']['message'] ?? 'Failed to create PayPal order.');
        Log::error('PayPal createOrder failed:', ['response' => $response]);
        throw new Exception($errorMessage);
    }

    /**
     * Capture payment for an approved PayPal order.
     *
     * @param string $token PayPal Order ID / token
     * @return array
     * @throws Exception
     */
    public function capturePayment(string $token): array
    {
        $accessToken = $this->provider->getAccessToken();
        if (empty($accessToken)) {
            throw new Exception('Unable to authenticate with PayPal API.');
        }

        $response = $this->provider->capturePaymentOrder($token);

        if (is_array($response) && isset($response['status']) && $response['status'] === 'COMPLETED') {
            return [
                'status' => 'COMPLETED',
                'transaction_id' => $response['purchase_units'][0]['payments']['captures'][0]['id'] ?? $response['id'],
                'raw' => $response,
            ];
        }

        $errorMessage = $response['message'] ?? ($response['error']['message'] ?? 'Failed to capture PayPal payment.');
        Log::error('PayPal capturePayment failed:', ['token' => $token, 'response' => $response]);
        throw new Exception($errorMessage);
    }

    /**
     * Get underlying PayPal client provider.
     *
     * @return PayPalClient
     */
    public function getProvider(): PayPalClient
    {
        return $this->provider;
    }
}
