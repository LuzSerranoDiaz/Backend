<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
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
            'nombreUsuario' => 'required|string|max:255|unique:usuarios,nombreUsuario', 
            'email' => 'required|email|unique:usuarios,email',
            'contrasena' => 'required|string|min:8|confirmed', // 'confirmed' requiere un campo 'contrasena_confirmation'
        ]);

        // Crear el usuario con la contraseña encriptada
        $usuario = Usuario::create([
            'nombre' => $validatedData['nombre'],
            'nombreUsuario' => $validatedData['nombreUsuario'],
            'email' => $validatedData['email'],
            'contrasena' => $validatedData['contrasena'], //bcrypt($validatedData['contrasena']), 
        ]);

        // Generar un token de acceso personal
        $token = $usuario->createToken('auth_token')->plainTextToken;

        // Respuesta exitosa con el token
        return response()->json([
            'message' => 'Usuario registrado exitosamente',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'nombre' => $usuario->nombre,
            'nombreUsuario' => $usuario->nombreUsuario,
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
    
    /**
     * Cierre de sesion
     */
    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Has salido de la cuenta',
        ], 200);
    }

    /**
     * Obtener credenciales de un usuario autenticado
     */
    public function getUser(Request $request) {
        // Verifica si el usuario está autenticado
        if (Auth::check()) {
            // Obtén el usuario autenticado
            $user = Auth::user();

            // Obtén el token actual del usuario
            $token = $request->bearerToken();

            // Retorna los datos del usuario en formato JSON
            return response()->json([
                'success' => true,
                'user' => $user,
                'token' => $token
            ], 200);
        }

        // Si no está autenticado, retorna un error
        return response()->json([
            'success' => false,
            'message' => 'Usuario no autenticado'
        ], 401);
    }

}
