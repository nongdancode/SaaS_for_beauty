<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ScheduleTask extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Scheduletask', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->date('day')->nullable();
            $table->string('task')->nullable();
            $table->string('services_ids')->nullable();
            $table->string('vendor')->nullable();
            $table->string('user_ids')->nullable();
            $table->string('status')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Scheduletask');
    }
}
