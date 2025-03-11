<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servicio;

/**
 * Clase Controlador de Servicios
 */
class ServiceController extends Controller
{
    /**
     * Añade un servicio
     */
    public function add(Request $request) {
        $validatedData = $request->validate([
            'servicio.nombre' => 'required|string|max:255',
            'servicio.descripcion' => 'required|string|max:255',
            'servicio.duracion' => 'required|integer|max:3',
            'servicio.precio' => 'required|decimal:2|max:20',
        ]);

        $servicio = Servicio::create([

            'nombre' => $validatedData['servicio']['nombre'],
            'descripcion' => $validatedData['servicio']['descripcion'],
            'duracion' => $validatedData['servicio']['duracion'],
            'precio' => $validatedData['servicio']['precio'],
        ]);

        return response()->json($servicio->load('servicio'), 201);
    }

    /**
     * Muestra los servicios
     */
    public function show() {
        $servicios = Servicio::with('servicio')->get();

        return response()->json($servicios, 200);
    }

    /**
     * Obtiene un servicio
     */
    public function getService($id) {
        $servicio = Servicio::with('servicio')->find($id);

        if (!$servicio) {
            return response()->json(['message' => 'servicio no encontrado'], 404);
        }

        return response()->json($servicio, 200);
    }

    /**
     * Modifica un servicio
     */
    public function update(Request $request, $id) {
        $servicio = Servicio::with('servicio')->find($id);

        if (!$servicio) {
            return response()->json(['message' => 'servicio no encontrado'], 404);
        }

        $validatedData = $request->validate([
            'servicio_id' => 'sometimes|exists:servicios,id',
            'servicio.nombre' => 'sometimes|string|max:255',
            'servicio.descripcion' => 'sometimes|string|max:255',
            'servicio.duracion' => 'sometimes|integer|max:3',
            'servicio.precio' => 'sometimes|decimal:2|max:20',
        ]);

        $servicio->update($validatedData);

        return response()->json($servicio->load('servicio'), 201);
    }
    /**
     * Elimina un servicio
     */
    public function delete($id) {
        $servicio = Servicio::with('servicio')->find($id);

        if (!$servicio) {
            return response()->json(['message' => 'servicio no encontrado'], 404);
        }

        $servicio->delete();

        return response()->json(['message' => 'Servicio eliminado correctamente'], 200);
    }
}
