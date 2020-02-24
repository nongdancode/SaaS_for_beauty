<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalarydefineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salarydefine', function (Blueprint $table) {
            $table->bigIncrements('id')->nullable();
            $table->string('user_id')->nullable();

            $table->string('vendor_id')->nullable();
            $table->string('salary_type')->nullable();
            $table->longText('description')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salarydefine');
    }
}
