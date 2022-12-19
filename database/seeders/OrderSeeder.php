<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\Lead;
use App\Models\PricePlan;
use App\Models\PricePlanLevel;
use App\Models\PricePlanUrgency;
use App\Models\PricePlanTypeOfWork;
use App\Models\PricePlanNoOfPage;
use App\Models\PricePlanSubject;
use App\Models\PricePlanStyle;
use App\Models\PricePlanLanguage;
use App\Models\Order;
use Faker\Factory;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	\App\Models\Order::truncate();
        $faker = Factory::create();
        // dd($faker->firstNameMale);

        $leads = Lead::all();

        // dd($leads);
        $levels = PricePlanLevel::all()->pluck('id')->toArray();
        $urgencies = PricePlanUrgency::all()->pluck('id')->toArray();
        $type_of_work = PricePlanTypeOfWork::all()->pluck('id')->toArray();
        $no_of_pages = PricePlanNoOfPage::all()->pluck('id')->toArray();
        $subjects = PricePlanSubject::all()->pluck('id')->toArray();
        $styles = PricePlanStyle::all()->pluck('id')->toArray();
        $languages = PricePlanLanguage::all()->pluck('id')->toArray();

        foreach($leads as $lead)
        {
        	$customer = Customer::create([
                'domain_id' => $lead['domain_id'],
                'timezone_id' => 1,
                'first_name'=>$lead['name'],
                'last_name'=>'',
                'serial_no'=>sprintf("%08d", mt_rand(1, 99999999)),
                'email'=>$lead['email'],
                'phone'=>$lead['phone'],
                'password'=>'password'
            ]);

            $priceplan = PricePlan::where([
               'domain_id'=> $lead['domain_id'],
               'price_plan_urgency_id'=>$faker->randomElement($urgencies),
               'price_plan_level_id'=>$faker->randomElement($levels),
               'price_plan_type_of_work_id'=>$faker->randomElement($type_of_work)
            ])->first();

            $order = Order::create([
                'domain_id'=>$lead['domain_id'],
		        'lead_id'=>$lead->id,
		        'customer_id'=>$customer->id,
                'status_id'=>2,
		        'instructions'=>'',
		        'coupon_id'=>1,
		        'topic'=>'test',
		        'price_plan_type_of_work_id'=>$faker->randomElement($type_of_work),
		        'price_plan_level_id'=>$faker->randomElement($levels),
		        'price_plan_urgency_id'=>$faker->randomElement($urgencies),
		        'price_plan_no_of_page_id'=>$faker->randomElement($no_of_pages),
		        'price_plan_indentation_id'=>1,
		        'price_plan_subject_id'=>$faker->randomElement($subjects),
		        'price_plan_style_id'=>$faker->randomElement($styles),
		        'price_plan_language_id'=>$faker->randomElement($languages),
		        'total_amount'=>$priceplan->price,
		        'discount_amount'=>0,
		        'grand_total_amount'=>$priceplan->price,
		        'created_by'=>1,
                'writer_id'=>1
            ]);

            $lead->update([
            	'lead_status_id'=>2
            ]); 


        }
    }
}
