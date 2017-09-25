<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NullableTableUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function($table) {
            $table->string('id_gg', 20)->nullable()->change();
            $table->string('url', 50)->nullable()->change();
            $table->date('dob')->nullable()->change();
            $table->string('about', 100)->nullable()->change();
            $table->string('gender', 5)->nullable()->change();
            $table->string('city', 20)->nullable()->change();
            $table->string('intersport_passport', 50)->nullable()->change();
            $table->string('address', 200)->nullable()->change();
            $table->string('website', 50)->nullable()->change();
            $table->string('phone', 20)->nullable()->change();
            $table->string('photo', 50)->nullable()->change();
            $table->string('photo_thumbnail', 100)->nullable()->change();
            $table->string('valid_identification', 100)->nullable()->change();
            $table->string('followers', 100)->nullable()->change();
            $table->string('followees', 100)->nullable()->change();
            $table->string('statuses', 100)->nullable()->change();
            $table->string('total_points', 100)->nullable()->change();
            $table->string('points', 100)->nullable()->change();
            $table->string('profession', 100)->nullable()->change();
            $table->string('institution', 100)->nullable()->change();
            $table->string('friends_count', 100)->nullable()->change();
            $table->string('unread_notifications_count', 100)->nullable()->change();
            $table->string('cover_image', 100)->nullable()->change();
            $table->string('followers_count', 100)->nullable()->change();
            $table->string('social_connections', 100)->nullable()->change();
            $table->string('is_official', 100)->nullable()->change();
            $table->string('is_community', 100)->nullable()->change();
            $table->string('is_email_verified', 100)->nullable()->change();
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
            $table->dropColumn('id_gg');
            $table->dropColumn('url');
            $table->dropColumn('dob');
            $table->dropColumn('about');
            $table->dropColumn('gender');
            $table->dropColumn('city');
            $table->dropColumn('intersport_passport');
            $table->dropColumn('address');
            $table->dropColumn('website');
            $table->dropColumn('phone');
            $table->dropColumn('photo');
            $table->dropColumn('photo_thumbnail');
            $table->dropColumn('valid_identification');
            $table->dropColumn('followers');
            $table->dropColumn('followees');
            $table->dropColumn('statuses');
            $table->dropColumn('total_points');
            $table->dropColumn('points');
            $table->dropColumn('profession');
            $table->dropColumn('institution');
            $table->dropColumn('friends_count');
            $table->dropColumn('unread_notifications_count');
            $table->dropColumn('cover_image');
            $table->dropColumn('followers_count');
            $table->dropColumn('social_connections');
            $table->dropColumn('is_official');
            $table->dropColumn('is_community');
            $table->dropColumn('is_email_verified');
        });
    }
}
