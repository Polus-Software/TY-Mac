<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceTrackerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_tracker', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student');
            $table->foreign('student')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('live_session_id');
            $table->foreign('live_session_id')->references('live_session_id')->on('live_sessions')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps('start_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendance_tracker');
    }
}
