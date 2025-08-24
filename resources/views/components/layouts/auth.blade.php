<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-zinc-800">

    {{-- Contenedor centrado --}}
    <main class="w-full max-w-md p-6">
        {{ $slot }}
    </main>

    @fluxScripts
</body>
</html>
