<?php

namespace Database\Seeders;

use App\Models\Cita;
use App\Models\CitaServicio;
use App\Models\Cliente;
use App\Models\Contrato;
use App\Models\Empleado;
use App\Models\EmpleadoEspecilidad;
use App\Models\Especialidad;
use App\Models\Servicio;
use App\Models\User;
use App\Models\Usuario;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Usuario::factory()->count(13)->create();
        Cliente::factory()->count(10)->create()
        ->each(function($cliente) {

        });
        
        Empleado::factory()->count(3)->create();
        Especialidad::factory()->create(['nombre' => 'cortar']);
        Especialidad::factory()->create(['nombre' => 'tintar']);
        Especialidad::factory()->create(['nombre' => 'degradar']);
        Contrato::factory()->count(9)->create();
        Cita::factory()->count(100)->create();
        Servicio::factory()->count(4)->create();
        CitaServicio::factory()->count(10)->create();
        EmpleadoEspecilidad::factory()->count(3)->create();
    }
}
