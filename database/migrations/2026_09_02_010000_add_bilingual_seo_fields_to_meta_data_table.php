<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $addDescriptionVi = !Schema::hasColumn('meta_data', 'description_vi');
        $addKeywordsVi = !Schema::hasColumn('meta_data', 'key_words_vi');

        if ($addDescriptionVi || $addKeywordsVi) {
            Schema::table('meta_data', function (Blueprint $table) use ($addDescriptionVi, $addKeywordsVi) {
                if ($addDescriptionVi) {
                    $table->string('description_vi', 1024)->nullable()->after('description');
                }
                if ($addKeywordsVi) {
                    $table->string('key_words_vi', 1024)->nullable()->after('key_words');
                }
            });
        }
    }

    public function down(): void
    {
        $dropDescriptionVi = Schema::hasColumn('meta_data', 'description_vi');
        $dropKeywordsVi = Schema::hasColumn('meta_data', 'key_words_vi');

        if ($dropDescriptionVi || $dropKeywordsVi) {
            Schema::table('meta_data', function (Blueprint $table) use ($dropDescriptionVi, $dropKeywordsVi) {
                if ($dropKeywordsVi) {
                    $table->dropColumn('key_words_vi');
                }
                if ($dropDescriptionVi) {
                    $table->dropColumn('description_vi');
                }
            });
        }
    }
};