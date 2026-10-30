<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeContactPhoneCountryNullable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('contacts') && Schema::hasColumn('contacts', 'phone_country')) {
            Schema::table('contacts', function (Blueprint $table) {
                $table->string('phone_country', 8)->nullable()->default(null)->change();
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('contacts') && Schema::hasColumn('contacts', 'phone_country')) {
            Schema::table('contacts', function (Blueprint $table) {
                $table->string('phone_country', 8)->default('+84')->nullable(false)->change();
            });
        }
    }
}