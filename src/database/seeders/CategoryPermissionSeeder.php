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
        Permission::firstOrCreate(["name" => "add-category"]);
        Permission::firstOrCreate(["name" => "edit-category"]);
        Permission::firstOrCreate(["name" => "delete-category"]);
        Permission::firstOrCreate(["name" => "view-category"]);
        $teacherRole = Role::where('name', 'teacher')->first();
        $studentRole = Role::where('name', 'student')->first();
        $teacherRole->givePermissionTo(["add-category", "edit-category", "delete-category", "view-category"]);
        $studentRole->givePermissionTo(["view-category"]);
    }
}
