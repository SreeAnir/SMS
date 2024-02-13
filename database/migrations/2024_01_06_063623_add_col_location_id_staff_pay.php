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
        Schema::table('staff_payments', function (Blueprint $table) {
            $table->unsignedBigInteger('location_id')->after('basic_salary')->nullable(); // Foreign key column
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('staff_payments', function (Blueprint $table) {
            $table->dropColumn('location_id');
        });
    }
};
