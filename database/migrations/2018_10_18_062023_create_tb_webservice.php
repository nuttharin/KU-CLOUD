<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbWebservice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TB_WEBSERVICE', function (Blueprint $table) {
            $table->increments('webservice_id')->unsigned();
            $table->string('service_name',100);
            $table->string('alias',100);
            $table->string('URL',200);
            $table->string('description',1000);
            $table->text('header_row');
            $table->dateTime('modify_date');

           
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('TB_WEBSERVICE');
    }
}
