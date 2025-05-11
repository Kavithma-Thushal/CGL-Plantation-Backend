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
        Schema::create('administrative_hierarchies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('administrative_level_id');
            $table->foreignId('parent_id')->nullable();
            $table->string('name', 45);
            $table->timestamps();

            $table->foreign('administrative_level_id')->references('id')->on('administrative_levels')->restrictOnDelete();
            $table->foreign('parent_id')->references('id')->on('administrative_hierarchies')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('administrative_hierarchies');
    }
};
