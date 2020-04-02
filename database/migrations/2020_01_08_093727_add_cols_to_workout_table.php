<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColsToWorkoutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('workout', function (Blueprint $table) {
            $table->BigInteger('assigned_by')->unsigned()->nullable();
            $table->BigInteger('assigned_to')->unsigned()->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('workout', function (Blueprint $table) {
           $table->dropColumn('assigned_by');
           $table->dropColumn('assigned_to');
        });
    }
}
