<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $person = fake()->randomElement(['F', 'J']);
        $status = fake()->randomElement([0, 1, 2]); // 0 - Ativo, 1 - Inativo, 2 - Bloqueado
        return [
            'name' => fake()->name(),
            'nick_name' => fake()->lastName(),
            'gender' => $person === 'F' ? fake()->randomElement(['M', 'F', 'L', 'NB', 'O']) : null,
            'person' => $person,
            'cpf_cnpj' => $person === 'F' ? fake()->unique()->cpf(false) : fake()->unique()->cnpj(false),
            'note' => fake()->paragraph(2),
            'status' => $status,
            'blocking_reason' => $status === 2 ? fake()->sentence() : null,
            'last_purchase' => fake()->date('d/m/Y H:i:s'),
        ];
    }
}
