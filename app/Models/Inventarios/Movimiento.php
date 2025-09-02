<?php

namespace App\Models\Inventarios;

use App\Enums\EstadoAprobacion;
use App\Enums\MovimientoTipo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;


class Movimiento extends Model
{
    protected $table = 'inventarios_movimientos';

    protected $fillable = [
        'equipo_id',
        'tipo_movimiento',
        'responsable_id',
        'usuario_asignado_id',
        'dependencia_origen_id',
        'dependencia_destino_id',
        'fecha_movimiento',
        'fecha_retorno_esperada',
        'motivo',
        'estado_aprobacion',
        'aprobador_id',
        'fecha_aprobacion',
        'comentarios_aprobacion',
    ];

    protected $casts = [
        'fecha_movimiento' => 'date',
        'fecha_retorno_esperada' => 'date',
        'fecha_aprobacion' => 'datetime',
        'tipo_movimiento' => MovimientoTipo::class,
        'estado_aprobacion' => EstadoAprobacion::class,
    ];

    // Relaciones
    public function equipo(): BelongsTo
    {
        return $this->belongsTo(Equipo::class, 'equipo_id');
    }

    public function responsable(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    public function usuarioAsignado(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_asignado_id');
    }

    public function dependenciaOrigen(): BelongsTo
    {
        return $this->belongsTo(Dependencia::class, 'dependencia_origen_id');
    }

    public function dependenciaDestino(): BelongsTo
    {
        return $this->belongsTo(Dependencia::class, 'dependencia_destino_id');
    }

    public function aprobador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'aprobador_id');
    }
}
