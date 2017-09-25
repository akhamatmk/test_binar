<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableComunity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comunities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('marker_id');
            $table->tinyInteger('difficulty')->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('cover_image', 255)->nullable();
            $table->string('name')->nullable();
            $table->string('info')->nullable();
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
        Schema::drop('comunities');
    }
}
