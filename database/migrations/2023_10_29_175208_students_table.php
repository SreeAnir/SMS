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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();
            $table->string('emergency_contact',14)->nullable();
            $table->string('residency_phone',14)->nullable();
            $table->string('po_box',8)->nullable();
            $table->string('parent_name',30)->nullable();
            $table->string('parent_company',30)->nullable();
            $table->string('parent_phone',30)->nullable();
            $table->boolean('relative_enrolled')->default(false);
            $table->string('relative_name',30)->nullable();
            $table->boolean('pre_trained_martial')->default(false);
            $table->string('pre_martial_style',30)->nullable();
            $table->json('info_source')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('students');

    }
};
