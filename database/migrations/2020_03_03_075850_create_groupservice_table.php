<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupserviceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groupservice', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('group_name')->nullable();
            $table->string('service_id')->nullable();
            $table->string('vendor')->nullable();



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groupservice');
    }
}
