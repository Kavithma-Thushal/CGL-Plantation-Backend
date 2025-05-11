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
        Schema::table('plan_benefit_rates', function (Blueprint $table) {
          
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plan_benefit_rates', function (Blueprint $table) {
            $table->dropForeign(['plan_id']);
            $table->foreign('plan_id')
                ->references('id')
                ->on('plans')
                ->restrictOnDelete();
        });
    }
};
