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
        Schema::create('package_customer_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_package_id');
            $table->foreignId('customer_id');
            $table->foreignId('country_id')->nullable();
            $table->foreignId('race_id')->nullable();
            $table->foreignId('nationality_id')->nullable();
            $table->foreignId('occupation_id')->nullable();
            $table->foreignId('bank_account_id')->nullable();
            $table->string('mobile_number');
            $table->string('landline_number')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->text('address_si')->nullable();
            $table->text('name_with_initial_si')->nullable();
            $table->text('family_name_si')->nullable();
            $table->text('first_name_si')->nullable();
            $table->text('middle_name_si')->nullable();
            $table->text('last_name_si')->nullable();
            $table->timestamps();

            $table->foreign('user_package_id')->references('id')->on('user_packages')->restrictOnDelete();
            $table->foreign('customer_id')->references('id')->on('customers')->restrictOnDelete();
            $table->foreign('country_id')->references('id')->on('countries')->restrictOnDelete();
            $table->foreign('race_id')->references('id')->on('races')->restrictOnDelete();
            $table->foreign('nationality_id')->references('id')->on('nationalities')->restrictOnDelete();
            $table->foreign('occupation_id')->references('id')->on('occupations')->restrictOnDelete();
            $table->foreign('bank_account_id')->references('id')->on('bank_accounts')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_customer_details');
    }
};
