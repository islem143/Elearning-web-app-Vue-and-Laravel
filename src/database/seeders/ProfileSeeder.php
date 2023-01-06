<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::find(7)->profile()->create();
        User::find(8)->profile()->create();
        User::find(9)->profile()->create();
        User::find(10)->profile()->create();
        User::find(11)->profile()->create();
        User::find(12)->profile()->create();
        User::find(13)->profile()->create();
    }
}
