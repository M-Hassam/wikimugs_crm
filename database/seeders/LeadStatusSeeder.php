<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LeadStatus;

class LeadStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LeadStatus::create([
            'title' => 'Pending',
        ]);

        LeadStatus::create([
            'title' => 'Converted',
        ]);

        LeadStatus::create([
            'title' => 'Follow Up',
        ]);   
    }
}
