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
    public function add(Request $request) {
        $validatedData = $request->validate([
            'usuario.nombre' => 'required|string|max:255',
            'nombreUsuario' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'usuario.email' => 'required|email|unique:usuarios,email',
            'usuario.tlf' => 'required|string|max:20',
            'usuario.direccion' => 'required|string|max:255',
            'usuario.municipio' => 'required|string|max:255',
            'usuario.provincia' => 'required|string|max:255',
            'usuario.contrasena' => 'required|string|min:8',
            'DNI' => 'required|string|max:20|unique:clientes,DNI',
        ]);

        $usuario = Usuario::create([
            'nombre' => $validatedData['usuario']['nombre'],
            'nombreUsuario' => $validatedData['usuario']['nombreUsuario'],
            'email' => $validatedData['usuario']['email'],
            'contrasena' => $validatedData['usuario']['contrasena'],
        ]);

        $cliente = Cliente::create([
            'usuario_id' => $usuario->id,
            'apellidos' => $validatedData['usuario']['apellidos'],
            'tlf' => $validatedData['usuario']['tlf'],
            'direccion' => $validatedData['usuario']['direccion'],
            'municipio' => $validatedData['usuario']['municipio'],
            'provincia' => $validatedData['usuario']['provincia'],
            'DNI' => $validatedData['DNI'],
        ]);

        return response()->json($cliente, 201);
    }

    /**
     * Muestra los clientes
     */
    public function show() {
        $clientes = Cliente::with('usuario')->get();

        return response()->json($clientes, 200);
    }

    /**
     * Obtiene un cliente
     */
    public function getCustomer($id) {
        $cliente = Cliente::with('usuario')->find($id);

        if (!$cliente) {
            return response()->json(['message' => 'Cliente no encontrado'], 404);
        }

        return response()->json($cliente, 200);
    }

    /**
     * Actualiza un cliente y su usuario asociado
     */
    public function update(Request $request, $id) {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response()->json(['message' => 'Cliente no encontrado'], 404);
        }

        $validatedData = $request->validate([
            'usuario_id' => 'sometimes|exists:usuarios,id',
            'DNI' => 'sometimes|string|max:20|unique:clientes,DNI,' . $id,
            'usuario.nombre' => 'sometimes|string|max:255',
            'nombreUsuario' => 'sometimes|string|max:255',
            'usuario.apellidos' => 'sometimes|string|max:255',
            'usuario.email' => 'sometimes|email|unique:usuarios,email,' . $cliente->usuario_id,
            'usuario.tlf' => 'sometimes|string|max:20',
            'usuario.direccion' => 'sometimes|string|max:255',
            'usuario.municipio' => 'sometimes|string|max:255',
            'usuario.provincia' => 'sometimes|string|max:255',
        ]);

        $cliente->update($validatedData);

        if ($request->has('usuario')) {
            $usuarioData = $request->input('usuario');
            $cliente->usuario->update($usuarioData);
        }

        return response()->json($cliente->load('usuario'), 200);
    }

    /**
     * Elimina un cliente
     */
    public function delete($id) {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response()->json(['message' => 'Cliente no encontrado'], 404);
        }

        $cliente->delete();

        return response()->json(['message' => 'Cliente eliminado correctamente'], 200);
    }
}
