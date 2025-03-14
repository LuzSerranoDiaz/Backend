<?php

namespace Database\Seeders;

use App\Models\Cita;
use App\Models\CitaServicio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Seeder para ir anadiendo citas poco a poco, ejecutar varias veces.
        Cita::factory(3000)->create();
        CitaServicio::factory(random_int(3000, 9000))->create();
    }
}
