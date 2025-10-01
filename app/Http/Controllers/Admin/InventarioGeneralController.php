<?php

namespace App\Http\Controllers\Admin; // O el namespace adecuado, ej. App\Http\Controllers\Inventarios

use App\Http\Controllers\Controller;
use App\Models\Inventarios\Equipo; // Asegúrate de importar el modelo Equipo
use App\Models\Inventarios\TipoEquipo; // Importa TipoEquipo
use App\Models\Inventarios\Dependencia; // Importa Dependencia
use Illuminate\Http\Request;

class InventarioGeneralController extends Controller
{
    public function index(Request $request)
    {
        // Lógica para obtener los filtros del request (idéntica a EquipoController@index)
        $q   = trim((string) $request->get('q', ''));
        $dep = $request->get('dependencia_id');
        $tip = $request->get('tipo_equipo_id');
        $est = $request->get('estado');

        // Lógica para obtener los equipos filtrados (idéntica a EquipoController@index)
        $equipos = Equipo::query()
            ->with(['dependencia','tipo'])
            ->when($q, function($qq) use ($q) {
                $qq->where(function($w) use ($q) {
                    $w->where('numero_serie','like',"%{$q}%")
                      ->orWhere('marca','like',"%{$q}%")
                      ->orWhere('modelo','like',"%{$q}%")
                      ->orWhere('id_activo_fijo','like',"%{$q}%")
                      ->orWhere('mac_address','like',"%{$q}%");
                });
            })
            ->when($dep, fn($qq) => $qq->where('dependencia_id', $dep))
            ->when($tip, fn($qq) => $qq->where('tipo_equipo_id', $tip))
            ->when($est, fn($qq) => $qq->where('estado', $est))
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        // Lógica para obtener los estados, dependencias y tipos (idéntica a EquipoController@index)
        /** @var array<int,string> $estados */
        $estados = ['En Almacén','Asignado','En Préstamo','En Mantenimiento','Baja'];

        $dependencias = Dependencia::orderBy('nombre')->get(['id','nombre']);
        $tipos        = TipoEquipo::orderBy('nombre')->get(['id','nombre']);

        // Pasa todas las variables a la vista 'inventario.general'
        return view('admin.equipos.index', compact('equipos','dependencias','tipos','estados','q','dep','tip','est'));
    }
}