<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbStaticCustomer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TB_STATIC_CUSTOMER', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('static_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->foreign('static_id')
            ->references('static_id')->on('TB_STATIC')
            ->onDelete('cascade');
            $table->foreign('user_id')
            ->references('user_id')->on('TB_USERS')
            ->onDelete('cascade');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('TB_STATIC_CUSTOMER');
    }
}
