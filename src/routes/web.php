<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\PageController;


// Ruta hacia la página Pedir Cita
Route::get('/pedir-cita', function () {
    return view('pedir-cita');
})->name('pedir-cita');

// Ruta hacia la página Historial de Citas
Route::get('/citas-admin', function () {
    return view('citas-admin');
})->name('citas-admin');

// Ruta hacia la página Empleados
Route::get('/empleados-admin', function () {
    return view('empleados-admin');
})->name('empleados-admin');

// Ruta hacia la página Servicios
Route::get('/servicios-admin', function () {
    return view('servicios-admin');
})->name('servicios-admin');

// Rutas registro y login
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
// Ruta logout con middleware
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::get('/', [PageController::class, 'index'])->name('index');
Route::get('/acerca-de', [PageController::class, 'acercaDe'])->name('acerca-de');
Route::get('/equipo', [PageController::class, 'equipo'])->name('equipo');
Route::get('/servicios', [PageController::class, 'servicios'])->name('servicios');
Route::get('/contacto', [PageController::class, 'contacto'])->name('contacto');
Route::get('/portada', [PageController::class, 'portada'])->name('portada');