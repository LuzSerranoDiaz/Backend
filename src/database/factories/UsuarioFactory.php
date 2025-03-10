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
        $contrasena = static::$password ??= Hash::make('password');
        return [
            'email' => fake()->unique()->safeEmail(),
            'contrasena' => $contrasena,
            'nombre' => fake()->name(),
            'nombreUsuario' => fake()->lastName(),
            'remember_token' => Str::random(10),
        ];
    }
}
