<?php

namespace Database\Factories;

use App\Models\Lead;
use App\Models\Domain;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeadFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Lead::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $domains = Domain::all()->pluck('id')->toArray();

        return [
            'domain_id' => 1,
            'lead_status_id' => 1,
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->numerify('###-###-####'),
            'created_by' => 1 
        ];
    }
}
