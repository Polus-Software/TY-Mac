<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_log', function (Blueprint $table) {
            $table->id('chat_log_id');
            $table->unsignedBigInteger('student_id');
            $table->foreign('student_id')->references('id')->on('users');
            $table->unsignedBigInteger('instructor_id');
            $table->foreign('instructor_id')->references('id')->on('users');
            $table->string('message');
            $table->boolean('isFromInstructor');
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
        Schema::dropIfExists('chat_log');
    }
}
