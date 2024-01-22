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
        $user = User::create(["name" => "teacher3", "email" => "teacher3@el.com", "password" => bcrypt($password = "teacher3")]);
        $user->assignRole("teacher");
    }
}
