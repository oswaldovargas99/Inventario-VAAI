{{-- resources/views/patrimonio/aprobaciones.blade.php --}}
<x-app-layout> {{-- ¡CAMBIO AQUÍ! --}}
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Visto Bueno de movimientos') }} {{-- O el título que desees --}}
    </h2>
  </x-slot>

  {{-- Aquí iría todo el contenido existente de tu vista de aprobaciones --}}
  {{-- Por ejemplo: --}}
  <x-ui.section-title title="Visto bueno de aprobaciones" subtitle="Gestiona los movimientos pendientes de aprobación" />

  <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-4">
      <p class="text-gray-600 dark:text-gray-300">Contenido de la página de aprobaciones de patrimonio...</p>
      {{-- Aquí iría la tabla de movimientos pendientes de aprobar por Patrimonio --}}
  </div>

</x-app-layout>