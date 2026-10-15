<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyCartAndBundlesForBuyableBundles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->nullable()->change();
            $table->unsignedBigInteger('bundle_id')->nullable()->after('product_id');
            $table->foreign('bundle_id')->references('id')->on('bundles')->onDelete('cascade');
        });

        Schema::table('bundles', function (Blueprint $table) {
            $table->renameColumn('discount_amount', 'price');
            $table->string('image')->nullable()->after('description');
        });
    }

    public function down()
    {
        Schema::table('bundles', function (Blueprint $table) {
            $table->dropColumn('image');
            $table->renameColumn('price', 'discount_amount');
        });

        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropForeign(['bundle_id']);
            $table->dropColumn('bundle_id');
            $table->unsignedBigInteger('product_id')->nullable(false)->change();
        });
    }
}
