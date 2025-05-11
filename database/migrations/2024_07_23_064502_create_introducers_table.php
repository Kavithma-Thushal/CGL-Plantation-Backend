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
        Schema::create('introducers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_package_id');
            $table->string('nic', 45);
            $table->string('relationship');
            $table->text('reason')->nullable();
            $table->timestamps();

            $table->foreign('user_package_id')->references('id')->on('user_packages')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('introducers');
    }
};
