<?php

namespace App\Http\Requests\Inventarios;

use App\Enums\MovimientoTipo;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MovimientoUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('movimientos.edit') ?? false;
    }

    public function rules(): array
    {
        return [
            'tipo_movimiento' => ['required', Rule::in(MovimientoTipo::values())],
            'usuario_asignado_id' => ['nullable','integer','exists:users,id'],
            'dependencia_origen_id' => ['nullable','integer','exists:inventarios_dependencias,id'],
            'dependencia_destino_id' => ['nullable','integer','exists:inventarios_dependencias,id'],
            'fecha_movimiento' => ['required','date'],
            'fecha_retorno_esperada' => ['nullable','date','after_or_equal:fecha_movimiento'],
            'motivo' => ['nullable','string'],
        ];
    }
}
