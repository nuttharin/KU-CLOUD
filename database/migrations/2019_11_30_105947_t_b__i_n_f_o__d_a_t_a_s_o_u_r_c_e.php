<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TBINFODATASOURCE extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TB_INFO_DATASOURCE', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('info_id')->unsigned();
            $table->string('name','50');
            $table->integer('webservice_id')->unsigned();
            $table->integer('timeInterval')->unsigned();
            $table->string('body',200)->nullable();
            $table->string('headers',200)->nullable();
            $table->foreign('info_id')
            ->references('info_id')->on('TB_INFOGRAPHIC')
            ->onDelete('cascade');
            $table->foreign('webservice_id')
            ->references('webservice_id')->on('TB_WEBSERVICE')
            ->onDelete('cascade');
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
        Schema::dropIfExists('TB_INFO_DATASOURCE');
    }
}
