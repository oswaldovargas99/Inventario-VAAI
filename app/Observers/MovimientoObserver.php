<?php

namespace App\Observers;

use App\Models\Inventarios\Movimiento;
use Illuminate\Support\Facades\DB;

class MovimientoObserver
{
    /**
     * Handle the Movimiento "saved" event.
     */
    public function saved(Movimiento $mov): void
    {
        // Asegúrate de que este texto coincida con tu estado de aprobación final
        if ($mov->estado_aprobacion !== 'Aprobado_Secretaria') {
            return;
        }

        DB::transaction(function () use ($mov) {
            $equipo = $mov->equipo()->lockForUpdate()->first();
            if (!$equipo) return;

            // === ¡CÓDIGO CORREGIDO CON LOS ACENTOS CORRECTOS! ===
            switch ($mov->tipo_movimiento) {

                case 'Alta':
                    $equipo->estado = 'En Almacén';
                    break;

                case 'Asignación':
                case 'Reasignación':
                case 'Préstamo':
                    $equipo->estado = ($mov->tipo_movimiento === 'Préstamo') ? 'En Préstamo' : 'Asignado';
                    $equipo->usuario_asignado_id = $mov->usuario_asignado_id; // Se asigna el usuario
                    if ($mov->dependencia_destino_id) {
                        $equipo->dependencia_id = $mov->dependencia_destino_id;
                    }
                    break;

                case 'Traslado':
                    if ($mov->dependencia_destino_id) {
                        $equipo->dependencia_id = $mov->dependencia_destino_id;
                    }
                    break;
                
                case 'Devolución':
                    $equipo->estado = 'En Almacén';
                    $equipo->usuario_asignado_id = null;
                    if ($mov->dependencia_destino_id) {
                        $equipo->dependencia_id = $mov->dependencia_destino_id;
                    } elseif ($mov->dependencia_origen_id) {
                        $equipo->dependencia_id = $mov->dependencia_origen_id;
                    }
                    break;

                case 'Baja':
                    $equipo->estado = 'Baja';
                    $equipo->usuario_asignado_id = null;
                    break;

                case 'Garantía':
                    $equipo->estado = 'En Mantenimiento';
                    $equipo->usuario_asignado_id = null;
                    break;
            }

            $equipo->save();
        });
    }
}