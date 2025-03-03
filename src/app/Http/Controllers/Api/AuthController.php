<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request) {
        return  response()->json([
            "message" => "Estas logeado"
        ]);
    }

    public function login(Request $request) {
        
    }

    public function userProfile(Request $request) {
        
    }

    public function logout(Request $request) {
        
    }

    public function allUsers(Request $request) {
        
    }
}
