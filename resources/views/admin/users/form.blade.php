{{-- Campos comunes --}}
<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm text-gray-600 dark:text-gray-300">Nombre</label>
        <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}"
               class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800" required>
        @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm text-gray-600 dark:text-gray-300">Email</label>
        <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}"
               class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800" required>
        @error('email') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm text-gray-600 dark:text-gray-300">Código</label>
        <input type="text" name="codigo" value="{{ old('codigo', $user->codigo ?? '') }}"
               class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800">
        @error('codigo') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm text-gray-600 dark:text-gray-300">Puesto</label>
        <input type="text" name="puesto" value="{{ old('puesto', $user->puesto ?? '') }}"
               class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800">
        @error('puesto') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm text-gray-600 dark:text-gray-300">Teléfono</label>
        <input type="text" name="telefono" value="{{ old('telefono', $user->telefono ?? '') }}"
               class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800">
        @error('telefono') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm text-gray-600 dark:text-gray-300">Extensión</label>
        <input type="text" name="extension" value="{{ old('extension', $user->extension ?? '') }}"
               class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800">
        @error('extension') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>

    <div class="sm:col-span-2">
        <label class="block text-sm text-gray-600 dark:text-gray-300">Dependencia</label>
        <select name="dependencia_id"
                class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800" required>
            <option value="">-- Selecciona --</option>
            @foreach ($dependencias as $d)
                <option value="{{ $d->id }}" @selected(old('dependencia_id', $user->dependencia_id ?? null) == $d->id)>
                    {{ $d->siglas }} — {{ $d->nombre }}
                </option>
            @endforeach
        </select>
        @error('dependencia_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>
</div>

{{-- Contraseña: requerida en create, opcional en edit --}}
<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-2">
    <div>
        <label class="block text-sm text-gray-600 dark:text-gray-300">
            Contraseña {{ $isEdit ? '(dejar vacío para no cambiar)' : '' }}
        </label>
        <input type="password" name="password"
               class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800"
               @unless($isEdit) required @endunless>
        @error('password') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm text-gray-600 dark:text-gray-300">Confirmar contraseña</label>
        <input type="password" name="password_confirmation"
               class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800"
               @unless($isEdit) required @endunless>
    </div>
</div>

{{-- Rol --}}
<div class="mt-2">
    <label class="block text-sm text-gray-600 dark:text-gray-300">Rol</label>
    <select name="role" class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800" required>
        @foreach ($roles as $r)
            <option value="{{ $r }}" @selected(old('role', $user->getRoleNames()->first() ?? 'Usuario') === $r)>
                {{ $r }}
            </option>
        @endforeach
    </select>
    @error('role') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
</div>
