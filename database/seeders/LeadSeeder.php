<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Lead::truncate();
        \App\Models\Lead::factory()->count(10)->create();
    }
}
