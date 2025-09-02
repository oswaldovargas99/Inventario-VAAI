<?php

namespace App\Enums;

enum EstadoAprobacion: string
{
    case Pendiente = 'Pendiente';
    case AprobadoPatrimonio = 'Aprobado_Patrimonio';
    case AprobadoSecretaria = 'Aprobado_Secretaria';
    case Rechazado = 'Rechazado';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
