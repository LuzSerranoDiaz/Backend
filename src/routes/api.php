<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::get('/', function () {
    return view('welcome');
});

//Route::prefix('api')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
//});
Route::get('login', [AuthController::class, 'login']);
