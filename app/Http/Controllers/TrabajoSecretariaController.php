<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrabajoSecretaria;
use App\Models\ImagenesTrabajo;
use App\Models\UserLocation;
use Illuminate\Support\Facades\Storage;

class TrabajoSecretariaController extends Controller
{
    public function index()
    {
        // Cargar trabajos con sus imágenes (no eliminados)
        $trabajos = TrabajoSecretaria::with('imagenes')->get();
        return view('trabajos.index', compact('trabajos'));
    }

    // Mostrar el formulario de creación
    public function create()
    {
        return view('trabajos.create');
    }

    // Guardar los datos del formulario
    public function store(Request $request)
    {
        // Validación
        $validated = $request->validate([
            'problema' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'eje' => 'required|integer|max:255',
            'estatus' => 'required|integer|in:1,2,3', // 1=activo, 2=resuelto, 3=no resuelto
            'requerimiento' => 'required|string',
            'fotos' => 'required|array|min:1|max:5',
            'fotos.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'fecha_desde' => 'nullable|date',  // Validación para fecha desde
            'fecha_hasta' => 'nullable|date',  // Validación para fecha hasta
        ], [
            'fotos.max' => 'Puedes subir un máximo de 5 imágenes.',
            'fotos.min' => 'Debes subir al menos una imagen.',
        ]);

        $trabajo = TrabajoSecretaria::create([
            'problema' => $validated['problema'],
            'direccion' => $validated['direccion'],
            'eje' => $validated['eje'],
            'estatus' => $validated['estatus'],
            'requerimientos' => $validated['requerimiento'],
            'fecha_desde' => $validated['fecha_desde'],
            'fecha_hasta' => $validated['fecha_hasta'],
        ]);

        // Manejar las imágenes
        if ($request->hasfile('fotos')) {
            foreach ($request->file('fotos') as $image) {
                $path = $image->store('imagenes_trabajo', 'public'); // Almacena en storage/app/public/imagenes_trabajo
                ImagenesTrabajo::create([
                    'trabajo_id' => $trabajo->id,
                    'imagen_path' => $path,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Formulario guardado con éxito.');
    }

    public function edit($id)
    {
        $trabajo = TrabajoSecretaria::with('imagenes')->findOrFail($id);
        return view('trabajos.edit', compact('trabajo'));
    }

    public function update(Request $request, $id)
    {
        // Validación
        $validated = $request->validate([
            'problema' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'eje' => 'required|integer|max:255',
            'estatus' => 'required|integer|in:1,2,3', // 1=activo, 2=resuelto, 3=no resuelto
            'requerimiento' => 'required|string',
            'fotos' => 'array|max:5',
            'fotos.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'fecha_desde' => 'nullable|date',  // Validación para fecha desde
            'fecha_hasta' => 'nullable|date',  // Validación para fecha hasta
        ]);

        // Actualizar el trabajo
        $trabajo = TrabajoSecretaria::findOrFail($id);
        $trabajo->update([
            'problema' => $validated['problema'],
            'direccion' => $validated['direccion'],
            'eje' => $validated['eje'],
            'estatus' => $validated['estatus'],
            'requerimientos' => $validated['requerimiento'],
            'fecha_desde' => $validated['fecha_desde'],
            'fecha_hasta' => $validated['fecha_hasta'],
        ]);

        // Manejar las nuevas imágenes
        if ($request->hasfile('fotos')) {
            foreach ($request->file('fotos') as $image) {
                $path = $image->store('imagenes_trabajo', 'public'); // Almacena en storage/app/public/imagenes_trabajo
                ImagenesTrabajo::create([
                    'trabajo_id' => $trabajo->id,
                    'imagen_path' => $path,
                ]);
            }
        }

        return redirect()->route('trabajos.index')->with('success', 'Trabajo actualizado con éxito.');
    }

    public function destroy($id)
    {
        $trabajo = TrabajoSecretaria::findOrFail($id);
        
        // Eliminar imágenes asociadas
        foreach ($trabajo->imagenes as $imagen) {
            $imagen->delete();
        }
        
        // Eliminar el trabajo (soft delete)
        $trabajo->delete();
        return redirect()->route('trabajos.index')->with('success', 'Trabajo eliminado con éxito.');
    }

    public function g_ubi(Request $request)
    {
        $data = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'device_id' => 'required|string',
        ]);

        UserLocation::create([
            'device_id' => $data['device_id'],
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
        ]);

        return response()->json(['message' => 'guardada exitosamente.']);
    }

    public function destroyImage($id)
    {
        $imagen = ImagenesTrabajo::findOrFail($id);
        $imagen->delete(); // Elimina el registro de la base de datos

        return response()->json(['message' => 'Imagen eliminada con éxito.']);
    }

}
