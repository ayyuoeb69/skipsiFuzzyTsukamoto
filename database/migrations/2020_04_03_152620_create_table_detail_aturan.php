<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDetailAturan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_aturan', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('aturan_id');
            $table->foreign('aturan_id')->references('id')->on('aturan');
            $table->unsignedInteger('himpunan_id');
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
        Schema::dropIfExists('detail_aturan');
    }
}
