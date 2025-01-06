<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TradesmenVendor>
 */
class TradesmenVendorFactory extends Factory
{
    protected $model = \App\Models\TradesmenVendor::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'category' => $this->faker->randomElement(['Construction Tradesmen', 'Construction Vendors']),
            'sub_category' => $this->faker->randomElement(['Laborer', 'Foreman', 'Plumber', 'Electrician']),
            'profile_picture' => $this->faker->imageUrl(640, 480, 'people', true, 'Profile'),
            'job_picture' => $this->faker->imageUrl(640, 480, 'construction', true, 'Job'),
            'description' => $this->faker->sentence(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone_number' => $this->faker->phoneNumber(),
            'guarantor_name' => $this->faker->name(),
            'guarantor_contact_number' => $this->faker->phoneNumber(),
            'guarantor_id_image' => $this->faker->imageUrl(640, 480, 'documents', true, 'Guarantor ID'),
        ];
    }
}
