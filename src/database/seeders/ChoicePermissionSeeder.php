<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ChoicePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(["name" => "add-choice"]);
        Permission::create(["name" => "edit-choice"]);
        Permission::create(["name" => "delete-choice"]);
        Permission::create(["name" => "view-choice"]);
        $teacherRole = Role::where('name', 'teacher')->first();
        $studentRole = Role::where('name', 'student')->first();
        $teacherRole->givePermissionTo(["add-choice", "edit-choice", "delete-choice", "view-choice"]);
        $studentRole->givePermissionTo(["view-choice"]);
    }
}
