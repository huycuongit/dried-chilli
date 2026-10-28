<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\PaymentAttempt;
use App\Support\Payments\CheckoutPaymentService;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

/**
 * Runs on in-memory SQLite (php -d extension=pdo_sqlite) with faked Stripe/PayPal HTTP calls.
 */
class CheckoutPaymentTest extends TestCase
{
    private const SESSION = 'session_test_cart';
    private const WEBHOOK_SECRET = 'whsec_test_secret';
    private const ADDRESS = 'Jane (Phone: 0400000000, Email: jane@example.com) | Address: 1 Chili St, Sydney';

    private int $cartId;
    private int $productId = 7;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => ':memory:',
            'services.shop_currency' => 'USD',
            'services.stripe' => ['enabled' => true, 'key' => 'pk_test_123', 'secret' => 'sk_test_123', 'webhook_secret' => self::WEBHOOK_SECRET],
            'services.paypal' => ['enabled' => true, 'environment' => 'sandbox', 'client_id' => 'pp_id', 'client_secret' => 'pp_secret'],
        ]);
        DB::purge('sqlite');
        $this->createSchema();

        DB::table('products')->insert(['id' => $this->productId, 'name' => 'Chili Crisp', 'created_at' => now(), 'updated_at' => now()]);
        Inventory::create(['product_id' => $this->productId, 'variant_id' => null, 'quantity' => 10, 'low_stock_threshold' => 1]);
        $cart = Cart::create(['session_id' => self::SESSION]);
        $this->cartId = $cart->id;
        // 2 x 12.50 = 25.00
        CartItem::create(['cart_id' => $cart->id, 'product_id' => $this->productId, 'variant_id' => null, 'bundle_id' => null, 'quantity' => 2, 'price' => 12.50]);
        Coupon::create(['code' => 'SAVE5', 'type' => 'fixed', 'value' => 5, 'min_order_amount' => 0, 'used_count' => 0, 'is_active' => true]);

        Http::fake([
            'api.stripe.com/v1/payment_intents' => Http::response(['id' => 'pi_1', 'client_secret' => 'pi_1_secret', 'status' => 'requires_payment_method']),
            'api.stripe.com/v1/payment_intents/*' => Http::response(['id' => 'pi_1', 'client_secret' => 'pi_1_secret', 'status' => 'requires_payment_method']),
            'api-m.sandbox.paypal.com/v1/oauth2/token' => Http::response(['access_token' => 'token']),
            'api-m.sandbox.paypal.com/v2/checkout/orders/PP1/capture' => fn () => Http::response($this->paypalCapture),
            'api-m.sandbox.paypal.com/v2/checkout/orders' => Http::response(['id' => 'PP1', 'status' => 'CREATED']),
        ]);
    }

    private array $paypalCapture = ['id' => 'PP1', 'purchase_units' => [['payments' => ['captures' => [['status' => 'COMPLETED', 'amount' => ['currency_code' => 'USD', 'value' => '20.00']]]]]]];

    // ---- Offline checkout (regression) ----

    public function test_cod_checkout_still_places_unpaid_order_and_clears_cart()
    {
        $response = $this->api('POST', '/api/checkout', ['shipping_address' => self::ADDRESS, 'payment_method' => 'cod', 'coupon_code' => 'SAVE5']);

        $response->assertOk()->assertJson(['message' => 'Order placed successfully']);
        $order = Order::findOrFail($response->json('order_id'));
        $this->assertSame('unpaid', $order->payment_status);
        $this->assertEquals(20.00, $order->total_amount);
        $this->assertSame(8, Inventory::first()->quantity);
        $this->assertSame(1, Coupon::first()->used_count);
        $this->assertSame(0, CartItem::count());
        $this->assertSame(2, DB::table('order_items')->where('order_id', $order->id)->value('quantity'));
    }

    public function test_offline_checkout_no_longer_accepts_paypal_stub()
    {
        $this->api('POST', '/api/checkout', ['shipping_address' => self::ADDRESS, 'payment_method' => 'paypal'])->assertStatus(422);
        $this->assertSame(0, Order::count());
    }

    // ---- Stripe ----

    public function test_stripe_start_prices_on_server_and_creates_no_order()
    {
        $response = $this->startStripe('stripe_key_000001', ['coupon_code' => 'SAVE5']);

        $response->assertStatus(201)->assertJson(['status' => 'PENDING', 'clientSecret' => 'pi_1_secret', 'total' => 20.0]);
        $attempt = PaymentAttempt::findOrFail($response->json('paymentAttemptId'));
        $this->assertSame(2000, $attempt->amount_minor);
        $this->assertSame('pi_1', $attempt->provider_payment_id);
        $this->assertSame(0, Order::count());
        $this->assertSame(10, Inventory::first()->quantity);
        $this->assertSame(1, CartItem::count());
        $this->assertSame(0, Coupon::first()->used_count);

        Http::assertSent(fn ($request) => $request->url() === 'https://api.stripe.com/v1/payment_intents'
            && $request['amount'] == 2000 && $request['currency'] === 'usd'
            && $request['metadata']['paymentAttemptId'] === $attempt->id
            && $request->hasHeader('Idempotency-Key', 'shop-payment-attempt:' . $attempt->id));
    }

    public function test_stripe_start_is_idempotent_per_key()
    {
        $first = $this->startStripe('stripe_key_000001')->json('paymentAttemptId');
        $second = $this->startStripe('stripe_key_000001')->json('paymentAttemptId');

        $this->assertSame($first, $second);
        $this->assertSame(1, PaymentAttempt::count());
        Http::assertSentCount(2); // one create, one retrieve
    }

    public function test_stripe_start_rejects_bad_key_empty_cart_and_out_of_stock()
    {
        $this->startStripe('short')->assertStatus(400);

        Inventory::query()->update(['quantity' => 1]);
        $this->startStripe('stripe_key_000002')->assertStatus(400)->assertJson(['error' => 'Chili Crisp is out of stock or exceeds available quantity.']);

        CartItem::query()->delete();
        $this->startStripe('stripe_key_000003')->assertStatus(400)->assertJson(['error' => 'Cart is empty. Please add items before checking out.']);
        $this->assertSame(0, PaymentAttempt::count());
    }

    public function test_stripe_disabled_or_secret_key_in_publishable_slot_returns_503()
    {
        config(['services.stripe.key' => 'sk_test_leaked']);
        $this->assertFalse(CheckoutPaymentService::stripeEnabled());
        $this->assertNull(CheckoutPaymentService::stripePublishableKey());
        $this->startStripe('stripe_key_000001')->assertStatus(503);
    }

    public function test_signed_success_webhook_creates_exactly_one_paid_order()
    {
        $attemptId = $this->startStripe('stripe_key_000001', ['coupon_code' => 'SAVE5'])->json('paymentAttemptId');

        $this->webhook('evt_1', 'payment_intent.succeeded', $attemptId)->assertOk();
        $this->webhook('evt_1', 'payment_intent.succeeded', $attemptId)->assertOk(); // replay
        $this->webhook('evt_2', 'payment_intent.succeeded', $attemptId)->assertOk(); // duplicate delivery

        $this->assertSame(1, Order::count());
        $order = Order::first();
        $this->assertSame('paid', $order->payment_status);
        $this->assertSame('stripe', $order->payment_method);
        $this->assertSame(self::ADDRESS, $order->shipping_address);
        $this->assertEquals(20.00, $order->total_amount);
        $this->assertSame(8, Inventory::first()->quantity);
        $this->assertSame(1, Coupon::first()->used_count);
        $this->assertSame(0, CartItem::count());

        $this->api('GET', "/api/checkout/payments/{$attemptId}")->assertOk()->assertJson(['status' => 'PAID', 'orderId' => $order->id]);
    }

    public function test_webhook_with_bad_signature_is_rejected()
    {
        $attemptId = $this->startStripe('stripe_key_000001')->json('paymentAttemptId');

        $this->webhook('evt_1', 'payment_intent.succeeded', $attemptId, [], 'whsec_wrong')->assertStatus(400);
        $this->postJson('/api/payments/stripe/webhook', [])->assertStatus(400);

        $this->assertSame(0, Order::count());
        $this->assertSame(0, DB::table('stripe_webhook_events')->count());
    }

    public function test_webhook_with_mismatched_amount_creates_no_order()
    {
        $attemptId = $this->startStripe('stripe_key_000001')->json('paymentAttemptId');

        $this->webhook('evt_1', 'payment_intent.succeeded', $attemptId, ['amount' => 1])->assertStatus(400);

        $this->assertSame(0, Order::count());
        $this->assertSame(PaymentAttempt::PENDING, PaymentAttempt::first()->status);
        // Rolled back, so Stripe's retry is processed again instead of being treated as a replay.
        $this->assertSame(0, DB::table('stripe_webhook_events')->count());
    }

    public function test_failed_and_processing_webhooks_keep_cart_and_create_no_order()
    {
        $attemptId = $this->startStripe('stripe_key_000001')->json('paymentAttemptId');

        $this->webhook('evt_1', 'payment_intent.processing', $attemptId)->assertOk();
        $this->assertSame(PaymentAttempt::PROCESSING, PaymentAttempt::first()->status);

        $this->webhook('evt_2', 'payment_intent.payment_failed', $attemptId, ['last_payment_error' => ['code' => 'card_declined', 'message' => 'Your card was declined.']])->assertOk();

        $this->api('GET', "/api/checkout/payments/{$attemptId}")->assertOk()
            ->assertJson(['status' => 'FAILED', 'failureMessage' => 'Your card was declined.', 'orderId' => null]);
        $this->assertSame(0, Order::count());
        $this->assertSame(1, CartItem::count());
        $this->assertSame(10, Inventory::first()->quantity);
    }

    public function test_unrelated_webhook_events_are_acknowledged()
    {
        $payload = json_encode(['id' => 'evt_x', 'type' => 'charge.refunded', 'created' => time(), 'data' => ['object' => ['id' => 'ch_1']]]);
        $this->call('POST', '/api/payments/stripe/webhook', [], [], [], ['HTTP_STRIPE_SIGNATURE' => $this->sign($payload, self::WEBHOOK_SECRET), 'CONTENT_TYPE' => 'application/json'], $payload)->assertOk();
        $this->assertNotNull(DB::table('stripe_webhook_events')->where('id', 'evt_x')->value('processed_at'));
    }

    public function test_payment_status_is_private_to_the_cart_that_started_it()
    {
        $attemptId = $this->startStripe('stripe_key_000001')->json('paymentAttemptId');
        Cart::create(['session_id' => 'session_someone_else']);

        $this->getJson("/api/checkout/payments/{$attemptId}", ['Session-Id' => 'session_someone_else'])->assertStatus(404);
        $this->getJson("/api/checkout/payments/{$attemptId}", ['Session-Id' => 'session_without_cart'])->assertStatus(404);
    }

    // ---- PayPal ----

    public function test_paypal_capture_creates_paid_order_once()
    {
        $start = $this->api('POST', '/api/checkout/paypal', ['shipping_address' => self::ADDRESS, 'coupon_code' => 'SAVE5'], ['Idempotency-Key' => 'paypal_key_00000001']);
        $start->assertStatus(201)->assertJson(['paypalOrderId' => 'PP1', 'status' => 'PENDING']);
        $attemptId = $start->json('paymentAttemptId');
        $this->assertSame(0, Order::count());

        $this->api('POST', "/api/checkout/paypal/{$attemptId}/capture", ['paypalOrderId' => 'PP1'])->assertOk()->assertJson(['status' => 'PAID']);
        $this->api('POST', "/api/checkout/paypal/{$attemptId}/capture", ['paypalOrderId' => 'PP1'])->assertOk()->assertJson(['status' => 'PAID']);

        $this->assertSame(1, Order::count());
        $order = Order::first();
        $this->assertSame(['paypal', 'paid'], [$order->payment_method, $order->payment_status]);
        $this->assertSame(8, Inventory::first()->quantity);
        $this->assertSame(0, CartItem::count());
        Http::assertSent(fn ($request) => str_ends_with($request->url(), '/v2/checkout/orders')
            && (json_decode($request->body(), true)['purchase_units'][0]['amount'] ?? null) === ['currency_code' => 'USD', 'value' => '20.00']);
        Http::assertSent(fn ($request) => str_ends_with($request->url(), '/PP1/capture') && $request->body() === '{}');
    }

    public function test_paypal_capture_rejects_wrong_order_and_mismatched_amount()
    {
        $attemptId = $this->api('POST', '/api/checkout/paypal', ['shipping_address' => self::ADDRESS], ['Idempotency-Key' => 'paypal_key_00000001'])->json('paymentAttemptId');

        $this->api('POST', "/api/checkout/paypal/{$attemptId}/capture", ['paypalOrderId' => 'PP_OTHER'])->assertStatus(404);

        // Cart total is 25.00 without the coupon, PayPal captured only 20.00.
        $this->api('POST', "/api/checkout/paypal/{$attemptId}/capture", ['paypalOrderId' => 'PP1'])->assertStatus(400);
        $this->assertSame(0, Order::count());
        $this->assertSame(1, CartItem::count());
    }

    // ---- helpers ----

    private function api(string $method, string $uri, array $data = [], array $headers = [])
    {
        return $this->json($method, $uri, $data, ['Session-Id' => self::SESSION] + $headers);
    }

    private function startStripe(string $key, array $extra = [])
    {
        return $this->api('POST', '/api/checkout/stripe', ['shipping_address' => self::ADDRESS] + $extra, ['Idempotency-Key' => $key]);
    }

    private function webhook(string $eventId, string $type, string $attemptId, array $intentOverrides = [], string $secret = self::WEBHOOK_SECRET)
    {
        $attempt = PaymentAttempt::findOrFail($attemptId);
        $payload = json_encode([
            'id' => $eventId,
            'type' => $type,
            'created' => time(),
            'data' => ['object' => $intentOverrides + [
                'id' => 'pi_1',
                'status' => 'succeeded',
                'amount' => $attempt->amount_minor,
                'currency' => 'usd',
                'metadata' => ['paymentAttemptId' => $attempt->id, 'cartId' => (string) $attempt->cart_id],
            ]],
        ]);

        return $this->call('POST', '/api/payments/stripe/webhook', [], [], [], [
            'HTTP_STRIPE_SIGNATURE' => $this->sign($payload, $secret),
            'CONTENT_TYPE' => 'application/json',
        ], $payload);
    }

    private function sign(string $payload, string $secret): string
    {
        $time = time();
        return "t={$time},v1=" . hash_hmac('sha256', "{$time}.{$payload}", $secret);
    }

    private function createSchema(): void
    {
        Schema::create('products', function (Blueprint $t) { $t->id(); $t->string('name'); $t->timestamps(); });
        Schema::create('bundles', function (Blueprint $t) { $t->id(); $t->string('name')->nullable(); $t->timestamps(); });
        Schema::create('inventories', function (Blueprint $t) { $t->id(); $t->unsignedBigInteger('product_id'); $t->unsignedBigInteger('variant_id')->nullable(); $t->integer('quantity'); $t->integer('low_stock_threshold')->default(0); $t->timestamps(); });
        Schema::create('carts', function (Blueprint $t) { $t->id(); $t->unsignedBigInteger('user_id')->nullable(); $t->string('session_id')->nullable(); $t->timestamps(); });
        Schema::create('cart_items', function (Blueprint $t) { $t->id(); $t->unsignedBigInteger('cart_id'); $t->unsignedBigInteger('product_id')->nullable(); $t->unsignedBigInteger('variant_id')->nullable(); $t->unsignedBigInteger('bundle_id')->nullable(); $t->integer('quantity'); $t->decimal('price', 15, 2); $t->timestamps(); });
        Schema::create('coupons', function (Blueprint $t) { $t->id(); $t->string('code'); $t->string('email')->nullable(); $t->string('type'); $t->decimal('value', 15, 2); $t->decimal('min_order_amount', 15, 2)->default(0); $t->decimal('max_discount', 15, 2)->nullable(); $t->integer('usage_limit')->nullable(); $t->integer('used_count')->default(0); $t->timestamp('expires_at')->nullable(); $t->boolean('is_active')->default(true); $t->timestamps(); });
        Schema::create('orders', function (Blueprint $t) { $t->id(); $t->unsignedBigInteger('user_id')->nullable(); $t->string('status')->default('pending'); $t->decimal('total_amount', 15, 2); $t->text('shipping_address')->nullable(); $t->string('payment_method')->nullable(); $t->string('payment_status')->default('unpaid'); $t->string('coupon_code')->nullable(); $t->decimal('discount_amount', 15, 2)->default(0); $t->timestamps(); });
        Schema::create('order_items', function (Blueprint $t) { $t->id(); $t->unsignedBigInteger('order_id'); $t->unsignedBigInteger('product_id')->nullable(); $t->unsignedBigInteger('bundle_id')->nullable(); $t->unsignedBigInteger('variant_id')->nullable(); $t->integer('quantity'); $t->decimal('price', 15, 2); $t->timestamps(); });

        require_once database_path('migrations/2026_10_28_000000_create_payment_attempts_tables.php');
        (new \CreatePaymentAttemptsTables())->up();
    }
}
