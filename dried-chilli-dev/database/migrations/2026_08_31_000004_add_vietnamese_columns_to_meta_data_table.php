<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVietnameseColumnsToMetaDataTable extends Migration
{
    public function up()
    {
        Schema::table('meta_data', function (Blueprint $table) {
            $table->string('title_vi')->nullable()->after('title');
        });
    }

    public function down()
    {
        Schema::table('meta_data', function (Blueprint $table) {
            $table->dropColumn('title_vi');
        });
    }
}
