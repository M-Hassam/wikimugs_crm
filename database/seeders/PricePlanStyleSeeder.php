<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PricePlanStyle;

class PricePlanStyleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	\App\Models\PricePlanStyle::truncate();
    	
        $data = [
           [
           	   'domain_id'=>1,
           	   'name'=>'APA'
           ],
           [
           	   'domain_id'=>1,
           	   'name'=>'OSCOLA'
           ],
           [
           	   'domain_id'=>1,
           	   'name'=>'Harvard'
           ],
           [
           	   'domain_id'=>1,
           	   'name'=>'Chicago'
           ],
           [
           	   'domain_id'=>1,
           	   'name'=>'MLA'
           ]
        ];

        PricePlanStyle::insert($data);
    }
}
