<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PricePlanSubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\PricePlanSubject::truncate();
        \App\Models\PricePlanSubject::factory()->count(10)->create();
    }
}
