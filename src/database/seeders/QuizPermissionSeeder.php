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
        Permission::firstOrCreate(["name" => "add-quiz"]);
        Permission::firstOrCreate(["name" => "edit-quiz"]);
        Permission::firstOrCreate(["name" => "delete-quiz"]);
        Permission::firstOrCreate(["name" => "view-quiz"]);
        $teacherRole = Role::where('name', 'teacher')->first();
        $studentRole = Role::where('name', 'student')->first();
        $teacherRole->givePermissionTo(["add-quiz", "edit-quiz", "delete-quiz", "view-quiz"]);
        $studentRole->givePermissionTo(["view-quiz"]);
    }
}
