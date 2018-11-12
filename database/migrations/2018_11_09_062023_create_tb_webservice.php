<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbWebservice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TB_WEBSERVICE', function (Blueprint $table) {
            $table->increments('webservice_id')->unsigned();
            $table->integer('register_webservice_id')->unsigned();
            $table->foreign('register_webservice_id')
            ->references('register_webservice_id')->on('TB_REGISTER_WEBSERVICE')
            ->onDelete('cascade');
            $table->dateTime('update_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('TB_WEBSERVICE');
    }
}
