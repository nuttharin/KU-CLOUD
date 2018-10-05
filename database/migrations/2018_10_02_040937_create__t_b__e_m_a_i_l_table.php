<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTBEMAILTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TB_EMAIL', function (Blueprint $table) {
            $table->string('email_user',50);
            $table->integer('user_id')->unsigned();
            $table->boolean('is_verify');
            $table->timestamps();
            $table->unique(['email_user']);
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
        Schema::dropIfExists('TB_EMAIL');
    }
}
