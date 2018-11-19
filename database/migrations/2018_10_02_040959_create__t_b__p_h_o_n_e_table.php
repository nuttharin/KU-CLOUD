<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTBPHONETable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TB_PHONE', function (Blueprint $table) {
            $table->string('phone_user',10);
            $table->integer('user_id')->unsigned();
            $table->boolean('is_verify')->default(false);
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
            $table->unique(['phone_user']);
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
        Schema::dropIfExists('TB_PHONE');
    }
}
