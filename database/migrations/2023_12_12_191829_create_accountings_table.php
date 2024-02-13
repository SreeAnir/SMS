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
        Schema::create('accountings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->tinyInteger('acc_type');
            $table->decimal('amount', 10, 2)->nullable();
            $table->text('remarks',200)->nullable();
            
            $table->timeStamp('date')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Define foreign key constraints if needed
            $table->foreign('category_id')->references('id')->on('accounting_categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accountings');
    }
};
