<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsuarioPruebaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Usuario::factory()->create([
            'email' => 'test@example.com',
            'contrasena' => '1234',
            'nombre' => 'prueba',
            'apellidos' => 'prueba prueba',
        ]);
    }
}

/* 'email' => fake()->unique()->safeEmail(),
'password' => static::$password ??= Hash::make('password'),
'nombre' => fake()->name(),
'apellidos' => fake()->lastName(),
'tlf' => fake()->unique()->phoneNumber(),
'direccion' => fake()->address(),
'municipio' => fake()->city(),
'provincia' => fake()->country(), // Country ya que no hay especifico para provincia 
'remember_token' => Str::random(10), */