<?php

namespace Database\Factories;

use App\Models\Empleado;
use App\Models\Especialidad;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Empleado>
 */
class EmpleadoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $usuario_id = Usuario::pluck('id')->toArray();

        return [
            'usuario_id' => fake()->randomElement($usuario_id),
            'anos_experiencia' => random_int(0, 10),
        ];
    }
}
