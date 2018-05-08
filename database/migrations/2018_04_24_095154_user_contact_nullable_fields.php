<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserContactNullableFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_contact_details', function ($table){
            $table->string('street_1')->nullable()->change();
            $table->string('city')->nullable()->change();
            $table->string('zip')->nullable()->change();
            $table->string('country')->nullable()->change();
            $table->string('phone1', 20)->nullable()->change();
            $table->string('phone2', 20)->nullable()->change();
            $table->string('phone3', 20)->nullable()->change();
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
