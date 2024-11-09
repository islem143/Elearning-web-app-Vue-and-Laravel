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
      
        
        $user = User::firstOrCreate(["name" => "superadmin", "email" => "superadmin@el.com", "password" => bcrypt($password = "superadmin123")]);
        $user->assignRole('super-admin');
    }
}
