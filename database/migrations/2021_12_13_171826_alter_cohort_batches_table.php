<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCohortBatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cohort_batches', function (Blueprint $table) {
            //
            $table->string('title');
            $table->date('end_date');
            $table->string('time_zone');
            $table->unsignedBigInteger('cohort_notification_id');
            $table->foreign('cohort_notification_id')->references('id')->on('cohort_notification')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cohort_batches', function (Blueprint $table) {
            //
        });
    }
}
