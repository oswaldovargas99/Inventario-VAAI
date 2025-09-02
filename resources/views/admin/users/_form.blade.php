{{-- resources/views/admin/users/_form.blade.php --}}
@props(['user' => null, 'dependencias' => [], 'roles' => [], 'isCreate' => false, 'isEdit' => false])

@php
    // Asegurarse de que $user sea una instancia o un objeto vacío para evitar errores
    $user = $user ?? new \App\Models\User();

    // Helper para obtener valores (old() > modelo > default)
    $val = fn($field, $default = '') => old($field, $user->{$field} ?? $default);

    // Determinar el rol actual para el select
    $currentRole = old('role', $user->getRoleNames()->first() ?? 'Usuario');
@endphp

{{-- Los errores de sesión se manejan a nivel del layout principal --}}
{{-- Los @error directos para cada campo son suficientes --}}

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <label class="block">
        <span class="text-sm text-gray-700 dark:text-gray-300">Nombre</span>
        <input type="text" name="name" class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800"
               value="{{ $val('name') }}" required>
        @error('name')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
    </label>

    <label class="block">
        <span class="text-sm text-gray-700 dark:text-gray-300">Email</span>
        <input type="email" name="email" class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800"
               value="{{ $val('email') }}" required>
        @error('email')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
    </label>

    <label class="block">
        <span class="text-sm text-gray-700 dark:text-gray-300">Código</span>
        <input type="text" name="codigo" class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800"
               value="{{ $val('codigo') }}">
        @error('codigo')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
    </label>

    <label class="block">
        <span class="text-sm text-gray-700 dark:text-gray-300">Puesto</span>
        <input type="text" name="puesto" class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800"
               value="{{ $val('puesto') }}">
        @error('puesto')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
    </label>

    <label class="block">
        <span class="text-sm text-gray-700 dark:text-gray-300">Teléfono</span>
        <input type="text" name="telefono" class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800"
               value="{{ $val('telefono') }}">
        @error('telefono')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
    </label>

    <label class="block">
        <span class="text-sm text-gray-700 dark:text-gray-300">Extensión</span>
        <input type="text" name="extension" class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800"
               value="{{ $val('extension') }}">
        @error('extension')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
    </label>

    <label class="block md:col-span-2">
        <span class="text-sm text-gray-700 dark:text-gray-300">Dependencia</span>
        <select name="dependencia_id" class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800" required>
            <option value="">— Selecciona —</option>
            @foreach($dependencias as $d)
                <option value="{{ $d->id }}" @selected($val('dependencia_id') == $d->id)>
                    {{ $d->siglas }} — {{ $d->nombre }}
                </option>
            @endforeach
        </select>
        @error('dependencia_id')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
    </label>

    <label class="block">
        <span class="text-sm text-gray-700 dark:text-gray-300">Rol</span>
        <select name="role" class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800" required>
            @foreach($roles as $r)
                <option value="{{ $r }}" @selected($currentRole === $r)>{{ $r }}</option>
            @endforeach
        </select>
        @error('role')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
    </label>

    {{-- Password (requerida en create, opcional en edit) --}}
    @if($isCreate)
        <label class="block"> {{-- Cambiado de md:col-span-2 a una columna simple --}}
            <span class="text-sm text-gray-700 dark:text-gray-300">Contraseña</span>
            <input type="password" name="password" autocomplete="new-password"
                   class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800" required>
            @error('password')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
        </label>
        <label class="block"> {{-- Cambiado de md:col-span-2 a una columna simple --}}
            <span class="text-sm text-gray-700 dark:text-gray-300">Confirmar contraseña</span>
            <input type="password" name="password_confirmation" autocomplete="new-password"
                   class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800" required>
        </label>
    @else {{-- isEdit --}}
        <label class="block"> {{-- Cambiado de md:col-span-2 a una columna simple --}}
            <span class="text-sm text-gray-700 dark:text-gray-300">Nueva contraseña (opcional)</span>
            <input type="password" name="password" autocomplete="new-password"
                   class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800">
            @error('password')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
        </label>
        <label class="block"> {{-- Cambiado de md:col-span-2 a una columna simple --}}
            <span class="text-sm text-gray-700 dark:text-gray-300">Confirmar nueva contraseña</span>
            <input type="password" name="password_confirmation" autocomplete="new-password"
                   class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800">
        </label>
    @endif
</div>