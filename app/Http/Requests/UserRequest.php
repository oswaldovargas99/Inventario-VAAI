<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Ya está protegido por middleware role:Admin
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user')?->id;

        $base = [
            'name'            => ['required','string','max:255'],
            'email'           => [
                'required','email:rfc,dns',
                Rule::unique('users','email')->ignore($userId),
            ],
            'codigo'          => ['nullable','string','max:100'],
            'puesto'          => ['nullable','string','max:150'],
            'telefono'        => ['nullable','string','max:30'],
            'extension'       => ['nullable','string','max:10'],
            'dependencia_id'  => ['required','exists:inventarios_dependencias,id'],
            'role'            => ['required', Rule::in(['Admin','Aprobador','Secretario','Usuario'])],
        ];

        if ($this->isMethod('post')) {
            $base['password'] = ['required','confirmed','min:8'];
        } else {
            $base['password'] = ['nullable','confirmed','min:8'];
        }

        return $base;
    }
}

