<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Asistencia;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EmpleadoController extends Controller
{

    public function index()
    {
        $empleados = Empleado::all(); // Obtener todos los empleados
        return view('empleados.index', compact('empleados'));
    }
    
    // Mostrar el formulario para registrar empleados
    public function create()
    {
        return view('empleados.create');
    }

    // Guardar la información del empleado
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'cedula' => 'required|numeric|unique:empleados',
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'correo' => 'required|string|email|max:255|unique:empleados',
            'telefono' => 'required|string|max:255',
            'grado_instruccion' => 'required|string|max:255',
            'estatus' => 'required|integer',
        ]);

        Empleado::create($validatedData);

        return redirect()->route('empleados.create')->with('success', 'Empleado registrado exitosamente.');
    }

    public function edit($id)
    {
        $empleado = Empleado::findOrFail($id);
        return view('empleados.edit', compact('empleado'));
    }

    // Método para actualizar la información del empleado
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'cedula' => 'required|numeric|unique:empleados,cedula,' . $id,
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'correo' => 'required|string|email|max:255|unique:empleados,correo,' . $id,
            'telefono' => 'required|string|max:255',
            'grado_instruccion' => 'required|string|max:255',
            'estatus' => 'required|integer',
        ]);

        $empleado = Empleado::findOrFail($id);
        $empleado->update($validatedData);

        return redirect()->route('empleados.index')->with('success', 'Empleado actualizado exitosamente.');
    }

    // Método para eliminar el empleado (soft delete)
    public function destroy($id)
    {
        $empleado = Empleado::findOrFail($id);
        $empleado->delete();

        return redirect()->route('empleados.index')->with('success', 'Empleado eliminado exitosamente.');
    }

    // Mostrar el formulario para ingresar la cédula
    public function ingresarCedula()
    {
        return view('empleados.ingresar_cedula');
    }

    // Validar la cédula y registrar asistencia
    public function validarCedula(Request $request)
    {
        $request->validate([
            'cedula' => 'required|numeric|exists:empleados,cedula'
        ], [
            'cedula.required' => 'La cédula es requerida.',
            'cedula.numeric' => 'La cédula debe ser un número.',
            'cedula.exists' => 'La cédula no está registrada en el sistema.'
        ]);

        $empleado = Empleado::where('cedula', $request->cedula)->first();

        if($empleado) {
            $hoy = Carbon::today(); // Obtiene la fecha de hoy con hora 00:00:00

            $asistencia = Asistencia::where('empleado_id', $empleado->id)
                ->whereDate('created_at', $hoy) // Compara solo la fecha
                ->first();

            if ($asistencia) {
                return redirect()->route('empleados.ingresar_cedula')->withErrors(['empleado_id' => 'El empleado ya marcó asistencia.']);
            }else{
                Asistencia::create([
                    'empleado_id' => $empleado->id,
                ]);

                return redirect()->route('empleados.ingresar_cedula')->with('success', 'Asistencia registrada exitosamente.');
            }
        } else {
            return redirect()->route('empleados.ingresar_cedula')->with('error', 'Empleado no registrado.');
        }
    }

}

