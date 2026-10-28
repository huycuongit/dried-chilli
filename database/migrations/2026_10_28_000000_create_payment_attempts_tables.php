<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentAttemptsTables extends Migration
{
    public function up()
    {
        // One row per online checkout attempt. It holds an immutable, server-priced cart snapshot;
        // the real order is created only after the provider confirms payment.
        Schema::create('payment_attempts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('cart_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('idempotency_key', 80);
            $table->string('provider', 20);
            $table->string('provider_payment_id')->nullable()->unique();
            $table->string('status', 20)->default('PENDING');
            $table->string('currency', 3);
            $table->decimal('total_amount', 15, 2);
            $table->unsignedBigInteger('amount_minor');
            $table->text('shipping_address');
            $table->json('cart_snapshot');
            $table->string('failure_code', 80)->nullable();
            $table->string('failure_message', 500)->nullable();
            $table->unsignedBigInteger('order_id')->nullable()->unique();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->unique(['cart_id', 'idempotency_key']);
            $table->index(['status', 'created_at']);
        });

        Schema::create('stripe_webhook_events', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('type', 120);
            $table->timestamp('provider_created_at')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down()
    {
        Schema::dropIfExists('stripe_webhook_events');
        Schema::dropIfExists('payment_attempts');
    }
}
