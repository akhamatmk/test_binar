<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeCoulumnComunityFeatureUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::drop('comunity_featured_users');
    }

    /**asd
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        //
    }
}
