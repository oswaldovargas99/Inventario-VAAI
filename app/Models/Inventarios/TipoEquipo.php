<?php

namespace App\Models\Inventarios;

use Illuminate\Database\Eloquent\Model;

class TipoEquipo extends Model
{
    protected $table = 'inventarios_tipos_equipos';
    protected $fillable = ['nombre'];

    public function equipos()
    {
        return $this->hasMany(Equipo::class, 'tipo_equipo_id');
    }
}
