<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        {
        $empleados = Empleado::latest()->paginate(10);
        return view('empleados.index', compact('empleados'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('empleados.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'identidad'       => 'required|digits:13|unique:empleados,identidad',
            'nombre'          => 'required|max:255',
            'apellido'        => 'nullable|max:255',
            'cargo'           => 'required',
            'codigo_empleado' => 'nullable|digits:13|unique:empleados,codigo_empleado',
            'salario'         => 'required|numeric|min:0',
            'fecha_ingreso'   => 'required|date',
        ]);

        Empleado::create($request->all());

        return redirect()->route('empleados.index')
            ->with('success', '¡Empleado registrado correctamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Empleado $empleado)
    {
        return redirect()->route('empleados.edit', $empleado);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Empleado $empleado)
    {
        return view('empleados.edit', compact('empleado'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Empleado $empleado)
    {
        $request->validate([
            'identidad'       => 'nullable|digits:13',
            'nombre'          => 'required|max:255',
            'apellido'        => 'nullable|max:255',
            'cargo'           => 'required',
            'codigo_empleado' => 'nullable|digits:13|unique:empleados,codigo_empleado',
            'salario'         => 'required|numeric|min:0',
            'fecha_ingreso'   => 'required|date',
        ]);

        $empleado->update($request->all());

        return redirect()->route('empleados.index')
            ->with('success', '¡Empleado actualizado correctamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Empleado $empleado)
    {
        $empleado->delete();
        return redirect()->route('empleados.index')
                         ->with('success', '¡Empleado eliminado correctamente!');
    }
}


