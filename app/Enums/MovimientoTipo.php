<?php

namespace App\Enums;


enum MovimientoTipo: string
{

    case Alta = 'Alta';
    case Asignacion = 'Asignación';
    case Traslado = 'Traslado';
    case Prestamo = 'Préstamo';
    case Devolucion = 'Devolución';
    case Garantia = 'Garantía';
    case Baja = 'Baja';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
