<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('customer', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('phone_number')->unique();

            $table->dateTime('last_visit')->nullable();
            $table->double('point')->nullable();
            $table->date('birthday')->nullable();
            $table->string('level')->nullable();
            $table->longText('image')->nullable();
            $table->string('email')->nullable();
            $table->string('vendor')->nullable();
            $table->string('status')->nullable();
            $table->string('visit_count')->nullable();
            $table->string('amount_paid')->nullable();
            $table->string('description')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer');
    }
}
