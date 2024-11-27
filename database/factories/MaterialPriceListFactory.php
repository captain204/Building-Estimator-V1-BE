<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MaterialPriceList>
 */
class MaterialPriceListFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'price_group' => $this->faker->word,
            'material' => $this->faker->word,
            'specification' => $this->faker->sentence,
            'size' => $this->faker->randomElement(['20 TONNES (1 TRIP)', '10 TONNES', '5 TONNES']),
            'low_price_point' => $this->faker->numberBetween(50000, 70000),
            'higher_price_point' => $this->faker->numberBetween(70001, 90000),
            'average_price_point' => $this->faker->numberBetween(60000, 80000),
        ];
    }
}
