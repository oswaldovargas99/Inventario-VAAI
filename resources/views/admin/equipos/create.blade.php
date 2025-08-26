{{-- resources/views/admin/equipos/create.blade.php --}}
<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Nuevo Equipo</h2></x-slot>
    <div class="py-6">
        <div class="mx-auto max-w-5xl sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                <form method="POST" action="{{ route('admin.equipos.store') }}">
                    @csrf
                    @include('admin.equipos._form', ['equipo'=>null, 'submitText'=>'Registrar'])
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
