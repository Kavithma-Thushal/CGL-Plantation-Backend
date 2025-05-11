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
        Schema::table('quotation_requests', function (Blueprint $table) {
            $table->foreignId('agent_id')->nullable();
            $table->foreign('agent_id')->references('id')->on('employees')->restrictOnDelete();
            $table->foreignId('employee_branch_id')->nullable();
            $table->foreign('employee_branch_id')->references('id')->on('employee_branches')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quotation_requests', function (Blueprint $table) {
            $table->dropForeign(['agent_id']);
            $table->dropForeign(['employee_branch_id']);
            $table->dropColumn(['agent_id', 'employee_branch_id']);
        });
    }
};
