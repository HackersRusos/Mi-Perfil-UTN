<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
</head>
<body class="min-h-screen bg-white dark:bg-zinc-800 flex">

    @auth
        {{-- Sidebar (solo visible si está autenticado) --}}
        @include('components.layouts.app.sidebar')
    @endauth

    <div class="flex-1 flex flex-col">
        {{-- Header superior --}}
        @include('components.layouts.app.header')

        {{-- Contenido principal --}}
        <main class="p-4 sm:p-6 md:p-8">
            {{ $slot }}
        </main>
    </div>

    @fluxScripts
</body>
</html>
