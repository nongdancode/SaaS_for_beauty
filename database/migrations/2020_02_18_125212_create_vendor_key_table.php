<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorKeyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_key', function (Blueprint $table) {
            $table->bigIncrements('id')->nullable();
            $table->string('vendor_id')->nullable();
            $table->string('key_type')->nullable();
            $table->string('key1')->nullable();
            $table->string('key3')->nullable();
            $table->string('key4')->nullable();
            $table->string('key5')->nullable();
            $table->string('key6')->nullable();
            $table->string('key7')->nullable();
            $table->string('key8')->nullable();
            $table->string('key9')->nullable();
            $table->string('description')->nullable();
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
        Schema::dropIfExists('vendor_key');
    }
}
