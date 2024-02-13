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
        Schema::table('kachas', function (Blueprint $table) {
            $table->string('next_label',20)->after('label')->nullable();
            $table->smallInteger('months')->after('next_label')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kachas', function (Blueprint $table) {
            $table->dropColumn('next_label');
            $table->dropColumn('months');
        });
    }
};
