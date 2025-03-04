<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    /**
     * Registro de usuarios.
     */
    public function register(Request $request)
    {
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email',
            'contrasena' => 'required|string|min:8|confirmed', // 'confirmed' requiere un campo 'contrasena_confirmation'
            'tlf' => 'required|string|max:15',
            'direccion' => 'required|string|max:255',
            'municipio' => 'required|string|max:255',
            'provincia' => 'required|string|max:255',
        ]);

        // Crear el usuario con la contraseña encriptada
        $usuario = Usuario::create([
            'nombre' => $validatedData['nombre'],
            'apellidos' => $validatedData['apellidos'],
            'email' => $validatedData['email'],
            'contrasena' => $validatedData['contrasena'],
            'tlf' => $validatedData['tlf'],
            'direccion' => $validatedData['direccion'],
            'municipio' => $validatedData['municipio'],
            'provincia' => $validatedData['provincia'],
        ]);

        // Generar un token de acceso personal
        $token = $usuario->createToken('auth_token')->plainTextToken;

        // Respuesta exitosa con el token
        return response()->json([
            'message' => 'Usuario registrado exitosamente',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'email' => $usuario->email,
            'contrasena' => $validatedData['contrasena'], 
        ], 201);
    }

    /**
     * Inicio de sesión.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'contrasena' => 'required|min:8',
        ]);

        $user = Usuario::where('email', $request->email)->first();

        if (!$user || $user->contrasena !== $request->contrasena) { 
            return response()->json([
                'message' => 'Credenciales inválidas',
            ], 401);
        }

        // Generar un token para el usuario autenticado
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Inicio de sesión exitoso',
            'token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

/*
    public function userProfile(Request $request)
    {
        return response()->json([
            'message' => 'Perfil del usuario obtenido exitosamente',
            'userData' => auth()->user(),
        ], 200);
    }

    public function logout(Request $request) {
        
    }

    public function allUsers(Request $request) {
        
    }*/

}
