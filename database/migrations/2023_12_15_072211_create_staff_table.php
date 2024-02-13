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
        Schema::create('staffs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();
            $table->text('present_address')->nullable();
            $table->text('permanent_address')->nullable();
            $table->string('alt_phone_number')->nullable();
            $table->string('alt_phone_code')->default(1);
            $table->string('home_phone_number')->nullable();
            $table->string('home_phone_code')->default(1);
            $table->string('emergency_phone_number')->nullable();
            $table->string('emergency_phone_code')->default(1);
            $table->string('emergency_contact_person')->nullable();
            $table->string('emergency_contact_person_relation')->nullable();
            $table->string('visa_uid')->nullable();
            $table->string('visa_file_no')->nullable();
            $table->date('visa_issue_date')->nullable();
            $table->date('visa_expiry_date')->nullable();
            $table->string('passport_number')->nullable();
            $table->date('passport_issue_date')->nullable();
            $table->date('passport_expiry')->nullable();
            $table->string('emirates_id')->nullable();
            $table->date('emirates_id_expiry')->nullable();
            $table->string('iban_no')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_branch')->nullable();
            $table->string('insurance_provider')->nullable();
            $table->string('policy_no')->nullable();
            $table->string('policy_plan')->nullable();
            $table->date('policy_expiry_date')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('staffs', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('staffs');

    }
};
