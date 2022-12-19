<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::truncate();
        
        $roles = [
            'ADMIN',
            'SALES_ADMIN',
            'SALES',
            'WRITER_LEAD',
            'WRITER',
            'QA_LEAD',
            'QA',
        ];

        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }
    }
}
