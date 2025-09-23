<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Detalle del Movimiento #{{ $movimiento->id }}
            </h2>
            <a href="{{ route('admin.movimientos.index') }}" class="px-4 py-2 rounded-md bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-100 hover:bg-gray-300 dark:hover:bg-gray-600">
                &larr; Volver al Listado
            </a>
        </div>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg">

            {{-- Sección de Información del Equipo --}}
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">
                    Información del Equipo
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">
                    Detalles del activo involucrado en el movimiento.
                </p>
            </div>
            <dl>
                <div class="bg-gray-50 dark:bg-gray-900/50 px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tipo de Equipo</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">
                        {{ $movimiento->equipo?->tipo?->nombre ?? 'No especificado' }}
                    </dd>
                </div>
                <div class="bg-white dark:bg-gray-800 px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">ID Activo Fijo</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">
                        {{ $movimiento->equipo?->id_activo_fijo ?? 'N/A' }}
                    </dd>
                </div>
                <div class="bg-gray-50 dark:bg-gray-900/50 px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Número de Serie</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">
                        {{ $movimiento->equipo?->numero_serie ?? 'N/A' }}
                    </dd>
                </div>
                <div class="bg-white dark:bg-gray-800 px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Marca y Modelo</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">
                        {{ $movimiento->equipo?->marca ?? '' }} {{ $movimiento->equipo?->modelo ?? 'No especificado' }}
                    </dd>
                </div>
            </dl>

            {{-- Sección de Detalles del Movimiento --}}
            <div class="px-4 py-5 sm:px-6 border-t border-gray-200 dark:border-gray-700">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">
                    Detalles del Movimiento
                </h3>
            </div>
            <dl>
                <div class="bg-gray-50 dark:bg-gray-900/50 px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tipo de Movimiento</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">{{ $movimiento->tipo_movimiento->value }}</dd>
                </div>
                <div class="bg-white dark:bg-gray-800 px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha del Movimiento</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">{{ $movimiento->fecha_movimiento?->format('d/m/Y') }}</dd>
                </div>
                <div class="bg-gray-50 dark:bg-gray-900/50 px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Usuario Asignado (Resguardante)</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">{{ $movimiento->usuarioAsignado?->name ?? 'No aplica' }}</dd>
                </div>
                <div class="bg-white dark:bg-gray-800 px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Dependencia Origen</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">{{ $movimiento->dependenciaOrigen?->nombre ?? 'N/A' }}</dd>
                </div>
                <div class="bg-gray-50 dark:bg-gray-900/50 px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Dependencia Destino</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">{{ $movimiento->dependenciaDestino?->nombre ?? 'N/A' }}</dd>
                </div>
                <div class="bg-white dark:bg-gray-800 px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha Retorno Esperada</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">
                        {{ $movimiento->fecha_retorno_esperada?->format('d/m/Y') ?? 'No aplica' }}
                    </dd>
                </div>
                <div class="bg-gray-50 dark:bg-gray-900/50 px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Motivo / Comentarios</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2 whitespace-pre-wrap">{{ $movimiento->motivo ?: 'Sin comentarios.' }}</dd>
                </div>
            </dl>

            {{-- Sección de Estado y Aprobación --}}
            <div class="px-4 py-5 sm:px-6 border-t border-gray-200 dark:border-gray-700">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">
                    Estado y Aprobación
                </h3>
            </div>
            <dl>
                <div class="bg-gray-50 dark:bg-gray-900/50 px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Estado Actual</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                            @class([
                                'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' => $movimiento->estado_aprobacion->value === 'Pendiente',
                                'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300' => $movimiento->estado_aprobacion->value === 'Aprobado_Patrimonio',
                                'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' => $movimiento->estado_aprobacion->value === 'Aprobado_Secretaria',
                                'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' => $movimiento->estado_aprobacion->value === 'Rechazado',
                            ])">
                            {{ str_replace('_', ' ', $movimiento->estado_aprobacion->value) }}
                        </span>
                    </dd>
                </div>
                <div class="bg-white dark:bg-gray-800 px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Responsable del Registro</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">{{ $movimiento->responsable?->name ?? 'N/A' }}</dd>
                </div>
                @if($movimiento->aprobador_id)
                    <div class="bg-gray-50 dark:bg-gray-900/50 px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Revisado por</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">{{ $movimiento->aprobador?->name ?? 'N/A' }}</dd>
                    </div>
                    <div class="bg-white dark:bg-gray-800 px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha de Revisión</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">{{ $movimiento->fecha_aprobacion?->format('d/m/Y H:i') ?? 'N/A' }}</dd>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-900/50 px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Comentarios de Revisión</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2 whitespace-pre-wrap">{{ $movimiento->comentarios_aprobacion ?: 'Sin comentarios.' }}</dd>
                    </div>
                @endif
            </dl>

            <div class="px-4 py-4 sm:px-6 border-t border-gray-200 dark:border-gray-700 flex justify-end">
                <a href="{{ route('admin.movimientos.index') }}" class="px-4 py-2 rounded-md bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-100 hover:bg-gray-300 dark:hover:bg-gray-600">
                    &larr; Volver al Listado
                </a>
            </div>
        </div>
    </div>
</x-app-layout>