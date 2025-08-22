@php $user = $user ?? null; @endphp

@if ($errors->any())
  <div class="mb-3 p-3 rounded bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-100">
    {{ $errors->first() }}
  </div>
@endif

<form action="{{ $route }}" method="POST" class="grid gap-4 max-w-3xl">
  @csrf
  @if($method === 'PUT') @method('PUT') @endif

  <div class="grid md:grid-cols-2 gap-4">
    <div>
      <label class="block text-sm dark:text-gray-200">Nombre</label>
      <input name="name" value="{{ old('name', $user->name ?? '') }}" required
             class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"/>
    </div>
    <div>
      <label class="block text-sm dark:text-gray-200">Email</label>
      <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" required
             class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"/>
    </div>
  </div>

  <div class="grid md:grid-cols-4 gap-4">
    <div>
      <label class="block text-sm dark:text-gray-200">Código</label>
      <input name="codigo" value="{{ old('codigo', $user->codigo ?? '') }}"
             class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"/>
    </div>
    <div>
      <label class="block text-sm dark:text-gray-200">Puesto</label>
      <input name="puesto" value="{{ old('puesto', $user->puesto ?? '') }}"
             class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"/>
    </div>
    <div>
      <label class="block text-sm dark:text-gray-200">Teléfono</label>
      <input name="telefono" value="{{ old('telefono', $user->telefono ?? '') }}"
             class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"/>
    </div>
    <div>
      <label class="block text-sm dark:text-gray-200">Extensión</label>
      <input name="extension" value="{{ old('extension', $user->extension ?? '') }}"
             class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"/>
    </div>
  </div>

  <div class="grid md:grid-cols-2 gap-4">
    <div>
      <label class="block text-sm dark:text-gray-200">Dependencia</label>
      <select name="dependencia_id" required
              class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
        <option value="">-- Selecciona --</option>
        @foreach($dependencias as $dep)
          <option value="{{ $dep->id }}" @selected(old('dependencia_id', $user->dependencia_id ?? '') == $dep->id)>
            {{ $dep->nombre }}
          </option>
        @endforeach
      </select>
    </div>
    <div>
      <label class="block text-sm dark:text-gray-200">Rol</label>
      <select name="role" required
              class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
        @foreach($roles as $r)
          <option value="{{ $r }}" @selected(old('role', $user?->getRoleNames()->first()) == $r)>{{ $r }}</option>
        @endforeach
      </select>
    </div>
  </div>

  <div class="grid md:grid-cols-2 gap-4">
    <div>
      <label class="block text-sm dark:text-gray-200">
        Contraseña {{ $user ? '(deja vacío para no cambiar)' : '' }}
      </label>
      <input type="password" name="password"
             class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"/>
    </div>
    <div>
      <label class="block text-sm dark:text-gray-200">Confirmación</label>
      <input type="password" name="password_confirmation"
             class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"/>
    </div>
  </div>

  <div class="flex gap-2">
    <button class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">Guardar</button>
    <a href="{{ route('admin.users.index') }}" class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-100">Cancelar</a>
  </div>
</form>
