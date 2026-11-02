<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaypalWebhookEventsTable extends Migration
{
    public function up()
    {
        Schema::create('paypal_webhook_events', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('type', 120);
            $table->timestamp('processed_at')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down()
    {
        Schema::dropIfExists('paypal_webhook_events');
    }
}
