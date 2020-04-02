<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTotalColsToUserSaveDietTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_daily_diet', function (Blueprint $table) {
            $table->Integer('total_proteins')->nullable();
            $table->Integer('total_carbs')->nullable();
            $table->Integer('total_fats')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_daily_diet', function (Blueprint $table) {
            $table->dropColumn('total_proteins');
            $table->dropColumn('total_fats');
            $table->dropColumn('total_carbs');
        });
    }
}
