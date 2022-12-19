<?php

namespace Database\Factories;

use App\Models\PricePlan;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Domain;
use App\Models\PricePlanLevel;
use App\Models\PricePlanUrgency;
use App\Models\PricePlanTypeOfWork;

class PricePlanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PricePlan::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $domains = Domain::all()->pluck('id')->toArray();
        $levels = PricePlanLevel::all()->pluck('id')->toArray();
        $urgencies = PricePlanUrgency::all()->pluck('id')->toArray();
        $type_of_work = PricePlanTypeOfWork::all()->pluck('id')->toArray();

        return [
            'domain_id' => 1,
            'price_plan_urgency_id' => $this->faker->randomElement($urgencies),
            'price_plan_level_id' => $this->faker->randomElement($levels),
            'price_plan_type_of_work_id' => $this->faker->randomElement($type_of_work),
            'price' => $this->faker->numberBetween(1,100)
        ];
    }
}
