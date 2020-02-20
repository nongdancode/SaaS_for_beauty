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
            $table->string('service_id')->nullable();
            $table->string('user_id')->nullable();
            $table->string('cus_id')->nullable();
            $table->double( 'income')->nullable();
            $table->string( 'vendor_id')->nullable();
            $table->string( 'description')->nullable();
            $table->dateTime( 'start_time')->nullable();
            $table->dateTime( 'end_time')->nullable();




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
