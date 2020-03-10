<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternalTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internalTransaction', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('invoice_number')->nullable();
            $table->double('discount')->nullable();
            $table->string('status')->nullable();
            $table->string('type_transaction')->nullable();
            $table->string('type_charge')->nullable();
            $table->double('amount')->nullable();
            $table->string('employee_id')->nullable();
            $table->string('vendor_id')->nullable();
            $table->string('cus_id')->nullable();
            $table->string('service_id')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('internalTransaction');
    }
}
