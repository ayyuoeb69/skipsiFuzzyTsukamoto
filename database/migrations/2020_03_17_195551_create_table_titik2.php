<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTitik2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('titik', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titikx',20);
            $table->string('titiky',20);
            $table->unsignedInteger('himpunan_id');
            $table->integer('urutan');
            $table->foreign('himpunan_id')->references('id')->on('himpunan');
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
        Schema::dropIfExists('table_titik2');
    }
}
