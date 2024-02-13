<?php 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBatchStudentTable extends Migration
{
    public function up()
    {
        Schema::create('batch_student', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('batch_id');
            // Add any additional columns related to the relationship if needed

            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('batch_id')->references('id')->on('batches')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('batch_student');
    }
}
