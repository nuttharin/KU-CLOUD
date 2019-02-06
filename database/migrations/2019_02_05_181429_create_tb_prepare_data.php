<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbPrepareData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('TB_DATA_ANALYSIS');
        Schema::create('TB_DATA_ANALYSIS', function (Blueprint $table) {
            $table->increments('data_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('name', 50);
            $table->string('path_file', '255')->nullable();
            $table->boolean('is_success')->default(false);
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
        Schema::dropIfExists('TB_DATA_ANALYSIS');
    }
}
