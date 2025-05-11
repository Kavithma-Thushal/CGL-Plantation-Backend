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
        Schema::create('designation_commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('designation_id');
            $table->float('commission');
            $table->timestamps();

            $table->foreign('designation_id')->references('id')->on('designations')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('designation_commissions');
    }
};
