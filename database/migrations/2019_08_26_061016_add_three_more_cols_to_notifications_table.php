<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddThreeMoreColsToNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->BigInteger('workoutid')->after('userid')->unsigned();
            $table->foreign('workoutid')->references('id')->on('workout')->onDelete('cascade');
            $table->BigInteger('userworkedid')->after('workoutid')->unsigned();
            $table->foreign('userworkedid')->references('id')->on('users')->onDelete('cascade');
            $table->tinyInteger('type');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropColumn('workoutid');
            $table->dropColumn('userworkedid');
            $table->dropColumn('type');
        });
    }
}
