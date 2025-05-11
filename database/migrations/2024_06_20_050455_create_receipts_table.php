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
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_package_id');
            $table->string('payment_method', 45)->nullable();
            $table->string('receipt_number', 45)->nullable();
            $table->string('ref_number', 45)->nullable();
            $table->integer('ref_number_index');
            $table->float('amount')->nullable();
            $table->date('payment_date')->nullable();
            $table->boolean('is_email')->nullable();
            $table->boolean('is_download')->nullable();
            $table->timestamps();

            $table->foreign('user_package_id')->references('id')->on('user_packages')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receipts');
    }
};
