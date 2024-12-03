<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CostTracker>
 */
class CostTrackerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = \App\Models\CostTracker::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'details' => $this->faker->sentence,
            'quantity' => $this->faker->numberBetween(1, 10),
            'price' => $this->faker->randomFloat(2, 100, 10000)
        ];
    }
}
