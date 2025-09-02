<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventarios\Equipo;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function adminIndex(Request $request)
    {
        $totalEquipos        = Equipo::count();
        $equiposAsignados    = Equipo::where('estado', 'Asignado')->count();
        $equiposEnAlmacen    = Equipo::where('estado', 'En Almacén')->count();
        $equiposEnMantenimiento = Equipo::where('estado', 'En Mantenimiento')->count();

        // Puedes pasar los datos compactados a la vista
        return view('dashboard', compact(
            'totalEquipos',
            'equiposAsignados',
            'equiposEnAlmacen',
            'equiposEnMantenimiento'
        ));
    }

    public function panelIndex(Request $request)
    {
        // Podrías tener lógica diferente o la misma si los KPIs son universales
        return $this->adminIndex($request); // Ejemplo simple, reutilizando lógica
    }
}