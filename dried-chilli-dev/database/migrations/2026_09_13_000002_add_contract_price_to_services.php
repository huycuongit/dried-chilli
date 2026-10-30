<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class AddContractPriceToServices extends Migration
{
    public function up() { Schema::table('services', function (Blueprint $table) { $table->decimal('contract_price', 15, 2)->nullable(); }); }
    public function down() { Schema::table('services', function (Blueprint $table) { $table->dropColumn('contract_price'); }); }
}
