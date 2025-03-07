<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

// Rutas de Autenticacion API
Route::post('register', [AuthController::class, 'register']);
Route::post('api/login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('getUser', [AuthController::class, 'getUser'])->middleware('auth:sanctum');

// Otra ruta de ejemplo
Route::middleware('api')->post('/data', function (Request $request) {
    return response()->json(['received' => $request->all()]);
});

