<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Contracts\Permission;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teacherRole = Role::firstOrCreate(["name" => "teacher"]);
        $studentRole = Role::firstOrCreate(["name" => "student"]);
        $role = Role::firstOrCreate(["name" => "super-admin"]);
    }
}
