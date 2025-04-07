<?php

namespace Database\Factories;

use App\Models\Cliente;
use App\Models\Contrato;
use App\Models\Empleado;
use App\Models\Servicio;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cita>
 */
class CitaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $cliente_id = Cliente::pluck('id')->toArray();
        $empleado_id = Empleado::pluck('id')->toArray();
        $contrato = Contrato::where('cliente_id', '=', $cliente_id)->get();
        //$contrato = DB::table('contratos')->where('cliente_id', '=', $cliente_id)->get(); 
        $contrato_id = $contrato->pluck('id')->toArray();
        $contrato_atenciones = $contrato->pluck('numero_de_atenciones_realizadas')->toArray();
        //Contrato::where('cliente_id' = $cliente_id)->pluck('id')->toArray();

        return [
            'cliente_id' => fake()->randomElement($cliente_id),
            'empleado_id' => fake()->randomElement($empleado_id),
            'contrato_id' => fake()->randomElement($contrato_id),
            'fecha' => fake()->unique()->dateTime(),
            'estado' => fake()->randomElement(['pendiente', 'cancelado']),
            'numero_de_atenciones' => fake()->randomElement($contrato_atenciones),
        ];
    }
}
