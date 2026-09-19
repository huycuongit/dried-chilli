<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('meta_data', 'description_vi')) {
            Schema::table('meta_data', function (Blueprint $table) {
                $table->dropColumn('description_vi');
            });
        }
    }

    public function down(): void
    {
        if (!Schema::hasColumn('meta_data', 'description_vi')) {
            Schema::table('meta_data', function (Blueprint $table) {
                $table->string('description_vi', 1024)->nullable()->after('description');
            });
        }
    }
};
