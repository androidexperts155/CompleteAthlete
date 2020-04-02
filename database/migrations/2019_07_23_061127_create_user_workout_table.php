<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserWorkoutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_workout', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('workoutid')->unsigned();
            $table->foreign('workoutid')->on('workout')->references('id')->onDelete('cascade');
            $table->bigInteger('userid')->unsigned();
            $table->foreign('userid')->on('users')->references('id')->onDelete('cascade');
            $table->bigInteger('categoryid')->unsigned();
            $table->foreign('categoryid')->on('workout_category')->references('id')->onDelete('cascade');
            $table->Integer('minutes')->nullable();
            $table->Integer('seconds')->nullable();
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
        Schema::dropIfExists('user_workout');
    }
}
