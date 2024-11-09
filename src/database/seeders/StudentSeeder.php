<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      
        $user = User::firstOrCreate(["name" => "student1", "email" => "student1@el.com", "password" => bcrypt($password = "student1")]);
        $user->assignRole("student");
    }
}
