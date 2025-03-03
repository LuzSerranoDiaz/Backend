<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contrato>
 */
class ContratoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cliente_id' => rand(1,3000),
            'numero_de_atenciones' => 10,
            'numero_de_atenciones_realizadas' => random_int(0,9),
            'fecha_inicio' => fake()->unique()->date(),
            'fecha_fin' => fake()->unique()->date(),
        ];
    }
}
