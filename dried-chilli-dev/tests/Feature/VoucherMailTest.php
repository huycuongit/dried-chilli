<?php

namespace Tests\Feature;

use App\Mail\VoucherDiscountMail;
use App\Models\Coupon;
use App\Services\CouponService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class VoucherMailTest extends TestCase
{
    use RefreshDatabase;

    public function test_claim_voucher_requires_valid_email()
    {
        $response = $this->postJson('/api/coupon/claim-voucher', [
            'email' => 'not-an-email',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    public function test_claim_voucher_creates_15_percent_coupon_and_sends_email()
    {
        Mail::fake();

        $response = $this->postJson('/api/coupon/claim-voucher', [
            'email' => 'testuser@example.com',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'discount' => 15,
            ]);

        $code = $response->json('code');
        $this->assertNotEmpty($code);
        $this->assertStringStartsWith('CHILLI15-', $code);

        $this->assertDatabaseHas('coupons', [
            'code' => $code,
            'email' => 'testuser@example.com',
            'type' => 'percent',
            'value' => 15.00,
            'is_active' => true,
            'usage_limit' => 1,
        ]);

        Mail::assertSent(VoucherDiscountMail::class, function ($mail) use ($code) {
            return $mail->hasTo('testuser@example.com') && $mail->coupon->code === $code;
        });
    }

    public function test_subsequent_claim_reuses_active_voucher()
    {
        Mail::fake();

        $res1 = $this->postJson('/api/coupon/claim-voucher', [
            'email' => 'loyal@example.com',
        ]);
        $code1 = $res1->json('code');

        $res2 = $this->postJson('/api/coupon/claim-voucher', [
            'email' => 'loyal@example.com',
        ]);
        $code2 = $res2->json('code');

        $this->assertEquals($code1, $code2);
        $this->assertEquals(1, Coupon::where('email', 'loyal@example.com')->count());
    }

    public function test_generated_voucher_applies_15_percent_discount_in_service()
    {
        $couponService = app(CouponService::class);
        $coupon = $couponService->generateVoucherForEmail('buyer@example.com', 15.0);

        $result = $couponService->applyCoupon($coupon->code, 100.0);

        $this->assertEquals(15.0, $result['discount_amount']);
        $this->assertEquals(85.0, $result['new_total']);
    }
}

