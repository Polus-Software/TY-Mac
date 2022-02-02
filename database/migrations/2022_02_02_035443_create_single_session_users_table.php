<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSingleSessionUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('single_session_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('session');
            $table->foreign('session')->references('id')->on('1_on_1_sessions')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('student');
            $table->foreign('student')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('instructor');
            $table->foreign('instructor')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->boolean('student_present')->nullable();
            $table->boolean('instructor_present')->nullable();
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
        Schema::dropIfExists('single_session_users');
    }
}
