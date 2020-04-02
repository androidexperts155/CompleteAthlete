<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOnMoreColsToWorkoutChatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('workout_chat', function (Blueprint $table) {
            $table->tinyInteger('coacheditstatus')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('workout_chat', function (Blueprint $table) {
            $table->dropColumn('coacheditstatus');
        });
    }
}
