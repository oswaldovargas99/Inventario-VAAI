<?php

namespace App\Observers;

use App\Enums\EstadoAprobacion;
use App\Enums\MovimientoTipo;
use App\Models\Inventarios\Movimiento;
use Illuminate\Support\Facades\DB;

class MovimientoObserver
{
    public function saved(Movimiento $mov): void
    {
        if ($mov->estado_aprobacion !== EstadoAprobacion::AprobadoSecretaria) {
            return;
        }

        DB::transaction(function () use ($mov) {
            $equipo = $mov->equipo()->lockForUpdate()->first();
            if (!$equipo) return;

            switch ($mov->tipo_movimiento) {
                case MovimientoTipo::Alta:
                    $equipo->estado = 'En Almacén';
                    break;

                case MovimientoTipo::Asignacion:
                    $equipo->estado = 'Asignado';
                    if (schema_has_column('inventarios_equipos', 'usuario_asignado_id')) {
                        $equipo->usuario_asignado_id = $mov->usuario_asignado_id;
                    }
                    if ($mov->dependencia_destino_id && schema_has_column('inventarios_equipos','dependencia_id')) {
                        $equipo->dependencia_id = $mov->dependencia_destino_id;
                    }
                    break;

                case MovimientoTipo::Traslado:
                    if ($mov->dependencia_destino_id && schema_has_column('inventarios_equipos','dependencia_id')) {
                        $equipo->dependencia_id = $mov->dependencia_destino_id;
                    }
                    break;

                case MovimientoTipo::Prestamo:
                    $equipo->estado = 'En Préstamo';
                    break;

                case MovimientoTipo::Devolucion:
                    $equipo->estado = 'En Almacén';
                    if ($mov->dependencia_destino_id && schema_has_column('inventarios_equipos','dependencia_id')) {
                        $equipo->dependencia_id = $mov->dependencia_destino_id;
                    }
                    if (schema_has_column('inventarios_equipos', 'usuario_asignado_id')) {
                        $equipo->usuario_asignado_id = null;
                    }
                    break;

                case MovimientoTipo::Garantia:
                    $equipo->estado = 'En Mantenimiento';
                    break;

                case MovimientoTipo::Baja:
                    $equipo->estado = 'Baja';
                    break;
            }

            $equipo->save();
        });
    }
}

if (!function_exists('schema_has_column')) {
    function schema_has_column(string $table, string $column): bool
    {
        try { return \Illuminate\Support\Facades\Schema::hasColumn($table, $column); }
        catch (\Throwable) { return false; }
    }
}
