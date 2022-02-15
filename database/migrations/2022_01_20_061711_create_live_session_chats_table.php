<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiveSessionChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('live_session_chats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('live_session')->nullable();
            $table->foreign('live_session')->references('live_session_id')->on('live_sessions')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('student')->nullable();
            $table->foreign('student')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('message', 2000);
            $table->string('user_name');
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
        Schema::dropIfExists('live_session_chats');
    }
}
