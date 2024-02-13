<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
    {
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('location_id'); // Foreign key column
            $table->string('batch_name',15);
            $table->string('batch_time',15);
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
            $table->tinyInteger('status_id')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('batches');
    }
};
