<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrabajoSecretaria;
use App\Models\Empleado;

class DashboardController extends Controller
{
    public function index()
    {
        // Obtener estatus agrupados
        $estatusCounts = TrabajoSecretaria::selectRaw('estatus, COUNT(*) as total') 
            ->groupBy('estatus')
            ->pluck('total', 'estatus')
            ->toArray();

        // Asignar nombres a los estatus
        $estatusLabels = [
            1 => 'Solicitudes',
            2 => 'Planificación',
            3 => 'Ejecución',
            3 => 'Realizado',
            3 => 'En Espera'
        ];

        // Convertir claves numéricas en etiquetas de texto
        $estatusCountsWithLabels = [];
        foreach ($estatusCounts as $estatus => $count) {
            $estatusCountsWithLabels[$estatusLabels[$estatus]] = $count;
        }

        // Obtener conteo total de empleados y trabajos
        $empleadosCount = Empleado::count();
        $trabajosCount = TrabajoSecretaria::count();

        return view('dashboard', compact('estatusCountsWithLabels', 'empleadosCount', 'trabajosCount'));
    }
}
