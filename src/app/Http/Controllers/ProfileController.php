<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

/**
 * Clase Controlador Perfil de un Usuario
 */
class ProfileController extends Controller
{
    /**
     * Completa los campos de cliente
     * 
     */
    public function add(Request $request) {
        // Obtener el usuario autenticado
        $user = Auth::user();

        // Validar los datos de entrada
        $validatedData = $request->validate([
            'apellidos' => 'required|string|max:255',
            'tlf' => 'required|string|max:20',
            'direccion' => 'required|string|max:255',
            'municipio' => 'required|string|max:255',
            'provincia' => 'required|string|max:255',
            'DNI' => 'required|string|max:9',
        ]);

        // Crear el cliente y asociarlo con el usuario
        $cliente = Cliente::create([
            'usuario_id' => $user->id,  // Asociar el cliente al usuario autenticado
            'apellidos' => $validatedData['apellidos'],
            'tlf' => $validatedData['tlf'],
            'direccion' => $validatedData['direccion'],
            'municipio' => $validatedData['municipio'],
            'provincia' => $validatedData['provincia'],
            'DNI' => $validatedData['DNI'],
        ]);

        // Respuesta exitosa
        return response()->json([
            'message' => 'Cliente creado y asociado al usuario exitosamente',
            'cliente' => $cliente,
            'usuario' => [
                'id' => $user->id,
                'nombre' => $user->nombre,
                'nombreUsuario' => $user->nombreUsuario,
                'email' => $user->email,
            ]
        ], 201);
    }
    

    /**
     * Actualiza los campos
     * 
     */
    public function update(Request $request) {
        // Obtener el usuario autenticado
        $user = Auth::user();

        // Validar los datos para el usuario
        $validatedUserData = $request->validate([
            'nombre' => 'sometimes|required|string|max:255',
            'nombreUsuario' => 'sometimes|required|string|max:255|unique:usuarios,nombreUsuario,' . $user->id,
            'email' => 'sometimes|required|email|unique:usuarios,email,' . $user->id,
        ]);

        // Validar los datos para el cliente
        $validatedClientData = $request->validate([
            'apellidos' => 'sometimes|required|string|max:255',
            'tlf' => 'sometimes|required|string|max:20',
            'direccion' => 'sometimes|required|string|max:255',
            'municipio' => 'sometimes|required|string|max:255',
            'provincia' => 'sometimes|required|string|max:255',
            'DNI' => 'sometimes|required|string|max:9',
        ]);

        // Actualizar los datos del usuario
        if ($validatedUserData) {
            $user->update($validatedUserData);
        }

        // Actualizar los datos del cliente
        $cliente = $user->cliente; // Obtener el cliente asociado al usuario
        if ($validatedClientData && $cliente) {
            $cliente->update($validatedClientData);
        }

        // Respuesta exitosa con los datos actualizados
        return response()->json([
            'message' => 'Datos de usuario y cliente actualizados exitosamente',
            'usuario' => $user,
            'cliente' => $cliente,
        ], 200);
    }
}
