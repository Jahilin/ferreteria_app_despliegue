<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProductoController; //Se añade esta ruta
use App\Http\Controllers\API\RecursosHumanosController; //Se agrega esta ruta

use App\Http\Controllers\Api\AuthController; //Agregado

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('productos', ProductoController::class); //Productos
Route::apiResource('empleados', RecursosHumanosController::class); //RRHH

Route::post('/login', [AuthController::class, 'login']); //Dirige a loguearse
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('productos', ProductoController::class)->names('api.productos'); //renombrar
});
