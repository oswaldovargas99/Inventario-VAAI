<?php

namespace App\Http\Requests\Inventarios;

use App\Enums\MovimientoTipo;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MovimientoStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('movimientos.create') ?? false;
    }

    public function rules(): array
    {
        return [
            'equipo_id' => ['required','integer','exists:inventarios_equipos,id'],
            'tipo_movimiento' => ['required', Rule::in(MovimientoTipo::values())],
           // 'responsable_id' => ['required','integer','exists:users,id'],
            'usuario_asignado_id' => ['nullable','integer','exists:users,id'],
            'dependencia_origen_id' => ['nullable','integer','exists:inventarios_dependencias,id'],
            'dependencia_destino_id' => ['nullable','integer','exists:inventarios_dependencias,id'],
            'fecha_movimiento' => ['required','date'],
            'fecha_retorno_esperada' => ['nullable','date','after_or_equal:fecha_movimiento'],
            'motivo' => ['nullable','string'],
        ];
    }
}
