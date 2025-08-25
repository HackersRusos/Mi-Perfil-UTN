<div class="space-y-6">
    <!-- Encabezado -->
    <div>
        <h1 class="text-2xl font-bold">Vista de Profesor</h1>
        <p class="text-gray-500 dark:text-gray-400">
            UTN FRRe – Sistema de Gestión
        </p>
    </div>

    <!-- Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-zinc-800 shadow rounded-xl p-4 text-center">
            <div class="text-2xl font-bold">{{ $profiles->count() }}</div>
            <div class="text-sm text-gray-500">Total Estudiantes</div>
        </div>
        <div class="bg-white dark:bg-zinc-800 shadow rounded-xl p-4 text-center">
            <div class="text-2xl font-bold text-blue-500">
                {{ $profiles->whereNotNull('carrera')->count() }}
            </div>
            <div class="text-sm text-gray-500">Con Carrera</div>
        </div>
        <div class="bg-white dark:bg-zinc-800 shadow rounded-xl p-4 text-center">
            <div class="text-2xl font-bold text-orange-500">
                {{ $profiles->whereNull('carrera')->count() }}
            </div>
            <div class="text-sm text-gray-500">Sin Carrera</div>
        </div>
    </div>

    <!-- Galería Estudiantes -->
    <div>
        <h2 class="font-semibold mb-6">Estudiantes ({{ $profiles->count() }})</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($profiles as $p)
                <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-lg hover:shadow-xl transition p-5 flex flex-col items-center text-center">
                    <!-- Foto -->
                    @php
                        $avatar = $p->foto_path ? asset('storage/'.$p->foto_path) : null;
                        $ini = strtoupper(substr($p->nombre,0,1).substr($p->apellido,0,1));
                    @endphp
                    <a href="{{ route('estudiantes.show', $p) }}" class="group">
                        @if ($avatar)
                            <img src="{{ $avatar }}" alt="Foto"
                                class="w-24 h-24 rounded-full object-cover border-4 border-blue-600 mx-auto group-hover:scale-105 transition">
                        @else
                            <div class="flex items-center justify-center w-24 h-24 rounded-full bg-blue-100 text-blue-700 text-2xl font-bold mx-auto">
                                {{ $ini }}
                            </div>
                        @endif
                    </a>

                    <!-- Nombre y carrera -->
                    <div class="mt-4">
                        <h3 class="text-base font-semibold text-gray-900 dark:text-white">
                            {{ $p->nombre }} {{ $p->apellido }}
                        </h3>
                        <p class="text-sm text-gray-500">
                            {{ $p->carrera ?? 'Sin carrera' }}
                        </p>
                    </div>

                    <!-- Botones -->
                    <div class="mt-4 flex gap-3">
                        <a href="{{ route('estudiantes.show', $p) }}"
                           class="px-3 py-1.5 text-xs font-medium rounded-lg bg-blue-100 text-blue-700 hover:bg-blue-200">
                            👁 Ver
                        </a>
                        @if ($p->telefono)
                            <a href="https://wa.me/54{{ ltrim($p->telefono,'0') }}" target="_blank"
                               class="px-3 py-1.5 text-xs font-medium rounded-lg bg-green-100 text-green-700 hover:bg-green-200">
                                💬 WhatsApp
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
