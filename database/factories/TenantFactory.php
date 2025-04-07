<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tenant>
 */
class TenantFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    $status = fake()->randomElement(['A', 'I', 'B']);
    return [
      'status' => $status,
      'blocking_reason' => $status === 'B' ? fake()->sentence() : null,
    ];
  }
}
