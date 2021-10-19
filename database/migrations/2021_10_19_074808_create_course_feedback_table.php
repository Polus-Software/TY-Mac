<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_feedback', function (Blueprint $table) {
            $table->id('course_feedback_id');
            $table->unsignedBigInteger('live_session_id');
            $table->foreign('live_session_id')->references('live_session_id')->on('live_session');
            $table->unsignedBigInteger('topic_id');
            $table->foreign('topic_id')->references('topic_id')->on('topic');
            $table->unsignedBigInteger('positive_ratings');
            $table->unsignedBigInteger('negative_ratings');
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
        Schema::dropIfExists('course_feedback');
    }
}
