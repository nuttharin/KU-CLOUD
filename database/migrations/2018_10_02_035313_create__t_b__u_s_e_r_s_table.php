<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTBUSERSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TB_USERS', function (Blueprint $table) {
            $table->increments('user_id')->unsigned();
            $table->string('password',100);
            $table->string('fname',50);
            $table->string('lname',50);
            $table->boolean('block')->default(false);
            $table->boolean('online')->default(false);
            $table->string('socketId',100)->nullable();
            $table->enum('type_user',['ADMIN','COMPANY','CUSTOMER']);
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
        Schema::dropIfExists('TB_USERS');
    }
}
