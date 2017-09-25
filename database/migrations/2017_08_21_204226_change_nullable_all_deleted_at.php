<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeNullableAllDeletedAt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function($table) {
            $table->dateTime('deleted_at')->nullable()->change();
        });

        Schema::table('featured_users', function($table) {
            $table->dateTime('deleted_at')->nullable()->change();
        });

        Schema::table('place_photos', function($table) {
            $table->dateTime('deleted_at')->nullable()->change();
        });

         Schema::table('places', function($table) {
            $table->dateTime('deleted_at')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function($table) {
            $table->dropColumn('deleted_at');
        });

        Schema::table('featured_users', function($table) {
            $table->dropColumn('deleted_at');
        });

        Schema::table('place_photos', function($table) {
            $table->dropColumn('deleted_at');
        });

        Schema::table('places', function($table) {
            $table->dropColumn('deleted_at');
        });
    }
}
