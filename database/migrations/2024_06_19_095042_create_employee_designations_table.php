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
        Schema::create('employee_designations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id');
            $table->foreignId('reporting_person_id')->nullable();
            $table->foreignId('designation_id');
            $table->foreignId('base_branch_id');
            $table->foreignId('created_user_id');
            $table->string('employee_code')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->tinyInteger('status')->default(1); // 1-ACTIVE, 0-INACTIVE
            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('employees')->restrictOnDelete();
            $table->foreign('reporting_person_id')->references('id')->on('employees')->restrictOnDelete();
            $table->foreign('designation_id')->references('id')->on('designations')->restrictOnDelete();
            $table->foreign('base_branch_id')->references('id')->on('branches')->restrictOnDelete();
            $table->foreign('created_user_id')->references('id')->on('users')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_designations');
    }
};
