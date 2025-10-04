<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Inventario UdG') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts y Favicon -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" href="{{ asset('images/favicon1.png') }}" type="image/png">
</head>
<body class="antialiased">

    <!-- Contenedor Principal con Fondo y Overlay -->
    <div class="relative min-h-screen bg-cover bg-center" 
         style="background-image: url('{{ asset('images/parainfo_udg.jpg') }}')">

        <!-- Overlay oscuro para mejorar legibilidad -->
        <div class="absolute inset-0 bg-black bg-opacity-10"></div>



        <!-- Contenedor central de la tarjeta -->
        <div class="flex items-center justify-center min-h-screen px-4 relative z-10">

            <!-- Tarjeta flotante estilo Glassmorphism -->
            <div class="w-full max-w-md rounded-3xl shadow-2xl overflow-hidden bg-white/70 backdrop-blur-lg p-8 text-center">
                
                <!-- Logo y títulos -->
                <div class="space-y-4">
                    <a href="/">
                        <img src="{{ asset('images/favicon1.png') }}" alt="Logo VAAI" class="mx-auto h-16 w-auto">
                    </a>

                </div>

                <!-- Divisor sutil -->
                <hr class="my-6 border-gray-900/20">

                <!-- Mensaje y botón de acción -->
                <div class="space-y-6">
                    <p class="text-gray-800 font-medium text-lg">
                        Bienvenido al Sistema de Inventario
                    </p>

                    @auth
                        <a href="{{ url('/inicio') }}" 
                           class="inline-block w-full sm:w-auto px-8 py-3 rounded-xl bg-indigo-600 text-white font-bold shadow-lg hover:bg-indigo-700 transition transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Ir al Panel
                        </a>
                    @else
                        <a href="{{ route('login') }}" 
                           class="inline-block w-full sm:w-auto px-8 py-3 rounded-xl bg-indigo-600 text-white font-bold shadow-lg hover:bg-indigo-700 transition transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Iniciar Sesión
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

</body>
</html>
