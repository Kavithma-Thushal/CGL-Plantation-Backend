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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_id');
            $table->foreignId('quotation_request_id');
            $table->string('quotation_number', 45)->nullable();//it's nullable because quotation number will be updated after creating the quotation
            $table->float('duration')->default(12);//default 1 year of duration
            $table->float('amount');
            $table->date('expire_date');
            $table->timestamps();

            $table->foreign('plan_id')->references('id')->on('plans')->restrictOnDelete();
            $table->foreign('quotation_request_id')->references('id')->on('quotation_requests')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
