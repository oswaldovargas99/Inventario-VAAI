<?php

namespace App\Http\Controllers\Admin;

use App\Enums\EstadoAprobacion;
use App\Enums\MovimientoTipo;
use App\Http\Controllers\Controller;
use App\Http\Requests\Inventarios\MovimientoStoreRequest;
use App\Http\Requests\Inventarios\MovimientoUpdateRequest;
use App\Models\Inventarios\Dependencia;
use App\Models\Inventarios\Equipo;
use App\Models\Inventarios\Movimiento;
use App\Models\User;
use Illuminate\Http\Request;


class MovimientoController extends Controller
{


    public function index(Request $request)
    {
        $query = Movimiento::query()
            ->with(['equipo','responsable','usuarioAsignado','dependenciaOrigen','dependenciaDestino'])
            ->latest('fecha_movimiento');

        if ($t = $request->get('tipo_movimiento')) {
            $query->where('tipo_movimiento', $t);
        }
        if ($e = $request->get('estado_aprobacion')) {
            $query->where('estado_aprobacion', $e);
        }
        if ($dep = $request->get('dependencia_id')) {
            $query->where(function($q) use ($dep) {
                $q->where('dependencia_origen_id', $dep)
                  ->orWhere('dependencia_destino_id', $dep);
            });
        }
        if ($desde = $request->get('desde')) {
            $query->whereDate('fecha_movimiento', '>=', $desde);
        }
        if ($hasta = $request->get('hasta')) {
            $query->whereDate('fecha_movimiento', '<=', $hasta);
        }

       if ($resguardanteId = $request->get('resguardante_id')) {
            $query->where('usuario_asignado_id', $resguardanteId);
        }




        if ($equipoQ = trim($request->get('equipo_q'))) {
            $query->whereHas('equipo', function ($q) use ($equipoQ) {
                $q->where('numero_serie', 'like', "%{$equipoQ}%")
                  ->orWhere('id_activo_fijo', 'like', "%{$equipoQ}%")
                  ->orWhere('marca', 'like', "%{$equipoQ}%")
                  ->orWhere('modelo', 'like', "%{$equipoQ}%");
            });
        }

        $movimientos = $query->paginate(20)->withQueryString();
        $usuariosParaFiltro = User::orderBy('name')->get(['id','name']);

        return view('admin.movimientos.index', [
            'movimientos' => $movimientos,
            'tipos' => MovimientoTipo::values(),
            'estados' => EstadoAprobacion::values(),
            'dependencias' => Dependencia::orderBy('nombre')->get(['id','nombre']),
            'equipo_q' => $equipoQ,
             'usuarios' => $usuariosParaFiltro,
        ]);
    }

    public function create()
    
    {
        return view('admin.movimientos.create', [
            
            /*'equipos' => Equipo::with('tipo')
                            ->orderBy('numero_serie')
                            ->limit(100)
                            ->get(['id','numero_serie','descripcion','dependencia_id','tipo_equipo_id', 'id_activo_fijo']),*/
            'usuarios' => User::orderBy('name')->get(['id','name']),
            'dependencias' => Dependencia::orderBy('nombre')->get(['id','nombre']),
            'tipos' => MovimientoTipo::values(),
        ]);
    }

    public function store(MovimientoStoreRequest $request)
    {
        $data = $request->validated();
        $data['responsable_id'] = $request->user()->id;
        $data['estado_aprobacion'] = EstadoAprobacion::Pendiente->value;
 
 
      //  dd($request->all(), $request->validated(), 'Antes de crear movimiento');
        
        Movimiento::create($data);

        return redirect()->route('admin.movimientos.index')->with('success', 'Movimiento registrado y enviado a aprobación.');
    }

