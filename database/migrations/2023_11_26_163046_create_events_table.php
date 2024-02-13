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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title',250);
            $table->text('description')->nullable();
            $table->date('event_date')->nullable();
            $table->time('event_time')->nullable();
            $table->string('address')->nullable();
            $table->enum('visibility', [1,2])->default(1)->comments('1 public,2 private');
            $table->unsignedSmallInteger('status_id')->default(Status::STATUS_PUBLISHED);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
