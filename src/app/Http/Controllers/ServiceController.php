<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servicio;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Clase Controlador de Servicios
 */
class ServiceController extends Controller
{
    /**
     * Añade un servicio
     */
    public function add(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
            'duracion' => 'required|integer',
            'precio' => 'required|decimal:2|max:20',
        ]);

        $servicio = Servicio::create([
            'nombre' => $validatedData['nombre'],
            'descripcion' => $validatedData['descripcion'],
            'duracion' => $validatedData['duracion'],
            'precio' => $validatedData['precio'],
        ]);

        return response()->json($servicio, 201);
    }

    /**
     * Muestra los servicios
     */
    public function show()
    {
        $servicios = Servicio::all();

        return response()->json($servicios, 200);
    }

    /**
     * Obtiene un servicio
     */
    public function getService($id)
    {
        try{
            $servicio = Servicio::findOrFail($id);
        }
        catch (ModelNotFoundException){
            return response()->json(['message' => 'servicio no encontrado'], 404);
        }

        return response()->json($servicio, 200);
    }

    /**
     * Modifica un servicio
     */
    public function update(Request $request, $id)
    {
        try{
            $servicio = Servicio::findOrFail($id);
        }
        catch (ModelNotFoundException){
            return response()->json(['message' => 'servicio no encontrado'], 404);
        }
        

        $validatedData = $request->validate([
            'servicio_id' => 'sometimes|exists:servicios,id,' . $id,
            'nombre' => 'sometimes|string|max:255',
            'descripcion' => 'sometimes|string|max:255',
            'duracion' => 'sometimes|integer|',
            'precio' => 'sometimes|decimal:2|max:20',
        ]);

        $servicio->update($validatedData);

        return response()->json($servicio, 201);
    }
    /**
     * Elimina un servicio
     */
    public function delete($id)
    {
        try{
            $servicio = Servicio::findOrFail($id);
        }
        catch (ModelNotFoundException){
            return response()->json(['message' => 'servicio no encontrado'], 404);
        }

        $servicio->delete();

        return response()->json(['message' => 'Servicio eliminado correctamente'], 200);
    }
}
