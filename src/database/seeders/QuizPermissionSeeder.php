<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class QuizPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(["name" => "add-quiz"]);
        Permission::create(["name" => "edit-quiz"]);
        Permission::create(["name" => "delete-quiz"]);
        Permission::create(["name" => "view-quiz"]);
        $teacherRole = Role::where('name', 'teacher')->first();
        $studentRole = Role::where('name', 'student')->first();
        $teacherRole->givePermissionTo(["add-quiz", "edit-quiz", "delete-quiz", "view-quiz"]);
        $studentRole->givePermissionTo(["view-quiz"]);
    }
}
