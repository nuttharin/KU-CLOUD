<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Amphures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('AMPHURES', function (Blueprint $table) {
            $table->increments('amphure_id')->unsigned();
            $table->string('code', 4);
            $table->string('name_th', 150);
            $table->string('name_en', 150);
            $table->integer('province_id')->unsigned();
            $table->foreign('province_id')
                ->references('province_id')->on('Provinces')
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
        Schema::dropIfExists('Amphures');
    }
}
