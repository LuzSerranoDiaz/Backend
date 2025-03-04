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

        // Crear el usuario sin encriptar la contraseña
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

        // Respuesta exitosa
        return response()->json([
            'message' => 'Usuario registrado exitosamente',
            'usuario' => $usuario,
        ], 201);
    }

    /**
     * Inicio de sesión.
     */
    public function login(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'email' => 'required|email',
            'contrasena' => 'required|min:8',
        ]);

        // Buscar al usuario por email
        $user = Usuario::where('email', $request->email)->first();

        // Verificar si el usuario existe y la contraseña es correcta
        if (!$user || $user->contrasena !== $request->contrasena) { // Comparar directamente
            return response()->json([
                'message' => 'Credenciales inválidas',
            ], 401);
        }

        return response()->json([
            'message' => 'Estas logeado',
            'token_type' => 'Bearer',
        ]);
    }


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
        
    }

    //todo: error en auth->user() porque hace falta configurar sanctum para la autenticacion
}
