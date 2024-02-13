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
        Schema::create('kachas', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('level')->unique();
            $table->string('label',10)->unique();
            $table->string('color',10)->unique();
            $table->smallInteger('class_count')->dafault(10);  
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kachas');
    }
};
