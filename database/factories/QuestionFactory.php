<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use app\Models\EstimateCategory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => EstimateCategory::factory(),
            'text' => $this->faker->sentence(),
            'type' => $this->faker->randomElement(['dropdown', 'checkbox', '']),
            'step' => $this->faker->optional()->numberBetween(1, 10),
        ];
    }
}
