<?php

namespace App\Observers;


use App\Enums\EstadoAprobacion;
use App\Enums\MovimientoTipo;
use App\Models\Inventarios\Movimiento;
use Illuminate\Support\Facades\DB;

class MovimientoObserver
{
    /**
     * Handle the Movimiento "saved" event.
     */
    public function saved(Movimiento $mov): void
    {
        // 2. Comparamos el Enum con el Enum, no con texto.
        if ($mov->estado_aprobacion !== EstadoAprobacion::AprobadoSecretaria) {
            return;
        }

        DB::transaction(function () use ($mov) {
            $equipo = $mov->equipo()->lockForUpdate()->first();
            if (!$equipo) return;

            // 3. Comparamos el tipo de movimiento usando los Enums.
            switch ($mov->tipo_movimiento) {

                case MovimientoTipo::Alta:
                    $equipo->estado = 'En Almacén';
                    break;

                case MovimientoTipo::Asignacion:
                //case MovimientoTipo::Reasignacion:
                    $equipo->estado = 'Asignado';
                    $equipo->usuario_asignado_id = $mov->usuario_asignado_id;
                    if ($mov->dependencia_destino_id) {
                        $equipo->dependencia_id = $mov->dependencia_destino_id;
                    }
                    break;

                case MovimientoTipo::Prestamo:
                    $equipo->estado = 'En Préstamo';
                    $equipo->usuario_asignado_id = $mov->usuario_asignado_id;
                    if ($mov->dependencia_destino_id) {
                        $equipo->dependencia_id = $mov->dependencia_destino_id;
                    }
                    break;

                case MovimientoTipo::Traslado:
                    $equipo->estado = 'Baja';
                    $equipo->usuario_asignado_id = null;
                    if ($mov->dependencia_destino_id) {
                        $equipo->dependencia_id = $mov->dependencia_destino_id;
                    }
                    break;
                
                case MovimientoTipo::Devolucion:
                    $equipo->estado = 'En Almacén';
                    $equipo->usuario_asignado_id = null;
                    if ($mov->dependencia_destino_id) {
                        $equipo->dependencia_id = $mov->dependencia_destino_id;
                    } elseif ($mov->dependencia_origen_id) {
                        $equipo->dependencia_id = $mov->dependencia_origen_id;
                    }
                    break;

                case MovimientoTipo::Baja:
                    $equipo->estado = 'Baja';
                    $equipo->usuario_asignado_id = null;
                    break;

                case MovimientoTipo::Garantia:
                    $equipo->estado = 'En Mantenimiento';
                    $equipo->usuario_asignado_id = null;
                    break;
            }

            $equipo->save();
        });
    }
}