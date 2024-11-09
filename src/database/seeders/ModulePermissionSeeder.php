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
        Permission::firstOrCreate(["name" => "add-module"]);
        Permission::firstOrCreate(["name" => "edit-module"]);
        Permission::firstOrCreate(["name" => "delete-module"]);
        Permission::firstOrCreate(["name" => "view-module"]);
        $teacherRole = Role::where('name', 'teacher')->first();
        $studentRole = Role::where('name', 'student')->first();
        $teacherRole->givePermissionTo(["add-module", "edit-module", "delete-module", "view-module"]);
        $studentRole->givePermissionTo(["view-module"]);
        Permission::firstOrCreate(["name" => "join-module"]);
        $studentRole = Role::where('name', 'student')->first();
        $studentRole->givePermissionTo(["join-module"]);

    }
}
