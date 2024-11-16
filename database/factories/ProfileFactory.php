<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'firstname' => $this->faker->firstName(),
            'lastname' => $this->faker->lastName(),
            'country' => $this->faker->country(),
            'builder_type' => $this->faker->jobTitle(),
            'phone' => $this->faker->phoneNumber(),
            'birthdate' => $this->faker->date(),
            'bio' => $this->faker->paragraph(),
        ];
    }
}
