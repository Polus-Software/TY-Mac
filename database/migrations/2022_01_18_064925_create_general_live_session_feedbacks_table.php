<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralLiveSessionFeedbacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_live_session_feedbacks', function (Blueprint $table) {
            $table->id();
            $table->integer('question_1')->nullable();
            $table->integer('question_2')->nullable();
            $table->integer('question_3')->nullable();
            $table->string('other_feedback')->nullable();
            $table->unsignedBigInteger('live_session')->nullable();
            $table->foreign('live_session')->references('live_session_id')->on('live_sessions')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('student')->nullable();
            $table->foreign('student')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('general_live_session_feedbacks');
    }
}
