<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Estimator;
use App\Models\User;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Estimator>
 */
class EstimatorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     protected $model = Estimator::class;


    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // Generate a user if needed
            'type' => $this->faker->randomElement(['custom', 'automated']),
            'work_items' => $this->faker->paragraph,
            'specifications' => $this->faker->paragraph,
            'to_array' => json_encode([
                'item1' => $this->faker->word,
                'item2' => $this->faker->word,
                'item3' => $this->faker->word,
            ]),
            'variable' => $this->faker->word,
            'to_html' => "<p>" . $this->faker->sentence . "</p>",
            'require_custom_building' => $this->faker->randomElement(['yes', 'no', 'maybe']),
            'other_information' => $this->faker->paragraph,
            'is_urgent' => $this->faker->boolean,
            'agree' => $this->faker->boolean,
            'custom_more' => $this->faker->boolean,
            'classes' => json_encode(['class1', 'class2', 'class3']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
