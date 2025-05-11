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
        Schema::create('transfer_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('receipt_id');
            $table->foreignId('user_package_id');
            $table->timestamps();

            $table->foreign('receipt_id')->references('id')->on('receipts')->restrictOnDelete();
            $table->foreign('user_package_id')->references('id')->on('user_packages')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_packages');
    }
};
