<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterLiveSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('live_sessions', function (Blueprint $table) {
            $table->unsignedBigInteger('batch_id');
            $table->foreign('batch_id')->references('id')->on('cohort_batches')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('instructor');
            $table->foreign('instructor')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
