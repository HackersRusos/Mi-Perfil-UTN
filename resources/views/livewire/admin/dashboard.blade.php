<div class="p-6">
    <h1 class="text-3xl font-bold mb-6">Panel de Administración</h1>

    {{-- Métricas --}}
    <div class="grid grid-cols-4 gap-4 mb-8">
        <div class="bg-white shadow rounded-lg p-4 text-center">
            <p class="text-gray-500">Total Usuarios</p>
            <p class="text-2xl font-bold">{{ $totalUsuarios }}</p>
        </div>
        <div class="bg-white shadow rounded-lg p-4 text-center">
            <p class="text-gray-500">Profesores</p>
            <p class="text-2xl font-bold">{{ $totalProfesores }}</p>
        </div>
        <div class="bg-white shadow rounded-lg p-4 text-center">
            <p class="text-gray-500">Estudiantes</p>
            <p class="text-2xl font-bold">{{ $totalEstudiantes }}</p>
        </div>
        <div class="bg-white shadow rounded-lg p-4 text-center">
            <p class="text-gray-500">Administradores</p>
            <p class="text-2xl font-bold">{{ $totalAdmins }}</p>
        </div>
    </div>

    {{-- Gestión de usuarios --}}
    <h2 class="text-xl font-semibold mb-4">Gestión de Usuarios ({{ $usuarios->count() }})</h2>

    <table class="min-w-full bg-white border rounded-lg">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="p-3">Usuario</th>
                <th class="p-3">Carrera</th>
                <th class="p-3">Rol Actual</th>
                <th class="p-3">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usuarios as $user)
                <tr class="border-t">
                    <td class="p-3">
                        <div class="font-semibold">{{ $user->name }}</div>
                        <div class="text-sm text-gray-500">{{ $user->email }}</div>
                    </td>
                    <td class="p-3">{{ $user->profile->carrera ?? 'Sin carrera' }}</td>
                    <td class="p-3">
                        @if ($user->role_id == 1)
                            <span class="px-2 py-1 text-sm bg-green-100 text-green-600 rounded">Estudiante</span>
                        @elseif ($user->role_id == 2)
                            <span class="px-2 py-1 text-sm bg-blue-100 text-blue-600 rounded">Profesor</span>
                        @elseif ($user->role_id == 3)
                            <span class="px-2 py-1 text-sm bg-purple-100 text-purple-600 rounded">Administrador</span>
                        @endif
                    </td>
                    <td class="p-3">
                        @if ($user->role_id == 1)
                            <button wire:click="hacerProfesor({{ $user->id }})"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded">
                                Hacer Profesor
                            </button>
                        @elseif ($user->role_id == 2)
                            <button wire:click="quitarProfesor({{ $user->id }})"
                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">
                                Quitar Profesor
                            </button>
                        @else
                            <span class="text-gray-400">—</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
