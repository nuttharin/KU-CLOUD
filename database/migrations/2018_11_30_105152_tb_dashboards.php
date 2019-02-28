<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TbDashboards extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('TB_DASHBOARDS', function (Blueprint $table) {
            $table->increments('dashboard_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('name', 50);
            $table->longText('dashboard');
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
        Schema::dropIfExists('TB_DASHBOARDS');
    }
}
