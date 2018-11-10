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
            $table->string('service name',100);
            $table->string('alias',100);
            $table->string('URL',200);
            $table->dateTime('create_date');
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
