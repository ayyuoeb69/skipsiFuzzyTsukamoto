<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSungai extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_data_input', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('data_input_id');
            $table->foreign('data_input_id')->references('id')->on('data_input');
            $table->unsignedInteger('variable_id');
            $table->foreign('variable_id')->references('id')->on('variable');
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
        Schema::dropIfExists('detail_data_input');
    }
}