<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('news')) {
            Schema::create('news', function (Blueprint $table) {
                $table->id();
                $table->string('name')->nullable()->comment('Tên tin tức');
                $table->string('slug')->nullable()->comment('URL chi tiết tin tức');
                $table->text('avatar')->nullable()->comment('Ảnh tượng trưng cho 1 tin tức');
                $table->text('description')->nullable()->comment('Mô tả sơ bộ tin tức');
                $table->longText('content')->nullable()->comment('Nội dung tin tức');
                $table->timestamp('publish_time')->nullable()->comment('Thời gian phát hành');
                $table->tinyInteger('active')->default(1)->comment('0: Không hoạt động; 1: Hoạt động');
                $table->tinyInteger('position')->default(0)->comment('Thứ tự ưu tiên');
                $table->tinyInteger('active_publish')->default(0);
                $table->integer('views')->default(0);
                $table->foreignId('created_by_id')->nullable()->constrained('admins')->nullOnDelete();
                $table->foreignId('updated_by_id')->nullable()->constrained('admins')->nullOnDelete();
                $table->timestamps();
            });
            return;
        }

        Schema::table('news', function (Blueprint $table) {
            if (!Schema::hasColumn('news', 'name')) $table->string('name')->nullable()->after('id');
            if (!Schema::hasColumn('news', 'slug')) $table->string('slug')->nullable()->after('name');
            if (!Schema::hasColumn('news', 'avatar')) $table->text('avatar')->nullable()->after('slug');
            if (!Schema::hasColumn('news', 'description')) $table->text('description')->nullable()->after('avatar');
            if (!Schema::hasColumn('news', 'content')) $table->longText('content')->nullable()->after('description');
            if (!Schema::hasColumn('news', 'publish_time')) $table->timestamp('publish_time')->nullable()->after('content');
            if (!Schema::hasColumn('news', 'active')) $table->tinyInteger('active')->default(1)->after('publish_time');
            if (!Schema::hasColumn('news', 'position')) $table->tinyInteger('position')->default(0)->after('active');
            if (!Schema::hasColumn('news', 'active_publish')) $table->tinyInteger('active_publish')->default(0)->after('position');
            if (!Schema::hasColumn('news', 'views')) $table->integer('views')->default(0)->after('active_publish');
            if (!Schema::hasColumn('news', 'created_by_id')) $table->foreignId('created_by_id')->nullable()->after('views')->constrained('admins')->nullOnDelete();
            if (!Schema::hasColumn('news', 'updated_by_id')) $table->foreignId('updated_by_id')->nullable()->after('created_by_id')->constrained('admins')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('news');
    }
}