{{-- resources/views/admin/users/create.blade.php --}}
<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Crear Usuario') }}
    </h2>
  </x-slot>

  <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
      <x-ui.section-title title="Nuevo Usuario" subtitle="Captura los datos del usuario" />

      <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf
        {{-- Incluimos el partial del formulario --}}
        {{-- Pasamos 'isCreate' para la lógica de contraseña --}}
        @include('admin.users._form', [
            'user' => new \App\Models\User(), // Pasa una nueva instancia del modelo User
            'dependencias' => $dependencias,   // Asegúrate de que $dependencias se pasa desde el controlador
            'roles' => $roles,                 // Asegúrate de que $roles se pasa desde el controlador
            'isCreate' => true,                // Para la lógica de contraseña en el partial
        ])

        <div class="flex items-center justify-end mt-6 gap-2"> {{-- Ajuste de margen y gap --}}
            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 rounded bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-100 hover:bg-gray-300 dark:hover:bg-gray-600">Cancelar</a>
            <button type="submit" class="px-4 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">Crear Usuario</button>
        </div>
      </form>
    </div>
  </div>
</x-app-layout>