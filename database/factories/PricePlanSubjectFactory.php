<?php

namespace Database\Factories;

use App\Models\PricePlanSubject;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PricePlanSubjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PricePlanSubject::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'domain_id' => 1,
            'name' => Str::random(8)
        ];
    }
}
