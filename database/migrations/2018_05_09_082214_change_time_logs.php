<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTimeLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('time_logs', function ($table){
//            $table->dropForeign('time_logs_project_id_foreign');
            $table->dropColumn('task_name');
            $table->string('task_description', 255)->nullable()->change();
            $table->integer('project_id')->nullable()->change();
            $table->renameColumn('task_description', 'reason');
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
