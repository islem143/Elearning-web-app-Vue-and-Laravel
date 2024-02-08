<?php

namespace Database\Seeders;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class CategoryPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Permission::create(["name" => "add-category"]);
        // Permission::create(["name" => "edit-category"]);
        // Permission::create(["name" => "delete-category"]);
        // Permission::create(["name" => "view-category"]);
        $teacherRole = Role::where('name', 'teacher')->first();
        $studentRole = Role::where('name', 'student')->first();
        $teacherRole->givePermissionTo(["add-category", "edit-category", "delete-category", "view-category"]);
        $studentRole->givePermissionTo(["view-category"]);
    }
}
