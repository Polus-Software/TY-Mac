<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiveFeedbacksPushRecord extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('live_feedbacks_push_record', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('topic_content_id');
            $table->foreign('topic_content_id')->references('topic_content_id')->on('topic_contents')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('topic_id');
            $table->foreign('topic_id')->references('topic_id')->on('topics')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('course_id');
            $table->foreign('course_id')->references('id')->on('courses')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('instructor');
            $table->foreign('instructor')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->boolean('is_pushed');
            $table->boolean('is_expired');
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
        Schema::dropIfExists('live_feedbacks_push_record');
    }
}
