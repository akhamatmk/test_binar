<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateaTableComunityFeatureUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comunity_featured_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('place_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->timestamps();
            $table->dateTime('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('comunity_featured_users');
    }
}
