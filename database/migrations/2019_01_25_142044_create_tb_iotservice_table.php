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
            $table->string('url',1000)->nullable();
            $table->string('type',100);
            $table->string('alias',100);
            $table->string('description',1000)->nullable();
            $table->string('status',100);
            $table->string('dataOutput',100)->nullable();
            $table->string('strJson',100)->nullable();
            $table->string('dataformat',100)->nullable();
            $table->text('value_cal')->nullable();
            $table->text('value_gropby')->nullable();
            $table->text('updatetime_input')->nullable();
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
