<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\ProductoResource;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Producto::latest()->paginate(10);
        return view('productos.index', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('productos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'nombre'      => 'required|max:255',
            'descripcion' => 'nullable',
            'precio'      => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
        ]);

        Producto::create($request->all());

        return redirect()->route('productos.index')
                         ->with('success', '¡Producto registrado exitosamente en el inventario!');
    }

    public function show(string $id)
    {
        /**
         * Busquedas por Id. Es un metodo GET, se instancia la clase de producto
         */
        $producto = Producto::find($id);
        if(!$producto){
            return response()->json([
                'status' => 'error',
                'message' => "El producto ID #{$id} no existe el la Ferreteria",
            ] ,404);
        }
        return response()->json([
            'status' => 'success',
            'data' => new ProductoResource($producto),
        ], 200);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
        return view('productos.edit', compact('producto'));
         
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //Actualizar
        $producto = Producto::find($id);
        if(!$producto){
            return response()->json([
                'status'    => 'error',
                'message'   => "Producto no encontrado para actualizar",
            ], 404);
        }
        $validados = $request->validate([
            'nombre'        => 'required|string|max:150',
            'descripcion'   =>  'required|string|max:200', //cambia descripción
            'precio'        => 'required|numeric|min:0.01',
            'stock'        => 'required|integer|min:0',
        ]);
        $producto->update($validados);
        return response()->json([
            'status'    => 'updated',
            'message'   => 'Producto actualizado correctamente.',
            'data'      => new ProductoResource($producto)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        $producto->delete();

        return redirect()->route('productos.index')
                         ->with('success', '¡Producto eliminado del inventario!');
    }
}
