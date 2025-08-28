<?php

namespace App\Http\Requests\Inventarios;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; // Asegúrate de importar la clase Rule

class EquipoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Ajusta esto según tu lógica de autorización
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'dependencia_id' => ['required', 'exists:inventarios_dependencias,id'],
            'tipo_equipo_id' => ['required', 'exists:inventarios_tipos_equipos,id'], // Asegúrate de que este también esté corregido si es el caso
            'estado'         => ['required', 'string', 'in:En Almacén,Asignado,En Préstamo,En Mantenimiento,Baja'],
            'marca'          => ['nullable', 'string', 'max:255'],
            'modelo'         => ['nullable', 'string', 'max:255'],
            'ubicacion_fisica' => ['nullable', 'string', 'max:255'],
            'fecha_adquisicion' => ['nullable', 'date'],
            'descripcion'    => ['nullable', 'string'],
            'mac_address'    => ['nullable', 'string', 'max:17', 'regex:/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$|^([0-9A-Fa-f]{12})$/'],
            'id_activo_fijo' => [
                'nullable',
                'string',
                'max:255',
                // ¡CORREGIDO AQUÍ!
                Rule::unique('inventarios_equipos')->ignore($this->route('equipo'))->where(function ($query) {
                    $query->whereNull('deleted_at');
                }),
            ],
            'numero_serie'   => [
                'required',
                'string',
                'max:255',
                // ¡CORREGIDO AQUÍ!
                Rule::unique('inventarios_equipos')->ignore($this->route('equipo'))->where(function ($query) {
                    $query->whereNull('deleted_at');
                }),
            ],
        ];

        return $rules;
    }
    /**
     * Custom validation messages (opcional)
     */
    public function messages(): array
    {
        return [
            'numero_serie.unique' => 'El número de serie ya está en uso por un equipo activo.',
            'id_activo_fijo.unique' => 'El ID de activo fijo ya está en uso por un equipo activo.',
        ];
    }
}