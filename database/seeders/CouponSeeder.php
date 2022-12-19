<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Coupon::truncate();
    	
        $data = [
           [
           	   'coupon_type_id'=>1,
		       'domain_id'=>1,
		       'per_user'=>1,
		       'limit'=>100,
		       'code'=>sprintf("%08d", mt_rand(1, 99999999)),
		       'start_date'=>Carbon::now()->format('Y-m-d'),
		       'end_date'=>Carbon::now()->addDays(5)->format('Y-m-d'),
		       'description'=>'test coupon',
		       'discount'=>100,
		       'status'=>1,
		       'created_by'=>1
           ]
        ];

        \App\Models\Coupon::insert($data);
    }
}
