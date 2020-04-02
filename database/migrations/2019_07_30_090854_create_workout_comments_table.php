<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkoutCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workout_comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('workoutid')->unsigned();
            $table->foreign('workoutid')->on('workout')->references('id')->onDelete('cascade');
            $table->bigInteger('userid')->unsigned();
            $table->foreign('userid')->on('users')->references('id')->onDelete('cascade');
            $table->bigInteger('commentedby')->unsigned();
            $table->foreign('commentedby')->on('users')->references('id')->onDelete('cascade');
            $table->text('comments');
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
        Schema::dropIfExists('workout_comments');
    }
}
