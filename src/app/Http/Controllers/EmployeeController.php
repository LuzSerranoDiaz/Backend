<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Clase Controlador de Empleados
 */
class EmployeeController extends Controller
{
    /**
     * Añade un empleado
     */
    public function add(Request $request) {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'nombreUsuario' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email',
            'tlf' => 'required|string|max:20',
            'direccion' => 'required|string|max:255',
            'municipio' => 'required|string|max:255',
            'provincia' => 'required|string|max:255',
            'contrasena' => 'required|string|min:8',
            'DNI' => 'required|string|max:20|unique:empleados,DNI',
            'anos_experiencia' => 'required|integer|max:80'
        ]);

        $usuario = Usuario::create([
            'nombre' => $validatedData['nombre'],
            'nombreUsuario' => $validatedData['nombreUsuario'],
            'email' => $validatedData['email'],
            'contrasena' => $validatedData['contrasena'],
        ]);

        $empleado = Empleado::create([
            'usuario_id' => $usuario->id,
            'apellidos' => $validatedData['apellidos'],
            'tlf' => $validatedData['tlf'],
            'direccion' => $validatedData['direccion'],
            'municipio' => $validatedData['municipio'],
            'provincia' => $validatedData['provincia'],
            'anos_experiencia' => $validatedData['anos_experiencia'],
            'DNI' => $validatedData['DNI'],
        ]);

        return response()->json([$empleado, $usuario], 200);
    }

    public function addEmployee(Request $request, $id){

        try{
            $usuario = Usuario::findOrFail($id);
        }
        catch (ModelNotFoundException){
            return response()->json(['message' => 'usuario no encontrado'], 404);
        }


        $validatedData = $request->validate([
            'apellidos' => 'required|string|max:255',
            'tlf' => 'required|string|max:20',
            'direccion' => 'required|string|max:255',
            'municipio' => 'required|string|max:255',
            'provincia' => 'required|string|max:255',
            'DNI' => 'required|string|max:20|unique:empleados,DNI',
            'anos_experiencia' => 'required|integer|max:80'
        ]);

        $empleado = Empleado::create([
            'usuario_id' => $id,
            'apellidos' => $validatedData['apellidos'],
            'tlf' => $validatedData['tlf'],
            'direccion' => $validatedData['direccion'],
            'municipio' => $validatedData['municipio'],
            'provincia' => $validatedData['provincia'],
            'anos_experiencia' => $validatedData['anos_experiencia'],
            'DNI' => $validatedData['DNI'],
        ]);

        return response()->json([$empleado, $usuario], 200);
    }

    /**
     * Muestra los empelados
     */
    public function show() {

        $empleados = Empleado::with('usuario')->get();

        return response()->json($empleados, 200);
    }

    /**
     * Obtiene un empleado
     */
    public function getEmployee(Request $request, $id) {
        $empleado = Empleado::with('usuario')->find($id);

        if (!$empleado) {
            return response()->json(['message' => 'empleado no encontrado'], 404);
        }

        return response()->json($empleado, 200);
    }

    /**
     * Modifica un empleado
     */
    public function update(Request $request, $id) {
        $empleado = Empleado::find($id);
        $usuario = Usuario::find($empleado->usuario_id);

        if (!$empleado) {
            return response()->json(['message' => 'empleado no encontrado'], 404);
        }

        $validatedData = $request->validate([
            'usuario_id' => 'sometimes|exists:usuarios,id',
            'DNI' => 'sometimes|string|nullable|max:20|unique:empleados,DNI,' . $id,
            'anos_experiencia' => 'sometimes|integer|max:80',
            'nombre' => 'sometimes|string|max:255',
            'nombreUsuario' => 'sometimes|string|max:255',
            'apellidos' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:usuarios,email,' . $empleado->usuario_id,
            'tlf' => 'sometimes|string|max:20',
            'direccion' => 'sometimes|string|max:255',
            'municipio' => 'sometimes|string|max:255',
            'provincia' => 'sometimes|string|max:255',
            'contrasena' => 'sometimes|string|min:8',
        ]);

        if ($validatedData['DNI'] == "") {
            $validatedData['DNI'] = $empleado->DNI;
        }

        $empleado->update($validatedData);
        $usuario->update($validatedData);

        return response()->json($empleado->load('usuario'), 200);
    }

    /**
     * Elimina un empleado
     */
    public function delete(Request $request, $id) {
        $empleado = Empleado::find($id);
        $usuario = Usuario::find($empleado->usuario_id);

        if (!$empleado) {
            return response()->json(['message' => 'empleado no encontrado'], 404);
        }

        $empleado->delete();
        $usuario->delete();

        return response()->json(['message' => 'empleado eliminado correctamente'], 200);
    }
}
