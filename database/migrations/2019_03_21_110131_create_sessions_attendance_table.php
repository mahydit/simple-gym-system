<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSessionsAttendanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sessions_attendance', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('session_id');
            $table->foreign('session_id')->references('id')->on('sessions');	
            $table->unsignedBigInteger('attendee_id');
            $table->foreign('attendee_id')->references('id')->on('users');	
            $table->dateTime('attendance_time');
            $table->date('attendance_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sessions_attendance');
    }
}
