<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Usuario;

/**
 * Clase Controlador de Cliente y su usuario asociado
 */
class CustomerController extends Controller
{
    /**
     * Añade un cliente y un usuario asociado
     * 
     * todo: le tengo que añadir tambien la contrasena
     */
    public function add(Request $request)
    {
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
            'DNI' => 'required|string|max:20|unique:clientes,DNI',
        ]);

        $usuario = Usuario::create([
            'nombre' => $validatedData['nombre'],
            'nombreUsuario' => $validatedData['nombreUsuario'],
            'email' => $validatedData['email'],
            'contrasena' => $validatedData['contrasena'],
        ]);

        $cliente = Cliente::create([
            'usuario_id' => $usuario->id,
            'apellidos' => $validatedData['apellidos'],
            'tlf' => $validatedData['tlf'],
            'direccion' => $validatedData['direccion'],
            'municipio' => $validatedData['municipio'],
            'provincia' => $validatedData['provincia'],
            'DNI' => $validatedData['DNI'],
        ]);

        return response()->json($cliente->load('usuario'), 200);
    }

    /**
     * Añade un cliente con un usuario ya creado
     */

    public function addClient(Request $request, $id)
    {
        $validatedData = $request->validate([
            'apellidos' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email',
            'tlf' => 'required|string|max:20',
            'direccion' => 'required|string|max:255',
            'municipio' => 'required|string|max:255',
            'provincia' => 'required|string|max:255',
            'DNI' => 'required|string|max:20|unique:clientes,DNI',
        ]);

        $cliente = Cliente::create([
            'usuario_id' => $id,
            'apellidos' => $validatedData['apellidos'],
            'tlf' => $validatedData['tlf'],
            'direccion' => $validatedData['direccion'],
            'municipio' => $validatedData['municipio'],
            'provincia' => $validatedData['provincia'],
            'DNI' => $validatedData['DNI'],
        ]);

        return response()->json($cliente->load('usuario'), 200);
    }

    /**
     * Muestra los clientes
     */
    public function show()
    {
        $clientes = Cliente::with('usuario')->get();

        return response()->json($clientes, 200);
    }

    /**
     * Obtiene un cliente
     */
    public function getCustomer($id)
    {
        $cliente = Cliente::with('usuario')->find($id);

        if (!$cliente) {
            return response()->json(['message' => 'Cliente no encontrado'], 404);
        }

        return response()->json($cliente, 200);
    }

    /**
     * Actualiza un cliente y su usuario asociado
     */
    public function update(Request $request, $id)
    {
        $cliente = Cliente::find($id);
        $usuario = Usuario::find($cliente->usuario_id);

        if (!$cliente) {
            return response()->json(['message' => 'Cliente no encontrado'], 404);
        }

        $validatedData = $request->validate([
            'usuario_id' => 'sometimes|exists:usuarios,id',
            'DNI' => 'sometimes|string|nullable|max:20|unique:clientes,DNI,' . $id,
            'nombre' => 'sometimes|string|max:255',
            'nombreUsuario' => 'sometimes|string|max:255',
            'apellidos' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:usuarios,email,' . $cliente->usuario_id,
            'tlf' => 'sometimes|string|max:20',
            'direccion' => 'sometimes|string|max:255',
            'municipio' => 'sometimes|string|max:255',
            'provincia' => 'sometimes|string|max:255',
            'contrasena' => 'sometimes|string|min:8',
        ]);

        if ($validatedData['DNI'] == "") {
            $validatedData['DNI'] = $empleado->DNI;
        }

        $cliente->update($validatedData);
        $usuario->update($validatedData);

        return response()->json($cliente->load('usuario'), 200);
    }

    /**
     * Elimina un cliente
     */
    public function delete($id)
    {
        $cliente = Cliente::find($id);
        $usuario = Usuario::find($cliente->usuario_id);

        if (!$cliente) {
            return response()->json(['message' => 'Cliente no encontrado'], 404);
        }

        $cliente->delete();
        $usuario->delete();

        return response()->json(['message' => 'Cliente eliminado correctamente'], 200);
    }
}
