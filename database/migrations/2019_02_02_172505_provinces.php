<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Provinces extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Provinces', function (Blueprint $table) {
            $table->increments('province_id')->unsigned();
            $table->string('code', 2);
            $table->string('name_th', 150);
            $table->string('name_en', 150);
            $table->integer('geography_id')->unsigned();
            $table->foreign('geography_id')
                ->references('geography_id')->on('Geographies')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Provinces');
    }
}
