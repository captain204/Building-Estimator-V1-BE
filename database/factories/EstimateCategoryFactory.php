<?php

namespace Database\Factories;
use App\Models\EstimateCategory;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EstimateCategory>
 */
class EstimateCategoryFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = EstimateCategory::class;

    public function definition(): array
    {
            return [
                'name' => $this->faker->words(2, true), 
                'description' => $this->faker->sentence(), 
            ];
    }
}
