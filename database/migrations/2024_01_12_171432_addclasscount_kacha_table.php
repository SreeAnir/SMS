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
        Schema::table('kacha_students', function (Blueprint $table) {
            $table->smallInteger('class_count')->after('kacha_id')->dafault(0); // Foreign key column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kacha_students', function (Blueprint $table) {
            $table->dropColumn('class_count');
        });
    }
};
