<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableKoordinateSungai extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koordinate_sungai', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('sungai_id');
            $table->foreign('sungai_id')->references('id')->on('sungai');
            $table->string('lat_koor_dasar',30);
            $table->string('lng_koor_dasar',30);
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
        Schema::dropIfExists('koordinate_sungai');
    }
}
