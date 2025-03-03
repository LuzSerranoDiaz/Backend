<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario; 

class AuthController extends Controller
{

    public function register(Request $request) {
        //Validacion de los datos
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios',
            'password' => 'required|min:8|confirmed'
        ]);

        // Alta usuario
        $user = new Usuario();
        $user->nombre = $request->name; 
        $user->email = $request->email; 
        $user->contrasena = $request->password; 
        $user->save();

        return  response()->json([
            "message" => "Estas registrado"
        ]);
    }

    public function login(Request $request) {
        return  response()->json([
            "message" => "Estas logeado"
        ]);
    }

    public function userProfile(Request $request) {
        
    }

    public function logout(Request $request) {
        
    }

    public function allUsers(Request $request) {
        
    }
}
