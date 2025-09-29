<div class="relative" x-data="{
    isDropdownOpen: false,
    searchTerm: @entangle('search').live
}" @click.outside="isDropdownOpen = false" @keydown.escape.window="isDropdownOpen = false">

    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ $label }}</label>

    {{-- Este es el input de texto visible para el usuario --}}
    <input
        type="text"
        id="{{ $name }}"
        placeholder="{{ $placeholder }}"
        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100"
        wire:model.live.debounce.300ms="search"
        x-ref="searchInput"
        @focus="isDropdownOpen = true"  {{-- CORRECCIÓN: Simplemente cambia la variable a true --}}
        @input="isDropdownOpen = true"   {{-- CORRECCIÓN: Mantiene el dropdown abierto al escribir --}}
        autocomplete="off"
        @if($required) required @endif
    >

    {{-- Este es el campo oculto que enviará el ID seleccionado al formulario --}}
    <input type="hidden" name="{{ $name }}" wire:model="selectedEquipoId">

    {{-- Contenedor del Dropdown --}}
    {{-- La visibilidad ahora es controlada por una única y clara condición en x-show --}}
    <div x-show="isDropdownOpen && searchTerm.length >= 2"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute z-10 w-full mt-1"
         style="display: none;"> {{-- Se añade display:none para evitar el "flash" inicial --}}

        @if(strlen($search) >= 2)
            <ul class="max-h-60 overflow-y-auto rounded-md bg-white dark:bg-gray-800 py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                @forelse($equipos as $equipo)
                    <li wire:key="equipo-{{ $equipo->id }}"
                        @click="
                            @this.selectEquipo({{ $equipo->id }});
                            isDropdownOpen = false; // Cierra el dropdown
                        "
                        class="relative cursor-pointer select-none py-2 px-3 text-gray-900 dark:text-gray-200 hover:bg-indigo-600 hover:text-white">
                        <span class="block truncate">{{ $equipo->tipo?->nombre }} — {{ $equipo->numero_serie }} ({{ $equipo->id_activo_fijo }})</span>
                    </li>
                @empty
                    <li class="relative cursor-default select-none py-2 px-3 text-gray-500">
                        No se encontraron equipos...
                    </li>
                @endforelse
            </ul>
        @endif
    </div>

    @error($name)
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>