<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Status::create([
            'title' => 'Payment Awaiting'
        ]);

        Status::create([
            'title' => 'Pending'
        ]);

        Status::create([
            'title' => 'Assigned'
        ]);

        Status::create([
            'title' => 'Delivered'
        ]);

        Status::create([
            'title' => 'Modified'
        ]);

        Status::create([
            'title' => 'Completed'
        ]);

        Status::create([
            'title' => 'Cancelled'
        ]);

        Status::create([
            'title' => 'All'
        ]);

        Status::create([
            'title' => 'Deleted'
        ]);

    }
}
