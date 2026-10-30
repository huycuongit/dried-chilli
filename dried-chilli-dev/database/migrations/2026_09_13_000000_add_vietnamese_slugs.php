<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class AddVietnameseSlugs extends Migration
{
    public function up()
    {
        foreach (['services', 'news'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->string('slug_vi')->nullable()->unique();
            });

            DB::table($tableName)->orderBy('id')->chunkById(200, function ($rows) use ($tableName) {
                foreach ($rows as $row) {
                    if (trim((string) $row->name_vi) === '') {
                        continue;
                    }
                    $base = Str::slug($row->name_vi, '-', 'vi') ?: 'bai-viet';
                    $base = Str::substr($base, 0, 240);
                    $slug = $base;
                    $suffix = 1;
                    while (DB::table($tableName)->where('slug_vi', $slug)->exists()) {
                        $slug = $base . '-' . $suffix++;
                    }
                    DB::table($tableName)->where('id', $row->id)->update(['slug_vi' => $slug]);
                }
            });
        }
    }

    public function down()
    {
        foreach (['services', 'news'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropUnique(['slug_vi']);
                $table->dropColumn('slug_vi');
            });
        }
    }
}
