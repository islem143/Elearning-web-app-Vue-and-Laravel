<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AddUserQuizPermissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::firstOrCreate(["name" => "save-quiz-result"]);
        Permission::firstOrCreate(["name" => "attach-choice"]);
        
        
        $studentRole = Role::where('name', 'student')->first();

        $studentRole->givePermissionTo(["save-quiz-result","attach-choice"]);
    }
}
