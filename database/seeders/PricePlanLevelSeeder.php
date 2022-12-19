<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PricePlanLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\PricePlanLevel::truncate();
        \App\Models\PricePlanLevel::factory()->count(3)->create(); 
    }
}
