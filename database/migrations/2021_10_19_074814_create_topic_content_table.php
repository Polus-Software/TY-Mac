<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopicContentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topic_contents', function (Blueprint $table) {
            $table->id('topic_content_id');
            $table->unsignedBigInteger('topic_id');
            $table->foreign('topic_id')->references('topic_id')->on('topics')->onUpdate('cascade')->onDelete('cascade');
            $table->string('topic_title');
            $table->string('description');
            $table->string('content_type');
            $table->string('document');
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
        Schema::dropIfExists('topic_content');
    }
}
