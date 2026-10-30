<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceContractsTables extends Migration
{
    public function up()
    {
        Schema::create('service_contracts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by')->nullable()->index();
            $table->string('public_token', 64)->unique();
            $table->string('contract_number', 80)->unique();
            $table->string('title');
            $table->string('status', 20)->default('draft')->index();
            $table->string('locale', 5)->default('vi');
            $table->date('effective_date')->nullable();
            $table->date('expires_at')->nullable();

            $table->string('provider_name');
            $table->string('provider_legal_name')->nullable();
            $table->string('provider_tax_id')->nullable();
            $table->string('provider_email')->nullable();
            $table->string('provider_phone')->nullable();
            $table->text('provider_address')->nullable();

            $table->string('customer_name');
            $table->string('customer_company')->nullable();
            $table->string('customer_email');
            $table->string('customer_phone')->nullable();
            $table->string('customer_tax_id')->nullable();
            $table->text('customer_address')->nullable();
            $table->text('scope_summary')->nullable();
            $table->longText('terms');
            $table->longText('payment_terms')->nullable();

            $table->decimal('subtotal', 15, 2)->default(0);
            $table->decimal('tax_rate', 5, 2)->default(0);
            $table->decimal('tax_amount', 15, 2)->default(0);
            $table->decimal('total', 15, 2)->default(0);
            $table->string('currency', 3)->default('VND');

            $table->timestamp('sent_at')->nullable();
            $table->timestamp('viewed_at')->nullable();
            $table->timestamp('signed_at')->nullable();
            $table->string('signature_name')->nullable();
            $table->mediumText('signature_data')->nullable();
            $table->string('signature_ip', 45)->nullable();
            $table->text('signature_user_agent')->nullable();
            $table->boolean('signature_consent')->default(false);
            $table->string('signed_payload_hash', 64)->nullable();
            $table->timestamps();
        });

        Schema::create('service_contract_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_contract_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('quantity', 12, 2)->default(1);
            $table->string('unit', 50)->default('gói');
            $table->decimal('unit_price', 15, 2)->default(0);
            $table->decimal('amount', 15, 2)->default(0);
            $table->unsignedInteger('position')->default(0);
            $table->timestamps();

            $table->foreign('service_contract_id')
                ->references('id')->on('service_contracts')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('service_contract_items');
        Schema::dropIfExists('service_contracts');
    }
}
