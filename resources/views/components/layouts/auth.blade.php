<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
</head>
<body class="min-h-screen bg-gray-50 dark:bg-zinc-800 text-gray-800 dark:text-gray-100 antialiased flex items-center justify-center">

    {{-- Contenedor principal --}}
    <main class="w-full max-w-md px-6 py-8 sm:px-8 sm:py-10">
        {{ $slot }}
    </main>

    @fluxScripts
</body>
</html>
