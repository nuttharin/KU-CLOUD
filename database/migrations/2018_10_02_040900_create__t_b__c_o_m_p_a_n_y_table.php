<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTBCOMPANYTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TB_COMPANY', function (Blueprint $table) {
            $table->increments('company_id')->unsigned();;
            $table->string('company_name',50);
            $table->string('alias',50);
            $table->string('address',200);
            $table->string('note',100);
            $table->string('folder_log',50);
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
        Schema::dropIfExists('TB_COMPANY');
    }
}
