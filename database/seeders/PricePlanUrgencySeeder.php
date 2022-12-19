<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PricePlanUrgencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\PricePlanUrgency::truncate();
        \App\Models\PricePlanUrgency::factory()->count(3)->create(); 
    }
}
