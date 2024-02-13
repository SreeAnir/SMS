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
        DB::statement('ALTER TABLE `users` CHANGE `rfid` `rfid` MEDIUMINT NULL DEFAULT NULL');
        DB::statement('ALTER TABLE `users` ADD UNIQUE(`rfid`)');

        Schema::create('device_logs', function (Blueprint $table) {
            $table->id();
            $table->string('direction',3);
            $table->dateTime('log_date')->nullable();
            $table->mediumInteger('rfid');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('rfid')->references('rfid')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_logs');
    }
};
