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
        Permission::firstOrCreate(["name" => "add-choice"]);
        Permission::firstOrCreate(["name" => "edit-choice"]);
        Permission::firstOrCreate(["name" => "delete-choice"]);
        Permission::firstOrCreate(["name" => "view-choice"]);
        $teacherRole = Role::where('name', 'teacher')->first();
        $studentRole = Role::where('name', 'student')->first();
        $teacherRole->givePermissionTo(["add-choice", "edit-choice", "delete-choice", "view-choice"]);
        $studentRole->givePermissionTo(["view-choice"]);
    }
}
