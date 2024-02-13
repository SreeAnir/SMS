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
        Schema::create('fee_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fee_id');
            $table->tinyInteger('current_installment')->default(1);
            $table->decimal('amount', 10, 2);
            $table->dateTime('payment_due_date')->nullable();
            $table->dateTime('paid_date')->nullable();

            
            $table->boolean('reminder_status')->default(false );
            $table->unsignedBigInteger('status_id')->default( Status::STATUS_UNPAID );
            $table->smallInteger('payment_mode')->nullable();
            $table->string('transaction_info',8)->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('fee_id')->references('id')->on('fees')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('statuses');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fees_log');
    }
};

