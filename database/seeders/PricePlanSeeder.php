<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PricePlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\PricePlan::truncate();
        $max = 300;
        for($i=1; $i<=$max; $i++) 
        {
            try { \App\Models\PricePlan::factory()->create(); }
            catch(\Illuminate\Database\QueryException $ex){}
        };
    }
}
