<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use app\Models\Option;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SubOption>
 */
class SubOptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'option_id' => Option::factory(), 
            'name' => $this->faker->word(), 
            'type' => $this->faker->randomElement(['dropdown', 'checkbox', 'form']),
            'description' => $this->faker->sentence(),
            'question' => $this->faker->sentence(),
            'is_required' => $this->faker->boolean(),
        ];
    }
}
