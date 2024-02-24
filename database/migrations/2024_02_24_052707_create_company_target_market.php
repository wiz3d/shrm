<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('company_target_market', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('target_market_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('target_market_id')->references('id')->on('target_markets')->onDelete('cascade');
            $table->primary(['company_id', 'target_market_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_target_market');   Schema::table('company_target_market', function (Blueprint $table) {
        $table->dropForeign(['company_id']);
        $table->dropForeign(['target_market_id']);
    });

        Schema::dropIfExists('company_target_market');
    }
};
