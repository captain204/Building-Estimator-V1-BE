<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use app\Models\Question;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Option>
 */
class OptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'question_id' => Question::factory(), 
            'type' => $this->faker->randomElement(['dropdown', 'checkbox', 'form']), 
            'name' => $this->faker->word(), 
            'description' => $this->faker->sentence(), 
            'question' => $this->faker->sentence(), 
        ];
    }
}
