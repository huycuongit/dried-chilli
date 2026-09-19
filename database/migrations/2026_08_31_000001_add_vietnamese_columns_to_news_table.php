<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVietnameseColumnsToNewsTable extends Migration
{
    public function up()
    {
        Schema::table('news', function (Blueprint $table) {
            $table->string('name_vi')->nullable()->after('name');
            $table->text('description_vi')->nullable()->after('description');
            $table->longText('content_vi')->nullable()->after('content');
        });
    }

    public function down()
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn(['name_vi', 'description_vi', 'content_vi']);
        });
    }
}
