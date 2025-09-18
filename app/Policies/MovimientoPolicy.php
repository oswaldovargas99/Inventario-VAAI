<?php

namespace App\Policies;

use App\Models\Inventarios\Movimiento;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MovimientoPolicy
{
    /**
     * Se ejecuta antes de cualquier método de política.
     * Si el usuario es 'Admin', puede realizar todas las acciones.
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->hasRole('Admin')) {
            return true; // Un Admin puede hacer CUALQUIER COSA
        }

        return null; // Si no es Admin, el control pasa a los métodos específicos de la política.
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Movimiento $movimiento): bool
    {
        // Un usuario puede actualizar un movimiento si tiene el permiso
        // Y si el movimiento está pendiente de aprobación (para evitar editar movimientos aprobados/rechazados)
        return $user->can('movimientos.edit') && ($movimiento->estado_aprobacion->value === \App\Enums\EstadoAprobacion::Pendiente->value);
    }

    /**
     * Determine whether the user can approve/reject the model.
     */
    public function approve(User $user, Movimiento $movimiento): bool
    {
        // Un usuario puede aprobar/rechazar si tiene el permiso 'movimientos.approve'
        // Y si el movimiento está en un estado que permite aprobación/rechazo
        return $user->can('movimientos.approve') && (
            $movimiento->estado_aprobacion->value === \App\Enums\EstadoAprobacion::Pendiente->value ||
            $movimiento->estado_aprobacion->value === \App\Enums\EstadoAprobacion::AprobadoPatrimonio->value
        );
    }

    // ... (otros métodos como delete, view, etc., si los usas) ...

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Movimiento $movimiento): bool
    {
        return $user->can('movimientos.delete') && ($movimiento->estado_aprobacion->value === \App\Enums\EstadoAprobacion::Pendiente->value);
    }
}
