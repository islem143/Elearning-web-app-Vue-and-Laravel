<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class LogPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::firstOrCreate(["name" => "view-logs"]);
       
        $teacherRole=Role::where('name', 'teacher')->first();

        $teacherRole->givePermissionTo(["view-logs"]);
 
    }
}
