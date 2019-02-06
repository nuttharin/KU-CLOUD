<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string('username', 50);
            $table->string('password', 100);
            $table->string('fname', 50);
            $table->string('lname', 50);
            $table->boolean('block')->default(false);
            $table->boolean('online')->default(false);
            $table->string('socketId', 100)->nullable();
            $table->string('img_profile', 100)->default('default-profile.jpg')->nullable();
            $table->enum('type_user', ['ADMIN', 'COMPANY', 'CUSTOMER']);
            $table->timestamps();
            $table->unique(['username']);

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
