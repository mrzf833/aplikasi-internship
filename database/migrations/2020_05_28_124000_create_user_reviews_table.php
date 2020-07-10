<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_reviews', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_mentor');
            $table->char('score',1)->comment('A: Sangat Bagus', 'B: Bagus', 'C: Cukup', 'D: Kurang', 'E: Sangat Kurang')->default(false);
            $table->text('comment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_reviews');
    }
}
