<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(TierSeeder::class);
        $this->call(RegionSeeder::class);
        $this->call(DomainSeeder::class);
        $this->call(PricePlanTypeOfWorkSeeder::class);
        $this->call(PricePlanLevelSeeder::class);
        $this->call(PricePlanUrgencySeeder::class);
        $this->call(LeadStatusSeeder::class);
        $this->call(LeadSeeder::class);
        $this->call(PricePlanSeeder::class);
        $this->call(PricePlanNoOfPagesSeeder::class);
        $this->call(PricePlanSubjectSeeder::class);
        $this->call(PricePlanStyleSeeder::class);
        $this->call(CouponTypeSeeder::class);
        $this->call(CouponSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(OrderSeeder::class);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
