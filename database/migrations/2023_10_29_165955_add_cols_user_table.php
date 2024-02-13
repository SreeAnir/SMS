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
        Schema::table('users', function (Blueprint $table) {
            $table->float('weight', 4, 1)->nullable()->unsigned()->after('status_id');
            $table->string('blood_group',5)->nullable()->default(null)->after('status_id');
            $table->unsignedBigInteger('country_id')->nullable()->after('status_id');
            $table->string('occupation',100)->nullable()->after('status_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('weight');
            $table->dropColumn('country_id');
            $table->dropColumn('occupation');
            $table->dropColumn('blood_group');
        });
    }
};
