<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableHimpunan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('himpunan', function (Blueprint $table) {
            $table->increments('id');
            $table->string('unique_code')->unique();
            $table->string('nama_himpunan');
            $table->string('fungsi');
            $table->integer('urutan');
            $table->integer('jumlah_titik');
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
        Schema::dropIfExists('himpunan');
    }
}
