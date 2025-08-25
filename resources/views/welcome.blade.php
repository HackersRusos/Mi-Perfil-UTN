<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mi Perfil UTN</title>

    @vite('resources/css/app.css') {{-- Tailwind --}}
</head>
<body class="bg-gray-50 text-gray-800 antialiased min-h-screen flex flex-col">

    {{-- Navbar --}}
    <nav class="bg-white shadow">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <img src="{{ asset('images/UTN_FRRE.png') }}" alt="UTN" class="h-12">
                <span class="text-lg font-semibold text-blue-900">Extensión Formosa</span>
            </div>
            <div class="space-x-2">
                @auth
                    @php
                        $u = auth()->user();
                    
                        if ($u->hasAnyRole('admin','3')) {
                            $panel = route('admin.dashboard');
                        } elseif ($u->hasAnyRole('profesor','2')) {
                            $panel = route('profesor.dashboard');
                        } elseif ($u->hasAnyRole('estudiante','1')) {
                            // Mi perfil del estudiante ahora es por DNI
                            $panel = route('estudiantes.show', $u->profile->dni);
                        } else {
                            $panel = route('home');
                        }
                    @endphp
                    <a href="{{ $panel }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Panel
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="w-full inline">
                        @csrf
                        <button type="submit" 
                            class="px-4 py-2 rounded-full bg-red-600 text-white font-medium hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1 transition">
                            🚪 {{ __('Cerrar sesión') }}
                        </button>
                    </form>
                @else
                    <a href="{{ route('auth', ['mode' => 'login']) }}" class="px-4 py-2 border border-blue-600 text-blue-600 rounded hover:bg-blue-50">
                        Iniciar Sesión
                    </a>
                    <a href="{{ route('auth', ['mode' => 'register']) }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Registrarse
                    </a>

                    
                @endauth

            </div>
        </div>
    </nav>

    {{-- Hero --}}
    <main class="container mx-auto px-4 py-4 text-center flex-grow">
        <h1 class="text-4xl font-bold text-blue-900 mb-4">Mi Perfil UTN</h1>
        <p class="text-lg text-gray-600 mb-6">
            Sistema de gestión de perfiles estudiantiles<br>
            Universidad Tecnológica Nacional - FRRe - Extensión Formosa
        </p>

        <img src="{{ asset('images/IPP--696x464.jpg') }}" alt="Edificio UTN"
             class="mx-auto rounded-lg shadow-md max-w-4xl">
    </main>

    {{-- Footer --}}
    <footer class="bg-blue-900 text-white text-center py-6">
        &copy; {{ date('Y') }} UTN - Facultad Regional Resistencia - Extensión Formosa
    </footer>

</body>
</html>
