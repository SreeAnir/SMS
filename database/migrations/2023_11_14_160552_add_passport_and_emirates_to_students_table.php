<?php 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPassportAndEmiratesToStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('passport_number')->nullable();
            $table->string('emirates_id')->nullable();
            $table->date('passport_expiry')->nullable();
            $table->date('emirates_id_expiry')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('passport_number');
            $table->dropColumn('emirates_id');
            $table->dropColumn('passport_expiry');
            $table->dropColumn('emirates_id_expiry');
        });
    }
}
