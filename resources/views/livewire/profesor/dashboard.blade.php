<?php

use Livewire\Volt\Component;
use App\Models\Profile;
use function Livewire\Volt\layout;

new class extends Component {
    public $profiles;

    public function mount(): void
    {
        // Traer todos los perfiles con el user relacionado
        $this->profiles = Profile::with('user')->get();
    }
};

layout('components.layouts.app');
?>

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
            <div class="text-3xl font-bold">{{ $profiles->count() }}</div>
            <div class="text-sm text-gray-500">Total Estudiantes</div>
        </div>
        <div class="bg-white dark:bg-zinc-800 shadow rounded-xl p-4 text-center">
            <div class="text-3xl font-bold text-blue-500">
                {{ $profiles->whereNotNull('carrera')->count() }}
            </div>
            <div class="text-sm text-gray-500">Con Carrera</div>
        </div>
        <div class="bg-white dark:bg-zinc-800 shadow rounded-xl p-4 text-center">
            <div class="text-3xl font-bold text-orange-500">
                {{ $profiles->whereNull('carrera')->count() }}
            </div>
            <div class="text-sm text-gray-500">Sin Carrera</div>
        </div>
    </div>

    <!-- Tabla Estudiantes -->
    <div class="bg-white dark:bg-zinc-800 shadow rounded-xl p-4">
        <h2 class="font-semibold mb-4">Estudiantes ({{ $profiles->count() }})</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="text-sm text-gray-500 border-b dark:border-zinc-700">
                    <tr>
                        <th class="p-2">Estudiante</th>
                        <th class="p-2">DNI</th>
                        <th class="p-2">Carrera</th>
                        <th class="p-2">Comisión</th>
                        <th class="p-2">Contacto</th>
                        <th class="p-2">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y dark:divide-zinc-700">
                    @foreach ($profiles as $p)
                        <tr>
                            <td class="p-2">
                                <div class="flex items-center gap-2">
                                    <span class="h-8 w-8 flex items-center justify-center rounded-full bg-gray-200 text-gray-700">
                                        {{ strtoupper(substr($p->nombre,0,1).substr($p->apellido,0,1)) }}
                                    </span>
                                    <div>
                                        <div class="font-semibold">
                                            {{ $p->nombre }} {{ $p->apellido }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $p->user->email ?? '-' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="p-2">{{ $p->dni ?? '-' }}</td>
                            <td class="p-2">
                                @if ($p->carrera)
                                    <span class="px-2 py-1 rounded bg-blue-100 text-blue-700 text-xs font-medium">
                                        {{ $p->carrera }}
                                    </span>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="p-2">{{ $p->comision ?? '-' }}</td>
                            <td class="p-2">
                                <div class="text-sm">{{ $p->user->email ?? '-' }}</div>
                                <div class="text-sm">{{ $p->telefono ?? '-' }}</div>
                            </td>
                            <td class="p-2 flex gap-2">
                                <a href="{{ route('estudiantes.show', $p) }}" 
                                   class="px-3 py-1 bg-gray-100 rounded-lg text-sm hover:bg-gray-200">
                                   👁 Ver Perfil
                                </a>

                                @if ($p->telefono)
                                    <a href="https://wa.me/54{{ ltrim($p->telefono,'0') }}" target="_blank"
                                       class="px-3 py-1 bg-green-100 rounded-lg text-sm hover:bg-green-200">💬 WhatsApp</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
