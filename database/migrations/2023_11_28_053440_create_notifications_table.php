<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Status ;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('message')->nullable();
            $table->tinyInteger('notification_type')->nullable();
            $table->dateTime('notification_date')->nullable();
            $table->boolean('schedule_later')->default(1);
            $table->unsignedBigInteger('notifiable_id')->nullable(); // morph relationship id
            $table->string('notifiable_type')->nullable(); // morph relationship type
            $table->unsignedBigInteger('status_id')->default( Status::STATUS_PUBLISHED );
            $table->timestamps();
            $table->softDeletes();
            // Foreign key
            $table->foreign('status_id')->references('id')->on('statuses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
