<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusColsToWorkoutChatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('workout_chat', function (Blueprint $table) {
            $table->tinyInteger('messageread')->default('0')->comments("1:=>this message is read 0=>not read");
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
            $table->dropColumn('messageread');
        });
    }
}
