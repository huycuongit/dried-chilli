<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentExpiryAndRefunds extends Migration
{
    public function up()
    {
        Schema::table('payment_attempts', function (Blueprint $table) {
            $table->timestamp('expires_at')->nullable();
            $table->string('provider_capture_id')->nullable();
            $table->string('provider_refund_id')->nullable();
            $table->string('refund_status')->nullable();
            $table->timestamp('refund_requested_at')->nullable();
            $table->text('refund_last_error')->nullable();
        });
    }

    public function down()
    {
        Schema::table('payment_attempts', function (Blueprint $table) {
            $table->dropColumn(['expires_at', 'provider_capture_id', 'provider_refund_id', 'refund_status', 'refund_requested_at', 'refund_last_error']);
        });
    }
}
