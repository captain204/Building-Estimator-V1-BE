<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GrassesAndShrubs>
 */
class GrassesAndShrubsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'qty_area' => $this->faker->randomFloat(2, 1, 100),
            'unit' => $this->faker->randomElement(['sqm', 'acre', 'hectare']),
            'rate' => $this->faker->randomFloat(2, 10, 500),
            'amount' => $this->faker->randomFloat(2, 100, 10000),
            'no_of_days' => $this->faker->numberBetween(1, 30),
        ];
    }
}
