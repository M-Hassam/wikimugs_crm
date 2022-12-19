<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PricePlanNoOfPagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\PricePlanNoOfPage::truncate();
        $max = 100;
        
        for($i=1; $i<=$max; $i++) 
        {
            try 
            { 
            	\App\Models\PricePlanNoOfPage::create([
                     'domain_id' => 1,
                     'name' => 'No of Pages '.$i
            	]); 
            }
            catch(\Illuminate\Database\QueryException $ex){}
        };
    }
}
