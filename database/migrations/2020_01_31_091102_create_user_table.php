<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('name')->nullable();
            $table->string('user_name')->nullable();
            $table->string('password')->nullable();

            $table->string('phone_number')->nullable();
            $table->rememberToken();

            $table->dateTime('last_visit')->nullable();
            $table->double('point')->nullable();
            $table->date('birthday')->nullable();
            $table->string('role')->nullable();
            $table->string('status')->nullable();
            $table->longText('image')->nullable();
            $table->string('email')->nullable();
            $table->dateTime('last_login')->nullable();

            $table->string('vendor')->nullable();
            $table->string('token')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
}
