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
        Schema::create('plan_benefit_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_id');
            $table->tinyInteger('year');
            $table->float('rate');
            $table->timestamps();

            $table->foreign('plan_id')->references('id')->on('plans')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_benefit_rates');
    }
};
