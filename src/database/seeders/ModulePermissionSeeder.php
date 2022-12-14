<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ModulePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Permission::create(["name" => "add-module"]);
        // Permission::create(["name" => "edit-module"]);
        // Permission::create(["name" => "delete-module"]);
        // Permission::create(["name" => "view-module"]);
        $teacherRole = Role::where('name', 'teacher')->first();
        $studentRole = Role::where('name', 'student')->first();
        $teacherRole->givePermissionTo(["add-module", "edit-module", "delete-module", "view-module"]);
        $studentRole->givePermissionTo(["view-module"]);
        // Permission::create(["name" => "join-module"]);
        // $studentRole = Role::where('name', 'student')->first();
        // $studentRole->givePermissionTo(["join-module"]);

    }
}
