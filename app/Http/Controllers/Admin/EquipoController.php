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
    // Middleware aplicado desde routes/web.php (Admin|Aprobador|Secretario)

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

        /** @var array<int,string> $estados */
        $estados = ['En Almacén','Asignado','En Préstamo','En Mantenimiento','Baja'];

        $dependencias = Dependencia::orderBy('nombre')->get(['id','nombre']);
        $tipos        = TipoEquipo::orderBy('nombre')->get(['id','nombre']);

        return view('admin.equipos.index', compact('equipos','dependencias','tipos','estados','q','dep','tip','est'));
    }

    public function create()
    {
        /** @var array<int,string> $estados */
        $estados = ['En Almacén','Asignado','En Préstamo','En Mantenimiento','Baja'];

        $dependencias = Dependencia::orderBy('nombre')->get(['id','nombre']);
        $tipos        = TipoEquipo::orderBy('nombre')->get(['id','nombre']);

        return view('admin.equipos.create', compact('dependencias','tipos','estados'));
    }

    public function store(EquipoRequest $request)
    {
        try {
            $equipo = Equipo::create($request->validated());

            Log::info('Equipo creado', [
                'equipo_id' => $equipo->getKey(),
                'user_id'   => optional(Auth::user())->getAuthIdentifier(),
            ]);

            return redirect()
                ->route('admin.equipos.index')
                ->with('success','Equipo registrado correctamente.');
        } catch (Throwable $e) {
            Log::error('Error al crear equipo', [
                'error'   => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
                'payload' => $request->except(['_token']),
                'user_id' => optional(Auth::user())->getAuthIdentifier(),
            ]);

            return back()
                ->withInput()
                ->with('error','Ocurrió un error al registrar el equipo. Revisa los datos e inténtalo de nuevo.');
        }

        $target = $request->string('return') === 'inventario.general'
            ? route('inventario.general')
            : route('admin.equipos.index');

        return redirect()->to($target)->with('success','Equipo registrado correctamente.');
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

            return redirect()
                ->route('admin.equipos.index')
                ->with('success','Equipo actualizado.');
        } catch (Throwable $e) {
            Log::error('Error al actualizar equipo', [
                'equipo_id' => $equipo->getKey(),
                'error'     => $e->getMessage(),
                'trace'     => $e->getTraceAsString(),
                'payload'   => $request->except(['_token']),
                'user_id'   => optional(Auth::user())->getAuthIdentifier(),
            ]);

            return back()
                ->withInput()
                ->with('error','No se pudo actualizar el equipo. Intenta de nuevo.');
        }

        $target = $request->string('return') === 'inventario.general'
            ? route('inventario.general')
            : route('admin.equipos.index');

        return redirect()->to($target)->with('success','Equipo actualizado.');
    }

    public function destroy(Equipo $equipo)
    {
        try {
            // Placeholder Fase 5: bloqueo por movimientos "activos"
            // if ($equipo->movimientos()->whereIn('estado_aprobacion',['Pendiente','Aprobado_Patrimonio'])->exists()) {
            //     return back()->with('error','No es posible eliminar: el equipo tiene movimientos activos.');
            // }

            $equipo->delete();

            Log::warning('Equipo eliminado (soft)', [
                'equipo_id' => $equipo->getKey(),
                'user_id'   => optional(Auth::user())->getAuthIdentifier(),
            ]);

            return redirect()
                ->route('admin.equipos.index')
                ->with('success','Equipo eliminado.');
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
