<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaypalReconciliationTimestamp extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('payment_attempts', 'paypal_checked_at')) {
            Schema::table('payment_attempts', function (Blueprint $table) {
                $table->timestamp('paypal_checked_at')->nullable();
            });
        }
    }

    public function down()
    {
        Schema::table('payment_attempts', function (Blueprint $table) {
            $table->dropColumn('paypal_checked_at');
        });
    }
}
