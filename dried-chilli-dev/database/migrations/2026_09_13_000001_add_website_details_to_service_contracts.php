<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWebsiteDetailsToServiceContracts extends Migration
{
    public function up()
    {
        Schema::table('service_contracts', function (Blueprint $table) {
            $table->json('website_details')->nullable();
        });
    }

    public function down()
    {
        Schema::table('service_contracts', function (Blueprint $table) {
            $table->dropColumn('website_details');
        });
    }
}
