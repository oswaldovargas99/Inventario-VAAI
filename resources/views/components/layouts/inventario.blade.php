{{-- Layout base Inventario UdG (usa Jetstream x-app-layout) --}}
<x-app-layout>
    {{-- Persistimos preferencia de dark mode con Alpine + localStorage --}}
    <div
        x-data="{
            sidebarOpen: false,
            dark: localStorage.getItem('theme') === 'dark',
            toggleDark() {
                this.dark = !this.dark;
                localStorage.setItem('theme', this.dark ? 'dark' : 'light');
                document.documentElement.classList.toggle('dark', this.dark);
            }
        }"
        x-init="document.documentElement.classList.toggle('dark', dark)"
        class="min-h-screen bg-gray-50 dark:bg-gray-900"
    >
        {{-- Topbar --}}
        <header class="sticky top-0 z-40 bg-white/80 dark:bg-gray-800/80 backdrop-blur border-b border-gray-200 dark:border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <button @click="sidebarOpen = !sidebarOpen"
                            class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none"
                            aria-label="Abrir menú">
                        <!-- icon burger -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 dark:text-gray-100" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <a href="{{ route('dashboard') }}" class="font-semibold text-gray-900 dark:text-gray-100">
                        Inventario UdG
                    </a>
                    {{-- Breadcrumbs (slot opcional desde vistas) --}}
                    <div class="hidden sm:block">
                        {{ $breadcrumbs ?? '' }}
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    {{-- Botón dark-mode --}}
                    <button @click="toggleDark()"
                            class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none"
                            aria-label="Cambiar tema">
                        <svg x-show="!dark" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-800" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 18a6 6 0 100-12 6 6 0 000 12z"/><path fill-rule="evenodd" d="M12 2a1 1 0 011 1v2a1 1 0 11-2 0V3a1 1 0 011-1zm0 16a1 1 0 011 1v2a1 1 0 11-2 0v-2a1 1 0 011-1zM4.222 5.636a1 1 0 011.414 0L7.05 7.05a1 1 0 01-1.414 1.414L4.222 7.05a1 1 0 010-1.414zM16.95 16.95a1 1 0 011.414 0l1.414 1.414a1 1 0 01-1.414 1.414L16.95 18.364a1 1 0 010-1.414zM2 13a1 1 0 100-2h-2a1 1 0 100 2h2zm22 0a1 1 0 100-2h-2a1 1 0 100 2h2zM4.222 18.364a1 1 0 011.414 0L7.05 19.778a1 1 0 01-1.414 1.414L4.222 19.778a1 1 0 010-1.414zM16.95 7.05a1 1 0 011.414 0l1.414-1.414a1 1 0 10-1.414-1.414L16.95 5.636a1 1 0 010 1.414z" clip-rule="evenodd"/>
                        </svg>
                        <svg x-show="dark" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-100" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M21.752 15.002A9 9 0 1112.998 2.25c.29 0 .576.016.86.047a1 1 0 01.516 1.763 6.5 6.5 0 007.568 10.942 1 1 0 01.81 1.773z"/>
                        </svg>
                    </button>

                    {{-- Usuario + Roles --}}
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-700 dark:text-gray-300">{{ auth()->user()->name }}</span>
                        @foreach (auth()->user()->getRoleNames() as $r)
                            <x-ui.role-badge :role="$r"/>
                        @endforeach
                    </div>
                </div>
            </div>
        </header>

        {{-- Offcanvas backdrop móvil --}}
        <div x-cloak x-show="sidebarOpen" @click="sidebarOpen=false" class="fixed inset-0 bg-black/30 z-30 sm:hidden"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 grid grid-cols-12 gap-6">
            {{-- Sidebar --}}
            <aside
                class="col-span-12 sm:col-span-3 lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-4 h-max
                       fixed z-40 sm:static top-16 left-0 w-72 sm:w-auto transform sm:transform-none transition"
                :class="{'-translate-x-full sm:translate-x-0': !sidebarOpen, 'translate-x-0': sidebarOpen}"
            >
                <nav class="space-y-1">
                    {{-- Items visibles según rol/permiso --}}

                    <x-ui.nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        <span class="mr-2">🏠</span> Dashboard
                    </x-ui.nav-link>

                    @can('ver inventario')
                        <x-ui.nav-link href="#" :active="false">
                            <span class="mr-2">🗃️</span> Inventario (lista)
                        </x-ui.nav-link>
                    @endcan

                    @role('Admin')
                        <x-ui.nav-link :href="route('admin.home')" :active="request()->routeIs('admin.home')">
                            <span class="mr-2">🛠️</span> Área Admin
                        </x-ui.nav-link>
                    @endrole

                    @can('aprobar movimientos')
                        <x-ui.nav-link :href="route('patrimonio.aprobaciones')" :active="request()->routeIs('patrimonio.aprobaciones')">
                            <span class="mr-2">✅</span> Aprobaciones (Patrimonio)
                        </x-ui.nav-link>
                    @endcan

                    @can('vobo movimientos')
                        <x-ui.nav-link :href="route('secretaria.vobo')" :active="request()->routeIs('secretaria.vobo')">
                            <span class="mr-2">📝</span> VoBo Secretaría
                        </x-ui.nav-link>
                    @endcan

                    @role('Admin')
                        <x-ui.nav-link href="#" :active="false">
                            <span class="mr-2">👥</span> Usuarios & Dependencias
                        </x-ui.nav-link>
                    @endrole
                </nav>
            </aside>

            {{-- Contenido --}}
            <main class="col-span-12 sm:col-span-9 lg:col-span-10">
                {{ $slot }}
            </main>
        </div>
    </div>
</x-app-layout>
