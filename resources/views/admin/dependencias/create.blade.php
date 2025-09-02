{{-- resources/views/admin/dependencias/create.blade.php --}}
<x-app-layout>
  <x-slot name="headerTitle"> {{-- Slot para el título --}}
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Nueva Dependencia') }}
    </h2>
  </x-slot>


  <div class="py-6"> {{-- Mantén este div para el padding del contenido --}}
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8"> {{-- Contenedor de ancho limitado --}}
      <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
        <x-ui.section-title title="Nueva Dependencia" subtitle="Agrega una nueva dependencia" />

        {{-- El partial _form.blade.php ya maneja sus propios errores y form --}}
        @include('admin.dependencias._form', [
          'route'  => route('admin.dependencias.store'),
          'method' => 'POST',
          'dependencia' => new \App\Models\Inventarios\Dependencia(), // Pasa una nueva instancia
        ])
      </div>
    </div>
  </div>
</x-app-layout>