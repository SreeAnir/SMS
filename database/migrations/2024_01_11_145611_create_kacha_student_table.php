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
        Schema::create('kacha_students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('kacha_id'); // Foreign key column
            $table->unsignedBigInteger('creator_id');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('creator_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('kacha_id')->references('id')->on('kachas')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kacha_student');
    }
};
