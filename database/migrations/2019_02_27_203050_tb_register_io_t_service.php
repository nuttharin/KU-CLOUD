<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TbRegisterIoTService extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TB_REGISTER_IOT_SERVICE', function (Blueprint $table) {
            $table->increments('register_iot_service')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('iotservice_id')->unsigned();
            $table->timestamps();
            $table->foreign('user_id')
                ->references('user_id')->on('TB_USERS')
                ->onDelete('cascade');
            $table->foreign('iotservice_id')
                ->references('iotservice_id')->on('TB_IOTSERVICE')
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
        Schema::dropIfExists('TB_REGISTER_IOT_SERVICE');
    }
}
