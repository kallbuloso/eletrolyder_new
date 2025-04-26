<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SoStatus>
 */
class SoStatusFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'description' => fake()->word(),
            'status_type' => fake()->numberBetween(0, 3),
            'so_status_step_id' => null,
            'generates_revenue' => fake()->numberBetween(0, 1),
        ];
    }
}
