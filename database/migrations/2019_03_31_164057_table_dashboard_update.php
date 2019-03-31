<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class TableDashboardUpdate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('TB_DASHBOARDS', function ($table) {
            $table->integer('update_by')->unsigned()->nullable();
            $table->foreign('update_by')
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
        //
    }
}
