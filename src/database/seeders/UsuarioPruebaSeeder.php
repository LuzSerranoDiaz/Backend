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