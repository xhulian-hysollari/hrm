<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function ($table){
            $table->string('father_name')->nullable();
            $table->string('matricola')->nullable()->unique();
            $table->string('id_card')->nullable()->unique();
            $table->string('birthplace')->nullable();
            $table->string('address')->nullable();
            $table->string('education_title')->nullable();
            $table->string('profession')->nullable();
            $table->string('contract_type')->nullable();
            $table->string('bank_account')->nullable();
            $table->integer('is_active')->default(1);
            $table->string('personal_email')->nullable()->unique();
            $table->dateTime('start_date')->nullable();
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
