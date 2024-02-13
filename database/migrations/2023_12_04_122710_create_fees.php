<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Status;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->tinyInteger('fee_type')->default(1);
            $table->decimal('amount', 10, 2);
            $table->decimal('discount', 10, 2);
            $table->tinyInteger('installment_nos')->default(1);
            $table->unsignedBigInteger('status_id')->default( Status::STATUS_ACTIVE );
            $table->unsignedBigInteger('creator_id')->nullable();


            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->foreign('creator_id')->references('id')->on('users')->onDelete('set null');

        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fees');
    }
};
