<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFebFieldsToContactsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('contacts')) {
            return;
        }

        Schema::table('contacts', function (Blueprint $table) {
            if (!Schema::hasColumn('contacts', 'full_name')) $table->string('full_name')->nullable()->after('id');
            if (!Schema::hasColumn('contacts', 'email')) $table->string('email')->nullable()->after('full_name');
            if (!Schema::hasColumn('contacts', 'phone')) $table->string('phone', 30)->nullable()->after('email');
            if (!Schema::hasColumn('contacts', 'company')) $table->string('company')->nullable()->after('phone');
            if (!Schema::hasColumn('contacts', 'project_type')) $table->string('project_type', 50)->nullable()->after('company');
            if (!Schema::hasColumn('contacts', 'budget')) $table->string('budget', 50)->nullable()->after('project_type');
            if (!Schema::hasColumn('contacts', 'message')) $table->text('message')->nullable()->after('budget');
            if (!Schema::hasColumn('contacts', 'source')) $table->string('source', 100)->default('home-book-a-call')->after('message');
            if (!Schema::hasColumn('contacts', 'status')) $table->string('status', 30)->default('new')->index()->after('source');
            if (!Schema::hasColumn('contacts', 'ip_address')) $table->string('ip_address', 45)->nullable()->after('status');
            if (!Schema::hasColumn('contacts', 'user_agent')) $table->string('user_agent', 1000)->nullable()->after('ip_address');
        });
    }

    public function down()
    {
        if (!Schema::hasTable('contacts')) {
            return;
        }

        Schema::table('contacts', function (Blueprint $table) {
            $columns = ['full_name', 'email', 'phone', 'company', 'project_type', 'budget', 'message', 'source', 'status', 'ip_address', 'user_agent'];
            $existing = array_values(array_filter($columns, fn ($column) => Schema::hasColumn('contacts', $column)));
            if ($existing) $table->dropColumn($existing);
        });
    }
}