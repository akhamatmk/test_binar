
<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDeletedAt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comunity_featured_users', function($table) {
            $table->dateTime('deleted_at')->nullable()->change();
        });

        Schema::table('featured_users', function($table) {
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
        Schema::drop('comunity_featured_users');
        Schema::drop('featured_users');
    }
}
