<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookingturns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('service_id');
            $table->string('user_id');
            $table->string('cus_id');
            $table->double( 'income');
            $table->string( 'vendor_id');
            $table->string( 'description');
            $table->dateTime( 'start_time');
            $table->dateTime( 'end_time');




        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookingturns');
    }
}
