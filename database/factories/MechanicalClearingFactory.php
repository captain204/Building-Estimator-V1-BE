<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\MechanicalClearing;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MechanicalClearing>
 */
class MechanicalClearingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            
            'area_of_land' => $this->faker->numberBetween(100, 10000),
            'preliminary_needed' => $this->faker->name,
            'no_of_days' => $this->faker->numberBetween(1, 30),
            'category' => $this->faker->unique()->randomElement(['non_waterlogged', 'unstable_ground', 'swampy']),
        ];
    }
}
