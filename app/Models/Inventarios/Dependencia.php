<?php


namespace App\Models\Inventarios;

use Illuminate\Database\Eloquent\Model;

class Dependencia extends Model
{
    protected $table = 'inventarios_dependencias';

    protected $fillable = [
        'nombre','siglas','telefono','direccion',
        'colonia','municipio','estado','pais',
    ];
}