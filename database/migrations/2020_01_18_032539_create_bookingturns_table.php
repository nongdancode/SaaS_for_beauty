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
            $table->string('service_list');
            $table->double('cost');
            $table->string( 'description');
            $table->dateTime( 'time_book');



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
