<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPersonalWorkoutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_personal_workout', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('userid')->unsigned();
            $table->foreign('userid')->references('id')->on('users')->OnDelete('cascade');
            $table->BigInteger('workoutid')->unsigned();
            $table->foreign('workoutid')->references('id')->on('workout')->OnDelete('cascade');

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
        Schema::dropIfExists('user_personal_workout');
    }
}
