<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupserviceServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groupservice_service', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('service_id');
            $table->string('groupservice_id');
            $table->string('vendor');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groupservice_service');
    }
}
