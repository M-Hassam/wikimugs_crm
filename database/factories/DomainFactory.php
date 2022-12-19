<?php

namespace Database\Factories;

use App\Models\Domain;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Region;
use App\Models\Tier;
use Illuminate\Support\Str;

class DomainFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Domain::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $regions = Region::all()->pluck('id')->toArray();
        $tiers = Tier::all()->pluck('id')->toArray();

        return [
            'region_id' => $this->faker->randomElement($regions),
            'tier_id' => $this->faker->randomElement($tiers),
            'name' => Str::random(8),
            'code' => 'code',
            'url' => Str::random(8),
        ];
    }
}
