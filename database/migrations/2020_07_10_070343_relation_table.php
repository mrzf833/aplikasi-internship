<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RelationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('id_role')->on('role_users')->references('id')->onDelete('cascade')->onUpdate('cascade');
        });
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->foreign('id_school')->on('schools')->references('id')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('id_position')->on('positions')->references('id')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('id_instructor')->on('users')->references('id')->onDelete('set null')->onUpdate('cascade');
        });
        Schema::table('user_reviews', function (Blueprint $table) {
            $table->foreign('id_user')->on('users')->references('id')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_mentor')->on('users')->references('id')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_project')->on('projects')->references('id')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['id_role']);
        });
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->dropForeign(['id_school','id_position','id_instructor']);
        });
        Schema::table('user_reviews', function (Blueprint $table) {
            $table->dropForeign(['id_user','id_mentor','id_project']);
        });
    }
}
