<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeTablePlacePhotos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('place_photos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('place_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('url', 255)->nullable();
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
        Schema::drop('place_photos');
    }
}
