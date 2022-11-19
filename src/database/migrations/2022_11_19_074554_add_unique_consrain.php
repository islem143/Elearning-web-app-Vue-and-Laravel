<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUniqueConsrain extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quiz_user', function (Blueprint $table) {
    
        $table->dropForeign("quiz_user_user_id_foreign");
        $table->dropIndex("quiz_user_user_id_quiz_id_index");
        

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
