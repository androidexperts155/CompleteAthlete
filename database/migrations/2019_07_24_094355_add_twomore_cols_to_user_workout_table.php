<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTwomoreColsToUserWorkoutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_workout', function (Blueprint $table) {
           $table->datetime('date_created')->nullable();
           $table->text('notes')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_workout', function (Blueprint $table) {
            $table->dropColumn('date_created');
            $table->dropColumn('notes');
        });
    }
}
