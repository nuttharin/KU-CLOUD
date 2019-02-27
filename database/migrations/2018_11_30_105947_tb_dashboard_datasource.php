<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TbDashboardDatasource extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TB_DASHBOARD_DATASOURCES', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dashboard_id')->unsigned();
            $table->string('name', '50');
            $table->integer('webservice_id')->unsigned();
            $table->integer('timeInterval')->unsigned();
            $table->string('body', 200)->nullable();
            $table->string('headers', 200)->nullable();
            $table->foreign('dashboard_id')
                ->references('dashboard_id')->on('TB_DASHBOARDS')
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
         Schema::dropIfExists('TB_DASHBOARD_DATASOURCES');
    }
}
