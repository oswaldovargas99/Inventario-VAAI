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
     * This event runs after a movement is created or updated.
     */
    public function saved(Movimiento $mov): void
    {
        // La lógica solo se ejecuta cuando el movimiento alcanza el estado de aprobación final.
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

                // === CAMBIO AQUÍ: Agrupamos todos los movimientos que asignan un usuario ===
                case MovimientoTipo::Asignacion:
                case MovimientoTipo::Reasignacion: // Si tienes este tipo
                case MovimientoTipo::Prestamo:     // Si tienes este tipo
                    $equipo->estado = ($mov->tipo_movimiento === MovimientoTipo::Prestamo) ? 'En Préstamo' : 'Asignado';
                    
                    // Descomentamos y asignamos el usuario directamente.
                    $equipo->usuario_asignado_id = $mov->usuario_asignado_id;

                    // Tu lógica existente para actualizar la dependencia es correcta.
                    if ($mov->dependencia_destino_id) {
                        $equipo->dependencia_id = $mov->dependencia_destino_id;
                    }
                    break;

                case MovimientoTipo::Traslado:
                    // Traslado solo mueve dependencia, no afecta al usuario asignado.
                    if ($mov->dependencia_destino_id) {
                        $equipo->dependencia_id = $mov->dependencia_destino_id;
                    }
                    break;
                
                // === CAMBIO AQUÍ: Agrupamos todos los movimientos que quitan un usuario ===
                case MovimientoTipo::Devolucion: // Renombrado de 'Retorno' a 'Devolucion' para coincidir con tu código
                case MovimientoTipo::Baja:
                    $equipo->estado = ($mov->tipo_movimiento === MovimientoTipo::Baja) ? 'Baja' : 'En Almacén';

                    // Descomentamos y quitamos la asignación del usuario.
                    $equipo->usuario_asignado_id = null;

                    if ($mov->tipo_movimiento === MovimientoTipo::Devolucion) {
                        if ($mov->dependencia_destino_id) {
                            $equipo->dependencia_id = $mov->dependencia_destino_id;
                        } elseif ($mov->dependencia_origen_id) {
                            $equipo->dependencia_id = $mov->dependencia_origen_id;
                        }
                    }
                    break;

                case MovimientoTipo::Garantia:
                    $equipo->estado = 'En Mantenimiento';
                    // Generalmente, un equipo en garantía no está asignado a un usuario.
                    $equipo->usuario_asignado_id = null;
                    break;
            }

            $equipo->save();
        });
    }
}

// Ya no necesitas esta función si confías en tus migraciones.
/*
if (!function_exists('schema_has_column')) {
    function schema_has_column(string $table, string $column): bool
    {
        try { return \Illuminate\Support\Facades\Schema::hasColumn($table, $column); }
        catch (\Throwable) { return false; }
    }
}
*/