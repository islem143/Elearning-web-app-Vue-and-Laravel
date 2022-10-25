<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class QuestionPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(["name" => "add-question"]);
        Permission::create(["name" => "edit-question"]);
        Permission::create(["name" => "delete-question"]);
        Permission::create(["name" => "view-question"]);
        $teacherRole = Role::where('name', 'teacher')->first();
        $studentRole = Role::where('name', 'student')->first();
        $teacherRole->givePermissionTo(["add-question", "edit-question", "delete-question", "view-question"]);
        $studentRole->givePermissionTo(["view-question"]);
    }
}
