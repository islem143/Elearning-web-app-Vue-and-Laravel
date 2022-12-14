<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class D extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quiz_user', function (Blueprint $table) {
            $table->dropColumn("id");
            $table->dropForeign("quiz_user_quiz_id_foreign");
            $table->dropForeign("quiz_user_user_id_foreign");
            // $table->dropColumn("quiz_id");
            // $table->dropColumn("user_id");
            // $table->foreignId("user_id")->constrained()->onDelete("cascade");
            // $table->foreignId("quiz_id")->constrained()->onDelete("cascade");
            //  $table->unique(["user_id", "quiz_id"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quiz_user', function (Blueprint $table) {
            //
        });
    }
}
