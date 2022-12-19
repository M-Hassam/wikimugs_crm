<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PricePlanTypeOfWorkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\PricePlanTypeOfWork::truncate();
        \App\Models\PricePlanTypeOfWork::factory()->count(3)->create(); 
    }
}
