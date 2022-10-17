<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuleCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module_courses', function (Blueprint $table) {
           
            $table->foreignId("module_id")->constrained()->onDelete("cascade");
            $table->foreignId("course_id")->constrained()->onDelete("cascade");
            $table->primary(["module_id","course_id"]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('module_courses');
    }
}
