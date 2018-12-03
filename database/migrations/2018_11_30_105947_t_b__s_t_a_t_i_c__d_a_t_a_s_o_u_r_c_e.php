<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TBSTATICDATASOURCE extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TB_STATIC_DATASOURCE', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('static_id')->unsigned();
            $table->string('name','50');
            $table->integer('webservice_id')->unsigned();
            $table->string('body',200)->nullable();
            $table->string('headers',200)->nullable();
            $table->foreign('static_id')
            ->references('static_id')->on('TB_STATIC')
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
        Schema::dropIfExists('TB_STATIC_DATASOURCE');
    }
}
