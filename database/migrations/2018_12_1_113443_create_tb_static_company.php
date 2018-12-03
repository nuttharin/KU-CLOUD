<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbStaticCompany extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TB_STATIC_COMPANY', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('static_id')->unsigned();
            $table->integer('company_id')->unsigned();
            $table->foreign('static_id')
            ->references('static_id')->on('TB_STATIC')
            ->onDelete('cascade');
            $table->foreign('company_id')
            ->references('company_id')->on('TB_COMPANY')
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
        Schema::dropIfExists('TB_STATIC_COMPANY');
    }
}
