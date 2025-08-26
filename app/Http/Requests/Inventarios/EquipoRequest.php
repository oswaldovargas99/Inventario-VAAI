<?php

namespace App\Http\Requests\Inventarios;

use Illuminate\Foundation\Http\FormRequest;

class EquipoRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $id = $this->route('equipo')?->id;

        return [
            'dependencia_id'     => ['required','exists:inventarios_dependencias,id'],
            'tipo_equipo_id'     => ['required','exists:inventarios_tipos_equipos,id'],
            'ubicacion_fisica'   => ['nullable','string','max:255'],
            'marca'              => ['nullable','string','max:100'],
            'modelo'             => ['nullable','string','max:100'],
            'numero_serie'       => ['required','string','max:150','unique:inventarios_equipos,numero_serie,'.($id ?? 'NULL').',id'],
            'id_activo_fijo'     => ['nullable','string','max:100'],
            // acepta AA:BB:... o AABB...
            'mac_address'        => ['nullable','string','max:17','regex:/^([A-Fa-f0-9]{2}([:\-]?[A-Fa-f0-9]{2}){5})$/'],
            'fecha_adquisicion'  => ['nullable','date'],
            'estado'             => ['required','in:En Almacén,Asignado,En Préstamo,En Mantenimiento,Baja'],
            'descripcion'        => ['nullable','string'],
        ];
    }

    public function messages(): array
    {
        return [
            'numero_serie.unique' => 'El número de serie ya existe en el inventario.',
            'mac_address.regex'   => 'La MAC debe tener formato AA:BB:CC:DD:EE:FF o AABBCCDDEEFF.',
        ];
    }
}
