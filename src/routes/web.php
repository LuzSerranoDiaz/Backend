<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::get('/', function () {
    return view('welcome');
});

<<<<<<< HEAD
//Route::prefix('api')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
//});
Route::get('login', [AuthController::class, 'login']);
=======

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::get('userProfile', [AuthController::class, 'userProfile']);
    Route::get('logout', [AuthController::class, 'logout']);
});
>>>>>>> cd43d6e7a669aa3e86c738941981f08a1c037f4e
