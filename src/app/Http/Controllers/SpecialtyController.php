<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Especialidad;

/**
 * Clase Controlador de Especialidades
 */
class SpecialtyController extends Controller
{
    /**
     * Añade una especialidad
     */
    public function add(Request $request) {
        $request->validate(['name' => 'required|string|unique:especialidads']);
        return Especialidad::create(['name' => $request->name]);
    }

    /**
     * Muestra las especialidades
     */
    public function show() {
        return Especialidad::all();
    }

    /**
     * Obtiene una especialidad
     */
    public function getSpecialty($id) {
        return Especialidad::findOrFail($id);
    }

    /**
     * Modifica una especialidad
     */
    public function update(Request $request, $id) {
        $especialidad = Especialidad::findOrFail($id);
        $request->validate(['name' => 'required|string|unique:especialidads,name,' . $id]);
        $especialidad->update(['name' => $request->name]); 
        return $especialidad;
    }

    /**
     * Elimina una especialidad
     */
    public function delete($id) {
        $especialidad = Especialidad::findOrFail($id);
        $especialidad->delete(); 
        return response()->noContent();
    }
}
