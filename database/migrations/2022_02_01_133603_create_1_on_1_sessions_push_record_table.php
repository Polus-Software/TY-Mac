<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create1On1SessionsPushRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('1_on_1_sessions_push_record', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('topic_content_id');
            $table->foreign('topic_content_id')->references('topic_content_id')->on('topic_contents')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('student');
            $table->foreign('student')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->boolean('is_presenting');
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
        Schema::dropIfExists('1_on_1_sessions_push_record');
    }
}
