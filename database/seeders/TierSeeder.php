<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Tier::truncate();
        \App\Models\Tier::factory()->count(10)->create();
    }
}
