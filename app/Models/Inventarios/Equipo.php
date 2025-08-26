<?php

namespace App\Models\Inventarios;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipo extends Model
{
    use SoftDeletes;

    protected $table = 'inventarios_equipos';

    protected $fillable = [
        'dependencia_id','ubicacion_fisica','tipo_equipo_id',
        'marca','modelo','numero_serie','id_activo_fijo','mac_address',
        'fecha_adquisicion','estado','descripcion'
    ];

    protected $casts = [
        'fecha_adquisicion' => 'date',
    ];

    // Normalización simple de MAC (AA:BB:CC:DD:EE:FF)
    public function setMacAddressAttribute($value)
    {
        if (!$value) { $this->attributes['mac_address'] = null; return; }
        $hex = preg_replace('/[^a-fA-F0-9]/', '', $value);
        $hex = strtoupper($hex);
        if (strlen($hex) === 12) {
            $hex = implode(':', str_split($hex, 2));
        }
        $this->attributes['mac_address'] = $hex;
    }

    // Relaciones
    public function dependencia()
    {
        return $this->belongsTo(Dependencia::class, 'dependencia_id');
    }

    public function tipo()
    {
        return $this->belongsTo(TipoEquipo::class, 'tipo_equipo_id');
    }
}

