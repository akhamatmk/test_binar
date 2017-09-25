<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableComunityComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comunity_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('comunity_id');
            $table->integer('user_id');
            $table->text('comment')->nullable();
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
        Schema::drop('comunity_comments');
        //
    }
}