    public function edit(Movimiento $movimiento)
    {
        // Solo editable si sigue Pendiente
        $this->authorize('update', $movimiento);

        return view('admin.movimientos.edit', [
            'movimiento' => $movimiento->load(['equipo.tipo']),
         /*   'equipos' => Equipo::with('tipo')
                               ->orderBy('numero_serie')
                               ->limit(100)
                               ->get(['id','numero_serie','descripcion','dependencia_id','tipo_equipo_id']),*/
            'usuarios' => User::orderBy('name')->get(['id','name']),
            'dependencias' => Dependencia::orderBy('nombre')->get(['id','nombre']),
            'tipos' => MovimientoTipo::values(),
        ]);
    }

    public function update(MovimientoUpdateRequest $request, Movimiento $movimiento)
    {
        $this->authorize('update', $movimiento);

        if ($movimiento->estado_aprobacion !== EstadoAprobacion::Pendiente) {
            return back()->with('error','No se puede editar un movimiento ya revisado.');
        }

        $movimiento->update($request->validated());

        return redirect()->route('admin.movimientos.index')->with('success', 'Movimiento actualizado.');
    }

    public function destroy(Movimiento $movimiento)
    {
        if ($movimiento->estado_aprobacion !== EstadoAprobacion::Pendiente) {
            return back()->with('error','No se puede eliminar un movimiento ya revisado.');
        }
        $movimiento->delete();

        return redirect()->route('admin.movimientos.index')->with('success', 'Movimiento eliminado.');
    }

    // === Flujo de aprobación ===

    public function aprobarPatrimonio(Request $request, Movimiento $movimiento)
    {
        // Rol Aprobador
        $this->authorize('approve', $movimiento);

        if ($movimiento->estado_aprobacion !== EstadoAprobacion::Pendiente) {
            return back()->with('error','El movimiento ya fue revisado por Patrimonio.');
        }

        $movimiento->update([
            'estado_aprobacion' => EstadoAprobacion::AprobadoPatrimonio,
            'aprobador_id' => $request->user()->id,
            'fecha_aprobacion' => now(),
            'comentarios_aprobacion' => $request->input('comentarios_aprobacion'),
        ]);

        return back()->with('success','Movimiento aprobado por Patrimonio. Pendiente VoBo Secretaría.');
    }

    public function aprobarSecretaria(Request $request, Movimiento $movimiento)
    {
        // Rol Secretario
        $this->authorize('approve', $movimiento);

        if ($movimiento->estado_aprobacion !== EstadoAprobacion::AprobadoPatrimonio) {
            return back()->with('error','Para VoBo Secretaría el movimiento debe estar Aprobado por Patrimonio.');
        }

        $movimiento->update([
            'estado_aprobacion' => EstadoAprobacion::AprobadoSecretaria,
            'aprobador_id' => $request->user()->id,
            'fecha_aprobacion' => now(),
            'comentarios_aprobacion' => $request->input('comentarios_aprobacion'),
        ]);

        // El Observer realizará el impacto en el Equipo.
        return back()->with('success','VoBo Secretaría otorgado. Se aplicaron cambios al equipo.');
    }

    public function rechazar(Request $request, Movimiento $movimiento)
    {
        $this->authorize('approve', $movimiento);

        if (!in_array($movimiento->estado_aprobacion->value, [
            EstadoAprobacion::Pendiente->value,
            EstadoAprobacion::AprobadoPatrimonio->value
        ], true)) {
            return back()->with('error','No es posible rechazar en el estado actual.');
        }

        $request->validate([
            'comentarios_aprobacion' => ['required','string','min:5']
        ]);

        $movimiento->update([
            'estado_aprobacion' => EstadoAprobacion::Rechazado,
            'aprobador_id' => $request->user()->id,
            'fecha_aprobacion' => now(),
            'comentarios_aprobacion' => $request->input('comentarios_aprobacion'),
        ]);

        return back()->with('warning','Movimiento rechazado y registrado para auditoría.');
    }

    
    public function show(Movimiento $movimiento)
    {
        
        $movimiento->load([
            'equipo.tipo',
            'responsable',
            'usuarioAsignado',
            'dependenciaOrigen',
            'dependenciaDestino'
        ]);

        return view('admin.movimientos.show', compact('movimiento'));
    }
}
