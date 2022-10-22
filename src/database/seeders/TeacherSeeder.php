<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create(["name" => "teacher1", "email" => "teacher1@el.com", "password" => bcrypt($password = "teacher1")]);
        $user->assignRole("teacher");
    }
}
