<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('projects')) {
            return;
        }
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->longText('content')->nullable();
            $table->string('avatar')->nullable();
            $table->string('website_url', 2048)->nullable();
            $table->string('category')->nullable();
            $table->string('technologies')->nullable();
            $table->string('client')->nullable();
            $table->unsignedSmallInteger('project_year')->nullable();
            $table->boolean('active')->default(true);
            $table->boolean('featured')->default(false);
            $table->unsignedInteger('position')->default(0);
            $table->timestamps();
        });
    }

    public function down() { Schema::dropIfExists('projects'); }
}
