<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $person = fake()->randomElement(['F', 'J']);
        $status = fake()->randomElement(['A', 'I', 'B']);
        return [
            'name' => fake()->company(),
            'fantasy_name' => fake()->company(),
            'contact_name' => fake()->name(),
            'person' => $person,
            'cpf_cnpj' => $person === 'F' ? fake()->unique()->cpf(false) : fake()->unique()->cnpj(false),
            'rg_insc_est' => fake()->rg(false),
            'ccm' => fake()->randomNumber(6, true),
            'birth_date' => fake()->date('d/m/Y'),
            'logo' => fake()->imageUrl(),
            'description' => fake()->paragraph(3),
            'email' => fake()->unique()->safeEmail(),
            'website' => fake()->url(),
            'note' => fake()->paragraph(3),
        ];
    }
}
