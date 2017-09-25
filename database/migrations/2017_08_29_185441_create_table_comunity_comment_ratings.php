<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableComunityCommentRatings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comunity_comment_ratings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('comunity_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('rating')->nullable();
            $table->timestamps();
            $table->dateTime('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('comunity_comment_ratings');
    }
}
