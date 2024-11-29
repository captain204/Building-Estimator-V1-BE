<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LabourRates>
 */
class LabourRatesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
    */
    public function definition(): array
    {
        return [
            'area_of_work'=> $this->faker->word,
            'lower_point_daily_rate_per_day' => $this->faker->numberBetween(50000, 70000),
            'higher_point_daily_rate_per_day' => $this->faker->numberBetween(50000, 70000),
            'average_point_daily_rate_per_day'=> $this->faker->numberBetween(60000, 80000),
            'unit_of_costing' => $this->faker->randomElement(['20 TONNES (1 TRIP)', '10 TONNES', '5 TONNES']),
            'lower_point_daily_rate_per_unit' => $this->faker->numberBetween(50000, 70000),
            'higher_point_daily_rate_per_unit' => $this->faker->numberBetween(70001, 90000),
            'average_point_daily_rate_per_unit' => $this->faker->numberBetween(60000, 80000),
        ];
    }
}
