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
        Schema::create('user_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_user_id');
            $table->foreignId('agent_id');
            $table->foreignId('branch_id');
            $table->foreignId('plan_id')->nullable();
            $table->string('job_code')->nullable();
            $table->float('land_size')->nullable();
            $table->float('land_value')->nullable();
            $table->string('payment_mode');
            $table->float('number_of_trees')->nullable();
            $table->date('benefit_term_date')->nullable();
            $table->foreignId('tree_brand_id')->nullable();
            $table->float('term')->nullable();
            $table->float('total_amount')->nullable();
            $table->string('lang', 5);
            $table->timestamps();

            $table->foreign('created_user_id')->references('id')->on('users')->restrictOnDelete();
            $table->foreign('agent_id')->references('id')->on('employees')->restrictOnDelete();
            $table->foreign('branch_id')->references('id')->on('branches')->restrictOnDelete();
            $table->foreign('plan_id')->references('id')->on('plans')->restrictOnDelete();
            $table->foreign('tree_brand_id')->references('id')->on('tree_brands')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_packages');
    }
};
