<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOneMoreColsToWorkoutChatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('workout_chat', function (Blueprint $table) {
            $table->tinyInteger('readstatus')->default(0)->comments('0=>unread ,1=>read');
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
            $table->dropColumn('readstatus');
        });
    }
}
