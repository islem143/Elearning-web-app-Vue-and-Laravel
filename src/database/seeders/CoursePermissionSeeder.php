<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CoursePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(["name" => "add-course"]);
        Permission::create(["name" => "edit-course"]);
        Permission::create(["name" => "delete-course"]);
        Permission::create(["name" => "view-course"]);
        $teacherRole = Role::where('name', 'teacher')->first();
        $studentRole = Role::where('name', 'student')->first();
        $teacherRole->givePermissionTo(["add-course", "edit-course", "delete-course", "view-course"]);
        $studentRole->givePermissionTo(["view-course"]);
    }
}
