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
        Schema::create('user_commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_package_id');
            $table->foreignId('employee_id');
            $table->foreignId('user_commission_id');
            $table->float('percentage');
            $table->string('type');
            $table->float('amount');
            $table->timestamps();

            $table->foreign('user_package_id')->references('id')->on('user_packages')->restrictOnDelete();
            $table->foreign('employee_id')->references('id')->on('employees')->restrictOnDelete();
            $table->foreign('user_commission_id')->references('id')->on('user_commissions')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_commissions');
    }
};
