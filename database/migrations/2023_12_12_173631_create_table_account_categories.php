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
        Schema::create('accounting_categories', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('category_type')->nullable();
            $table->string('category_label',120)->nullable();
            $table->string('category_description',150)->nullable();
            $table->unsignedBigInteger('status_id')->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('status_id')->references('id')->on('statuses');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounting_categories');
    }
};
