<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventarios\Equipo;
use App\Models\Inventarios\Dependencia;
use App\Models\Inventarios\TipoEquipo;
use Illuminate\Http\Request;

class InventarioGeneralController extends Controller
{
    public function index(Request $request)
    {
        $q   = trim((string) $request->get('q', ''));
        $dep = $request->get('dependencia_id');
        $tip = $request->get('tipo_equipo_id');
        $est = $request->get('estado');

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
            ->paginate(15)
            ->withQueryString();

        $dependencias = Dependencia::orderBy('nombre')->get(['id','nombre']);
        $tipos        = TipoEquipo::orderBy('nombre')->get(['id','nombre']);
        $estados      = ['En Almacén','Asignado','En Préstamo','En Mantenimiento','Baja'];

        return view('inventario.general', compact('equipos','dependencias','tipos','estados'));
    }
}
