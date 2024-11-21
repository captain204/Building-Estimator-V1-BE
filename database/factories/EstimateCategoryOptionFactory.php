<?php

namespace Database\Factories;
use App\Models\EstimateCategoryOption;
use App\Models\EstimateCategory;


use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EstimateOption>
 */
class EstimateCategoryOptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = EstimateCategoryOption::class;

    public function definition(): array
    {
        return [
            'category_id' => EstimateCategory::factory(),
            'name' => $this->faker->word(),
            'type' => $this->faker->randomElement(['dropdown', 'checkbox', 'form']),
            'options' => $this->faker->randomElement([
                null,
                ['Grasses', 'Shrubs', 'Trees'], 
                ['Yes' => ['Sub-option A', 'Sub-option B'], 'No' => []], 
            ]),
            'description' => $this->faker->sentence(),
        ];
    }
}
