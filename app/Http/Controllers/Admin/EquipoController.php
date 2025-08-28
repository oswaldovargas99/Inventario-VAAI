<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inventarios\EquipoRequest;
use App\Models\Inventarios\Equipo;
use App\Models\Inventarios\TipoEquipo;
use App\Models\Inventarios\Dependencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Throwable;

class EquipoController extends Controller
{

    public function index(Request $request)
    {
        // Lógica para obtener los filtros del request
        $q   = trim((string) $request->get('q', ''));
        $dep = $request->get('dependencia_id');
        $tip = $request->get('tipo_equipo_id');
        $est = $request->get('estado');

        // Lógica para obtener los equipos filtrados
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

        // Lógica para obtener los estados, dependencias y tipos
        /** @var array<int,string> $estados */
        $estados = ['En Almacén','Asignado','En Préstamo','En Mantenimiento','Baja'];

        $dependencias = Dependencia::orderBy('nombre')->get(['id','nombre']);
        $tipos        = TipoEquipo::orderBy('nombre')->get(['id','nombre']);

        // ¡CORRECCIÓN CLAVE! Pasa todas las variables a la vista 'inventario.general'
        return view('admin.equipos.index', compact('equipos','dependencias','tipos','estados','q','dep','tip','est'));
    }

    public function create()
    {
        /** @var array<int,string> $estados */
        $estados = ['En Almacén','Asignado','En Préstamo','En Mantenimiento','Baja'];

        $dependencias = Dependencia::orderBy('nombre')->get(['id','nombre']);
        $tipos        = TipoEquipo::orderBy('nombre')->get(['id','nombre']);
        $equipo = new \App\Models\Inventarios\Equipo();
        return view('admin.equipos.create', compact('dependencias','tipos','estados', 'equipo'));
    }

    public function store(EquipoRequest $request)
    {
        try {
            $equipo = Equipo::create($request->validated());

            Log::info('Equipo creado', [
                'equipo_id' => $equipo->getKey(),
                'user_id'   => optional(Auth::user())->getAuthIdentifier(),
            ]);

            session()->flash('success', '✅ Equipo agregado con éxito.');
            //dd(session()->all(), 'Después de flash en store - EquipoController');
            // Redirige siempre a inventario.general después de crear
            return redirect()->route('inventario.general');
        } catch (Throwable $e) {
            Log::error('Error al crear equipo', [
                'error'   => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
                'payload' => $request->except(['_token']),
                'user_id' => optional(Auth::user())->getAuthIdentifier(),
            ]);

            return back()->withInput()->with('error','Ocurrió un error al registrar el equipo.');
        }
    }

    public function edit(Equipo $equipo)
    {
        /** @var array<int,string> $estados */
        $estados = ['En Almacén','Asignado','En Préstamo','En Mantenimiento','Baja'];

        $dependencias = Dependencia::orderBy('nombre')->get(['id','nombre']);
        $tipos        = TipoEquipo::orderBy('nombre')->get(['id','nombre']);

        return view('admin.equipos.edit', compact('equipo','dependencias','tipos','estados'));
    }

    public function update(EquipoRequest $request, Equipo $equipo)
    {
        try {
            $equipo->update($request->validated());

            Log::info('Equipo actualizado', [
                'equipo_id' => $equipo->getKey(),
                'user_id'   => optional(Auth::user())->getAuthIdentifier(),
            ]);

            session()->flash('success', '✅ Equipo actualizado con éxito.'); // Usar flash explícitamente
            //dd(session()->all(), 'Después de flash en update - EquipoController');
            // Redirige siempre a inventario.general después de actualizar
            return redirect()->route('inventario.general');
        } catch (Throwable $e) {
            Log::error('Error al actualizar equipo', [
                'equipo_id' => $equipo->getKey(),
                'error'     => $e->getMessage(),
                'trace'     => $e->getTraceAsString(),
                'payload'   => $request->except(['_token']),
                'user_id'   => optional(Auth::user())->getAuthIdentifier(),
            ]);

            return back()->withInput()->with('error','No se pudo actualizar el equipo.');
        }
    }

    public function destroy(Request $request, Equipo $equipo)
    {
        try {
            $equipo->delete();

            Log::warning('Equipo eliminado (soft)', [
                'equipo_id' => $equipo->getKey(),
                'user_id'   => optional(Auth::user())->getAuthIdentifier(),
            ]);

            session()->flash('success', '✅ Equipo eliminado.'); // Usar flash explícitamente
            //dd(session()->all(), 'Después de flash en destroy - EquipoController');
            return redirect()->route('inventario.general');
        } catch (Throwable $e) {
            Log::error('Error al eliminar equipo', [
                'equipo_id' => $equipo->getKey(),
                'error'     => $e->getMessage(),
                'trace'     => $e->getTraceAsString(),
                'user_id'   => optional(Auth::user())->getAuthIdentifier(),
            ]);

            return back()->with('error','No se pudo eliminar el equipo.');
        }
    }
}