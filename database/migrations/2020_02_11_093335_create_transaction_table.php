<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction', function (Blueprint $table) {
            $table->bigIncrements('id')->nullable();
            $table->timestamps();
            $table->string('card_number')->nullable();
            $table->string('card_type')->nullable();
            $table->string('status')->nullable();
            $table->string('name_on_card')->nullable();
            $table->double('amount')->nullable();
            $table->dateTime('charge_at')->nullable();
            $table->string('vendor')->nullable();
            $table->string('type_charge')->nullable();
            $table->string('user_phone')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction');
    }
}
