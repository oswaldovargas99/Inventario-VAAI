<?php

namespace App\Models\Inventarios;

use Illuminate\Database\Eloquent\Model;

class Dependencia extends Model
{
    protected $table = 'inventarios_dependencias';
    protected $fillable = ['nombre','siglas','telefono','direccion'];

    public function users()
    {
        return $this->hasMany(\App\Models\User::class, 'dependencia_id');
    }
}
