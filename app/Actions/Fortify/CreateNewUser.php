<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    public function create(array $input): User
    {
        Validator::make($input, [
            'name'           => ['required', 'string', 'max:255'],
            'email'          => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'       => $this->passwordRules(),
            'codigo'         => ['nullable','string','max:255'],
            'puesto'         => ['nullable','string','max:255'],
            'telefono'       => ['nullable','string','max:50'],
            'extension'      => ['nullable','string','max:10'],
            'dependencia_id' => ['nullable','exists:inventarios_dependencias,id'],
        ])->validate();

        $user = User::create([
            'name'           => $input['name'],
            'email'          => $input['email'],
            'password'       => Hash::make($input['password']),
            'codigo'         => $input['codigo'] ?? null,
            'puesto'         => $input['puesto'] ?? null,
            'telefono'       => $input['telefono'] ?? null,
            'extension'      => $input['extension'] ?? null,
            'dependencia_id' => $input['dependencia_id'] ?? null,
        ]);

        // Rol por defecto
        $user->assignRole('Usuario');

        return $user;
    }
}

