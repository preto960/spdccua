<?php

namespace App\Http\Controllers;

use App\Models\Cuadrilla;
use App\Models\Empleado;
use Illuminate\Http\Request;

class CuadrillaController extends Controller
{
    public function index()
    {
        $cuadrillas = Cuadrilla::with('empleados')->get();
        return view('cuadrillas.index', compact('cuadrillas'));
    }

    public function create()
    {
        // Obtén todos los empleados
        $empleados = Empleado::all();

        // Obtén los IDs de los empleados que ya están asignados a alguna cuadrilla
        $empleadosAsignados = Cuadrilla::with('empleados')->get()->pluck('empleados.*.id')->flatten()->unique();

        // Filtra los empleados disponibles
        $empleadosDisponibles = $empleados->whereNotIn('id', $empleadosAsignados);

        return view('cuadrillas.create', compact('empleadosDisponibles'));
    }

    public function store(Request $request)
    {
        // Validar los datos, empleados no es requerido
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'empleados' => 'nullable|array',
            'empleados.*' => 'exists:empleados,id',
            'estatus' => 'required|integer',
        ]);

        // Crear la cuadrilla
        $cuadrilla = Cuadrilla::create($request->only('nombre', 'descripcion', 'estatus'));

        // Asignar empleados si existen
        if ($request->has('empleados')) {
            $cuadrilla->empleados()->sync($request->input('empleados'));
        }

        return redirect()->route('cuadrillas.index')->with('success', 'Cuadrilla creada exitosamente.');
    }

    public function edit($id)
    {
        $cuadrilla = Cuadrilla::with('empleados')->findOrFail($id);
        $empleadosDisponibles = Empleado::whereDoesntHave('cuadrillas', function($query) use ($cuadrilla) {
            $query->where('cuadrilla_id', '!=', $cuadrilla->id);
        })->orWhereHas('cuadrillas', function($query) use ($cuadrilla) {
            $query->where('cuadrilla_id', $cuadrilla->id);
        })->get();

        return view('cuadrillas.edit', compact('cuadrilla', 'empleadosDisponibles'));
    }

    public function update(Request $request, $id)
    {
        // Validar los datos, empleados no es requerido
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'empleados' => 'nullable|array',
            'empleados.*' => 'exists:empleados,id',
            'estatus' => 'required|integer',
        ]);

        // Encontrar y actualizar la cuadrilla
        $cuadrilla = Cuadrilla::findOrFail($id);
        $cuadrilla->update($request->only('nombre', 'descripcion', 'estatus'));

        // Asignar empleados si existen, si no, desasignarlos
        if ($request->has('empleados')) {
            $cuadrilla->empleados()->sync($request->input('empleados'));
        } else {
            $cuadrilla->empleados()->detach();
        }

        return redirect()->route('cuadrillas.index')->with('success', 'Cuadrilla actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $cuadrilla = Cuadrilla::findOrFail($id);
        $cuadrilla->empleados()->detach();
        $cuadrilla->delete();

        return redirect()->route('cuadrillas.index')->with('success', 'Cuadrilla eliminada exitosamente.');
    }
}
