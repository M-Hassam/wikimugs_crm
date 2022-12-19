<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CouponTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\CouponType::truncate();
    	
        $data = [
           [
           	   'title'=>'Amount'
           ],
           [
           	   'title'=>'Percentage'
           ]
        ];

        \App\Models\CouponType::insert($data);
    }
}
