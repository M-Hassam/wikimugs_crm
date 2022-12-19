<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DomainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Domain::truncate();
        \App\Models\Domain::factory()->count(10)->create();
    }
}
