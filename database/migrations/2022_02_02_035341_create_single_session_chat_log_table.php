<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSingleSessionChatLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('single_session_chat_log', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('session');
            $table->foreign('session')->references('id')->on('1_on_1_sessions')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('sender');
            $table->foreign('sender')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('message');
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
        Schema::dropIfExists('single_session_chat_log');
    }
}
