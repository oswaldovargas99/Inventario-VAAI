<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Inventario UdG') }} - Iniciar Sesión</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display-swap" rel="stylesheet" />

    <!-- Scripts y Favicon -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" href="{{ asset('images/favicon1.png') }}" type="image/png">
</head>
<body class="antialiased">

    <!-- Contenedor Principal con tu Imagen de Fondo -->
    <div class="relative min-h-screen bg-cover bg-center" 
         style="background-image: url('{{ asset('images/wallpaper-cutonala.jpg') }}')">

        <!-- Overlay muy sutil para mejorar contraste -->
        <div class="absolute inset-0 bg-black bg-opacity-20"></div>

        <!-- Contenedor para centrar la tarjeta de login -->
        <div class="flex items-center justify-center min-h-screen px-4 relative z-10">

            <!-- Tarjeta de Login -->
            <div class="w-full max-w-md bg-white rounded-xl shadow-2xl p-8 sm:p-10">
                
                <!-- Logo de la dependencia -->
                <div class="mb-8 text-center">
                    <a href="/">
                        <img src="{{ asset('images/favicon1.png') }}" alt="Logo VAAI" class="mx-auto h-20 w-auto">
                    </a>
                </div>

                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                        {{ session('status') }}
                    </div>
                @endif

                <x-validation-errors class="mb-4" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div>
                        <x-label for="email" value="{{ __('Correo electrónico') }}" />
                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    </div>

                    <div class="mt-4">
                        <x-label for="password" value="{{ __('Contraseña') }}" />
                        <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                    </div>

                    <div class="block mt-4">
                        <label for="remember_me" class="flex items-center">
                            <x-checkbox id="remember_me" name="remember" />
                            <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Mantener sesión activa') }}</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <x-button class="ms-4 bg-gray-800 hover:bg-gray-900 text-white font-bold py-2 px-6 rounded-lg">
                            {{ __('Iniciar Sesión') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>