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
        Permission::firstOrCreate(["name" => "add-question"]);
        Permission::firstOrCreate(["name" => "edit-question"]);
        Permission::firstOrCreate(["name" => "delete-question"]);
        Permission::firstOrCreate(["name" => "view-question"]);
        $teacherRole = Role::where('name', 'teacher')->first();
        $studentRole = Role::where('name', 'student')->first();
        $teacherRole->givePermissionTo(["add-question", "edit-question", "delete-question", "view-question"]);
        $studentRole->givePermissionTo(["view-question"]);
    }
}
