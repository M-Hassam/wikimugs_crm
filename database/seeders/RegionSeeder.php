<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Region::truncate();
        \App\Models\Region::factory()->count(10)->create(); 
    }
}
