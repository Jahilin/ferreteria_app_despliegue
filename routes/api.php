<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProductoController; //Se añade esta ruta
use App\Http\Controllers\API\RecursosHumanosController; //Se agrega esta ruta
use App\Http\Controllers\API\AuthController; //Se agrega esta ruta


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Público: Pide login
Route::post('/login', [AuthController::class, 'login']); //Dirige a loguearse
Route::apiResource('empleados', RecursosHumanosController::class)->names('api.empleados');

//se protege con un token
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('productos', ProductoController::class)->names('api.productos'); //renombrar
});
