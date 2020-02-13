<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersServicesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_services_tables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_id');
            $table->string('services_id');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_services_tables');
    }
}
