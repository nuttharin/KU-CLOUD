<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbRegisterWebservice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TB_REGISTER_WEBSERVICE', function (Blueprint $table) {
            $table->increments('register_webservice_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
            ->references('user_id')->on('TB_USERS')
            ->onDelete('cascade');
            $table->integer('webservice_id')->unsigned();
            $table->foreign('webservice_id')
            ->references('webservice_id')->on('TB_WEBSERVICE')
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
        //
        Schema::dropIfExists('TB_REGISTER_WEBSERVICE');
    }
}
