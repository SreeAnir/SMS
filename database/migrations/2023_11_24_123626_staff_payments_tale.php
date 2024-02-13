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
        Schema::create('staff_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');  
            $table->decimal('basic_salary', 10, 2);
            $table->decimal('hra', 10, 2);
            $table->decimal('other_allowance', 10, 2)->nullable();
            $table->string('note',500 )->nullable();
            $table->unsignedSmallInteger('status_id')->default(Status::STATUS_ACTIVE);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_payments');
    }
};
