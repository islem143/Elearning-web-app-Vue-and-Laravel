<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // $roleSeeder=new RolesSeeder();
        // $roleSeeder->run();
          $supAdminSeeder=new SuperAdminSeeder();
          $teacherS=new TeacherSeeder();
          $st=new StudentSeeder();
          $add=new AddUserQuizPermissions();
          $choice=new ChoicePermissionSeeder();
          $course=new CoursePermissionSeeder();
          $log=new LogPermissionSeeder();
          $media=new MediaSeeder();
          $Module=new ModulePermissionSeeder();
          $QuestionPermissionSeeder=new QuestionPermissionSeeder();
          $QuizPermissionSeeder=new QuizPermissionSeeder();
        //   $supAdminSeeder->run();
        //   $teacherS->run();
        //   $st->run();
          $add->run();
        //   $choice->run();
        //   $course->run();
        //   $log->run();
        //   $media->run();
        //   $Module->run();
        //   $QuestionPermissionSeeder->run();
        //   $QuizPermissionSeeder->run();

        

    }
}
