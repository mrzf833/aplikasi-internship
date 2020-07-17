<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->unsignedBigInteger('id_user')->unique();
            $table->string('phone_number')->nullable();
            $table->integer('id_school')->nullable()->index()->unsigned();
            $table->date('start_internship')->nullable();
            $table->date('end_internship')->nullable();
            $table->integer('id_position')->nullable()->index()->unsigned();
            $table->foreignId('id_instructor')->nullable();
            $table->timestamps();
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_profile');
    }
}
