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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_template_id');
            $table->string('name', 100);
            $table->string('code', 10);
            $table->float('duration');
            $table->float('minimum_amount');
            $table->float('profit_per_month')->nullable();
            $table->float('benefit_per_month')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('plan_template_id')->references('id')->on('plan_templates')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
