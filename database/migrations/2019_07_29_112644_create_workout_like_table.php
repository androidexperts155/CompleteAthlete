<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkoutLikeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workout_like', function (Blueprint $table) {
            $table->bigIncrements('id');
             $table->bigInteger('workoutid')->unsigned();
            $table->foreign('workoutid')->on('workout')->references('id')->onDelete('cascade');
            $table->bigInteger('userid')->unsigned();
            $table->foreign('userid')->on('users')->references('id')->onDelete('cascade');
            $table->bigInteger('likebyuserid')->unsigned()->nullable();
            $table->foreign('likebyuserid')->on('users')->references('id')->onDelete('cascade');

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
        Schema::dropIfExists('workout_like');
    }
}
