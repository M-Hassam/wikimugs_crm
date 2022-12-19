<?php

namespace Database\Factories;

use App\Models\PricePlanNoOfPage;
use Illuminate\Database\Eloquent\Factories\Factory;

class PricePlanNoOfPageFactory extends Factory
{
    public static $number = 1;
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PricePlanNoOfPage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'domain_id' => 1,
            'name' => 'No of Pages '.self->number++;
        ];
    }
}
