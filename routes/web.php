<?php

use App\Http\Controllers\ProductoController;
use App\Http\Controllers\EmpleadoController;

Route::resource('productos', ProductoController::class);
Route::resource('empleados', EmpleadoController::class);

//cambio:
Route::get('/', function () {
    return redirect()->route('productos.index');
});
