<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::truncate();
        
        User::factory()
        ->count(10)
        ->create();

        $users = User::all();
        $roles = Role::all();
        foreach ($users as $user) {
            $role =  $roles->random();
            $user->assignRole($role->name);
        }
        
    }
}
