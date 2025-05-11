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
        Schema::dropIfExists('users');
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('avatar_media_id')->nullable();
            $table->string('username')->unique();
            $table->string('password')->nullable();
            $table->string('nic', 45);
            $table->date('dob')->nullable();
            $table->boolean('has_system_access')->default(0);
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('avatar_media_id')->references('id')->on('media')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
