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
        Schema::table('batch_student', function (Blueprint $table) {
            Schema::rename('batch_student', 'batch_students');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('batch_student', function (Blueprint $table) {
            Schema::rename('batch_students', 'batch_student');
        });
    }
};
