<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminAuthSessionsTable extends Migration
{
    public function up()
    {
        Schema::create('admin_auth_sessions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('admin_id')->index();
            $table->string('refresh_hash', 64);
            $table->string('password_fingerprint', 64);
            $table->boolean('remember')->default(false);
            $table->timestamp('expires_at');
            $table->timestamp('revoked_at')->nullable();
            $table->timestamps();
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
        });
    }

    public function down() { Schema::dropIfExists('admin_auth_sessions'); }
}
