<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ADDRESSCOMPANY extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ADDRESS_COMPANY', function (Blueprint $table) {
            $table->increments('address_id');
            $table->integer('company_id')->unsigned();
            $table->string('address_detail','200');
            $table->string('district_id', 6);
            $table->integer('amphure_id')->unsigned();
            $table->integer('province_id')->unsigned();
            $table->foreign('company_id')
            ->references('company_id')->on('TB_COMPANY')
            ->onDelete('cascade');
            $table->foreign('district_id')
            ->references('district_id')->on('Districts')
            ->onDelete('cascade');
            $table->foreign('amphure_id')
            ->references('amphure_id')->on('Amphures')
            ->onDelete('cascade');
            $table->foreign('province_id')
            ->references('province_id')->on('Provinces')
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
        Schema::dropIfExists('ADDRESSCOMPANY');
    }
}
