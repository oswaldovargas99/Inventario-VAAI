<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DependenciaRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $id = $this->route('dependencia')?->id;

        return [
            'nombre'    => ['required','string','max:100'],
            'siglas'    => ['required','string','max:20', Rule::unique('inventarios_dependencias','siglas')->ignore($id)],
            'telefono'  => ['nullable','string','max:50'],
            'direccion' => ['nullable','string','max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'siglas.unique' => 'Estas siglas ya existen.',
        ];
    }
}
