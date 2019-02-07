<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbAnalysisJob extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('TB_ANALYSIS_JOBS');
        Schema::create('TB_ANALYSIS_JOBS', function (Blueprint $table) {
            $table->increments('job_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('data_id')->unsigned();
            $table->string('name', 50);
            $table->string('path_file', '255')->nullable();
            $table->boolean('is_success')->default(false);
            $table->timestamps();
            $table->foreign('data_id')
                ->references('data_id')->on('TB_DATA_ANALYSIS')
                ->onDelete('cascade');
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
        Schema::dropIfExists('TB_ANALYSIS_JOBS');
    }
}
