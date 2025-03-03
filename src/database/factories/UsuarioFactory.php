<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Usuario>
 */
class UsuarioFactory extends Factory
{
    protected static ?string $password;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'email' => fake()->unique()->safeEmail(),
            'contrasena' => static::$password ??= Hash::make('password'),
            'nombre' => fake()->name(),
            'apellidos' => fake()->lastName(),
            'tlf' => fake()->unique()->phoneNumber(),
            'direccion' => fake()->address(),
            'municipio' => fake()->city(),
            'provincia' => fake()->country(), // Country ya que no hay especifico para provincia 
            'remember_token' => Str::random(10),
        ];
    }
}
