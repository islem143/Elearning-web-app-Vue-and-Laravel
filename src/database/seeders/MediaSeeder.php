<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class MediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(["name" => "add-media"]);
        Permission::create(["name" => "edit-media"]);
        Permission::create(["name" => "delete-media"]);
        Permission::create(["name" => "view-media"]);
        $teacherRole = Role::where('name', 'teacher')->first();
        $studentRole = Role::where('name', 'student')->first();
        $teacherRole->givePermissionTo(["add-media", "edit-media", "delete-media", "view-media"]);
        $studentRole->givePermissionTo(["view-media"]);
    }
}
