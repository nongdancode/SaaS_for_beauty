<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('service_name')->nullable();
            $table->double('price')->nullable();
            $table->string( 'description')->nullable();
            $table->longText( 'image')->nullable();
            $table->string( 'vendor')->nullable();
            $table->double('duration')->nullable();
            $table->string( 'user_ids')->nullable();



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service');
    }
}
