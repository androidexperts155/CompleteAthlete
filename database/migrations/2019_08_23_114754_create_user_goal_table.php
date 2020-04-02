<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserGoalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_goal', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->Integer('proteins')->nullable();
            $table->Integer('carbs')->nullable();
            $table->Integer('fats')->nullable();
            $table->tinyInteger('weightloss')->default(0);
            $table->tinyInteger('weightgain')->default(0);
            $table->tinyInteger('weightmaintain')->default(0);
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
        Schema::dropIfExists('user_goal');
    }
}
