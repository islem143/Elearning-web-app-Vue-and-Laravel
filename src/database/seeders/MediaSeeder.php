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
        Permission::firstOrCreate(["name" => "add-media"]);
        Permission::firstOrCreate(["name" => "edit-media"]);
        Permission::firstOrCreate(["name" => "delete-media"]);
        Permission::firstOrCreate(["name" => "view-media"]);
        $teacherRole = Role::where('name', 'teacher')->first();
        $studentRole = Role::where('name', 'student')->first();
        $teacherRole->givePermissionTo(["add-media", "edit-media", "delete-media", "view-media"]);
        $studentRole->givePermissionTo(["view-media"]);
    }
}
