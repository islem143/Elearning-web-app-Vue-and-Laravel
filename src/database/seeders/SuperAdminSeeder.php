<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create(["name" => "super-admin"]);
        $user = User::create(["name" => "superadmin", "email" => "superadmin@el.com", "password" => bcrypt($password = "superadmin123")]);
        $user->assignRole($role);
    }
}
