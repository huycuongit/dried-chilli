<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\PayPalService;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class PayPalCheckoutTest extends TestCase
{
    use RefreshDatabase;

    protected function createProductWithStock(int $stock = 10, float $price = 25.00)
    {
        $category = Category::create([
            'name' => 'Chili Category',
            'slug' => 'chili-category',
            'is_active' => true,
        ]);

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Premium Dried Chili',
            'slug' => 'premium-dried-chili',
            'base_price' => $price,
            'is_active' => true,
        ]);

        $inventory = Inventory::create([
            'product_id' => $product->id,
            'quantity' => $stock,
            'low_stock_threshold' => 2,
        ]);

        return [$product, $inventory];
    }

    public function test_checkout_with_paypal_creates_pending_order_and_returns_approval_url()
    {
        list($product, $inventory) = $this->createProductWithStock(10, 30.00);

        $sessionId = 'test-session-paypal-1';
        $cart = Cart::create(['session_id' => $sessionId]);
        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'price' => 30.00,
        ]);

        $mockPayPal = Mockery::mock(PayPalService::class);
        $mockPayPal->shouldReceive('createOrder')
            ->once()
            ->withArgs(function ($amount, $orderId, $returnUrl, $cancelUrl) {
                return $amount == 60.00 && !empty($orderId) && !empty($returnUrl) && !empty($cancelUrl);
            })
            ->andReturn([
                'paypal_order_id' => 'PAYPAL-ORD-TEST-123',
                'approve_url' => 'https://www.sandbox.paypal.com/checkoutnow?token=PAYPAL-ORD-TEST-123',
            ]);

        $this->app->instance(PayPalService::class, $mockPayPal);

        $response = $this->withHeaders(['Session-Id' => $sessionId])
            ->postJson('/api/checkout', [
                'shipping_address' => '123 Spicy Blvd, Pepper Town',
                'payment_method' => 'paypal',
            ]);

        $response->assertStatus(200)
            ->assertJson([
                'redirect_url' => 'https://www.sandbox.paypal.com/checkoutnow?token=PAYPAL-ORD-TEST-123',
                'total' => 60.00,
            ]);

        $orderId = $response->json('order_id');
        $this->assertDatabaseHas('orders', [
            'id' => $orderId,
            'payment_method' => 'paypal',
            'payment_status' => 'pending',
            'transaction_id' => 'PAYPAL-ORD-TEST-123',
            'total_amount' => 60.00,
        ]);

        // Cart should still exist (preserved until successful capture)
        $this->assertDatabaseHas('cart_items', [
            'cart_id' => $cart->id,
            'product_id' => $product->id,
        ]);

        // Stock should be reserved/decremented
        $this->assertEquals(8, $inventory->fresh()->quantity);
    }

    public function test_paypal_success_callback_captures_payment_and_completes_order()
    {
        list($product, $inventory) = $this->createProductWithStock(8, 20.00);

        $sessionId = 'test-session-paypal-success';
        $cart = Cart::create(['session_id' => $sessionId]);
        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'price' => 20.00,
        ]);

        $order = Order::create([
            'status' => 'pending',
            'total_amount' => 20.00,
            'shipping_address' => '456 Chili Way',
            'payment_method' => 'paypal',
            'payment_status' => 'pending',
            'transaction_id' => 'PAYPAL-TOKEN-ABC',
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'price' => 20.00,
        ]);

        $mockPayPal = Mockery::mock(PayPalService::class);
        $mockPayPal->shouldReceive('capturePayment')
            ->once()
            ->with('PAYPAL-TOKEN-ABC')
            ->andReturn([
                'status' => 'COMPLETED',
                'transaction_id' => 'CAPTURE-ID-9999',
            ]);

        $this->app->instance(PayPalService::class, $mockPayPal);

        $response = $this->withSession(['_token' => 'dummy'])
            ->withHeaders(['Session-Id' => $sessionId])
            ->get(route('api.checkout.paypal.success', [
                'token' => 'PAYPAL-TOKEN-ABC',
                'order_id' => $order->id,
            ]));

        $response->assertRedirect(route('page.cart'));
        $response->assertSessionHas('success');

        $order->refresh();
        $this->assertEquals('paid', $order->payment_status);
        $this->assertEquals('processing', $order->status);
        $this->assertEquals('CAPTURE-ID-9999', $order->transaction_id);

        // Cart items should now be cleared
        $this->assertDatabaseMissing('cart_items', [
            'cart_id' => $cart->id,
        ]);
    }

    public function test_paypal_cancel_callback_restores_inventory_and_marks_order_cancelled()
    {
        list($product, $inventory) = $this->createProductWithStock(5, 15.00);

        $order = Order::create([
            'status' => 'pending',
            'total_amount' => 30.00,
            'shipping_address' => '789 Cancelled Rd',
            'payment_method' => 'paypal',
            'payment_status' => 'pending',
            'transaction_id' => 'PAYPAL-TOKEN-CANCEL',
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'price' => 15.00,
        ]);

        $response = $this->get(route('api.checkout.paypal.cancel', [
            'order_id' => $order->id,
        ]));

        $response->assertRedirect(route('page.cart'));
        $response->assertSessionHas('error');

        $order->refresh();
        $this->assertEquals('cancelled', $order->payment_status);
        $this->assertEquals('cancelled', $order->status);

        // Inventory should be restored by +2 (5 + 2 = 7)
        $this->assertEquals(7, $inventory->fresh()->quantity);
    }

    public function test_paypal_api_error_during_checkout_rolls_back_transaction()
    {
        list($product, $inventory) = $this->createProductWithStock(10, 50.00);

        $sessionId = 'test-session-paypal-error';
        $cart = Cart::create(['session_id' => $sessionId]);
        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'price' => 50.00,
        ]);

        $mockPayPal = Mockery::mock(PayPalService::class);
        $mockPayPal->shouldReceive('createOrder')
            ->once()
            ->andThrow(new Exception('PayPal authentication service unavailable.'));

        $this->app->instance(PayPalService::class, $mockPayPal);

        $response = $this->withHeaders(['Session-Id' => $sessionId])
            ->postJson('/api/checkout', [
                'shipping_address' => 'Failed Address',
                'payment_method' => 'paypal',
            ]);

        $response->assertStatus(400)
            ->assertJson([
                'error' => 'PayPal authentication service unavailable.',
            ]);

        // No order should have been persisted
        $this->assertEquals(0, Order::count());

        // Inventory stock should NOT be decremented
        $this->assertEquals(10, $inventory->fresh()->quantity);
    }

    public function test_paypal_capture_failure_marks_order_as_failed()
    {
        list($product, $inventory) = $this->createProductWithStock(10, 20.00);

        $order = Order::create([
            'status' => 'pending',
            'total_amount' => 20.00,
            'shipping_address' => 'Test Failure Address',
            'payment_method' => 'paypal',
            'payment_status' => 'pending',
            'transaction_id' => 'PAYPAL-TOKEN-FAIL',
        ]);

        $mockPayPal = Mockery::mock(PayPalService::class);
        $mockPayPal->shouldReceive('capturePayment')
            ->once()
            ->andThrow(new Exception('INSTRUMENT_DECLINED'));

        $this->app->instance(PayPalService::class, $mockPayPal);

        $response = $this->get(route('api.checkout.paypal.success', [
            'token' => 'PAYPAL-TOKEN-FAIL',
            'order_id' => $order->id,
        ]));

        $response->assertRedirect(route('page.cart'));
        $response->assertSessionHas('error');

        $order->refresh();
        $this->assertEquals('failed', $order->payment_status);
    }
}
