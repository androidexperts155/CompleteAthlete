<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSixMoreColsToUserworkoutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_workout', function (Blueprint $table) {
            $table->string('scoring_type')->nullable();
            $table->string('rounds')->nullable();
            $table->string('reps')->nullable();
            $table->string('meters')->nullable();
            $table->string('calories')->nullable();
            $table->string('lbs')->nullable();


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
            $table->dropcolumn('scoring_type');
            $table->dropcolumn('rounds');
            $table->dropcolumn('reps');
            $table->dropcolumn('meters');
            $table->dropcolumn('calories');
            $table->dropcolumn('lbs');
           
        });
    }
}
