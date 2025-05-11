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
        Schema::create('package_timelines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_package_id');
            $table->foreignId('package_status_id');
            $table->foreignId('created_user_id');
            $table->text('reason')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();

            $table->foreign('user_package_id')->references('id')->on('user_packages')->restrictOnDelete();
            $table->foreign('package_status_id')->references('id')->on('package_statuses')->restrictOnDelete();
            $table->foreign('created_user_id')->references('id')->on('users')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_timelines');
    }
};
