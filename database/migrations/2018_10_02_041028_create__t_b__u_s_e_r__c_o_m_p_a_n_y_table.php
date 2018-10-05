<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTBUSERCOMPANYTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TB_USER_COMPANY', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();;
            $table->boolean('is_user_main')->default(false);
            $table->integer('company_id')->unsigned();
            $table->timestamps();
            $table->enum('type_user',['ADMIN','NORMAL']);
            $table->foreign('user_id')
            ->references('user_id')->on('TB_USERS')
            ->onDelete('cascade');
            $table->foreign('company_id')
            ->references('company_id')->on('TB_COMPANY')
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
        Schema::dropIfExists('TB_USER_COMPANY');
    }
}
