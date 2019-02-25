<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbIotserviceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TB_IOTSERVICE', function (Blueprint $table) {

            $table->increments('iotservice_id')->unsigned();
            $table->integer('company_id')->unsigned();
            $table->foreign('company_id')
            ->references('company_id')->on('TB_COMPANY')
            ->onDelete('cascade');
            $table->string('iot_name',100);
            $table->string('iot_name_DW',100);
            $table->string('type',100);
            $table->string('alias',100);
            $table->string('API',200);
            $table->string('description',1000);
            $table->string('status',100);
            $table->string('pins_onoff',100);
            $table->string('url_onoff_input',100);
            $table->string('url_onoff_output',100);
            $table->string('dataformat',100);
            $table->text('value_cal');
            $table->text('value_gropby');
            $table->text('updatetime_input');
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
        Schema::dropIfExists('TB_IOTSERVICE');
    }
}
