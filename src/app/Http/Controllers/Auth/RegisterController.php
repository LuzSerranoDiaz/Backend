<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * Donde redirigir a los usuarios después del registro.
     *
     * @var string
     */
    // protected $redirectTo = '/home';

    /**
     * Manejar una solicitud de registro.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $user = new Usuario();
    $user->nombre = "Juan Perez";
    $user->email = "juan@example.com";
    $user->contrasena = "12345678";
        // Validar los datos de entrada
        /*$validator = $this->validator($request->all());

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        // Crear el usuario
        $usuario = $this->create($request->all());

        return response()->json([
            'message' => 'Usuario registrado exitosamente',
            'usuario' => $usuario,
        ], 201);
    }

    /**
     * Obtener un validador para una solicitud de registro entrante.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
   /* protected function validator(array $data)
    {
        return Validator::make($data, [
            'nombre' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:usuarios'], 
            'contrasena' => ['required', 'string', 'min:8', 'confirmed'], 
        ]);
    }

    /**
     * Crear una nueva instancia de usuario después de un registro válido.
     *
     * @param  array  $data
     * @return \App\Models\Usuario
     */
   /* protected function create(array $data)
    {
        return Usuario::create([
            'nombre' => $data['nombre'], 
            'email' => $data['email'],
            'contrasena' => Hash::make($data['contrasena']), 
        ]);*/
    }

    
}