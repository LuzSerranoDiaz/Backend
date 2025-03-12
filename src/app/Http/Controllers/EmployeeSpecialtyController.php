<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;
use App\Models\Especialidad;

/**
 * Clase controlador Especialidad Por Empleado
 */
class EmployeeSpecialtyController extends Controller
{
    /**
     * Asigna especialidades a un empleado
     */
    public function assign(Request $request, $empleadoId)
    {
        $empleado = Empleado::findOrFail($empleadoId);
        $request->validate(['especialidad_ids' => 'required|array']);
        $especialidadIds = $request->especialidad_ids;

        // Asignar especialidades al empleado
        $empleado->especialidades()->syncWithoutDetaching($especialidadIds);
        return $empleado->especialidades;
    }

    /**
     * Lista especialidades de un empleado
     */
    public function list($empleadoId)
    {
        $empleado = Empleado::findOrFail($empleadoId);
        return $empleado->especialidades; 
    }

    /**
     * Elimina una especialidad de un empleado
     */
    public function delete($empleadoId, $especialidadId)
    {
        $empleado = Empleado::findOrFail($empleadoId);
        $empleado->especialidades()->detach($especialidadId); 
        return response()->noContent();
    }
}
