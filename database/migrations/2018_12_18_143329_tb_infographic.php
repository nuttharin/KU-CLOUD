<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TbInfographic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TB_INFOGRAPHIC', function (Blueprint $table) {
            $table->increments('info_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('name', 50);
            $table->longText('info_data')->nullable();
            $table->string('created_by',50);
            $table->string('updated_by',50);
            $table->timestamps();
            $table->foreign('user_id')
                ->references('user_id')->on('TB_USERS')
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
        Schema::dropIfExists('tb_infographic');
    }
}
