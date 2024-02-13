<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('device_logs', function (Blueprint $table) {
            // DB::statement(' ALTER TABLE `device_logs` DROP FOREIGN KEY `device_logs_rfid_foreign`; ALTER TABLE `device_logs` ADD CONSTRAINT `device_logs_rfid_foreign` FOREIGN KEY (`rfid`) REFERENCES `users`(`rfid`) ON DELETE CASCADE ON UPDATE CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('device_logs', function (Blueprint $table) {
            //
        });
    }
};
