<?php
use function Livewire\Volt\layout;

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
            <div class="text-3xl font-bold">2</div>
            <div class="text-sm text-gray-500">Total Estudiantes</div>
        </div>
        <div class="bg-white dark:bg-zinc-800 shadow rounded-xl p-4 text-center">
            <div class="text-3xl font-bold text-blue-500">2</div>
            <div class="text-sm text-gray-500">Tecnicaturas</div>
        </div>
        <div class="bg-white dark:bg-zinc-800 shadow rounded-xl p-4 text-center">
            <div class="text-3xl font-bold text-green-500">0</div>
            <div class="text-sm text-gray-500">Licenciaturas</div>
        </div>
        <div class="bg-white dark:bg-zinc-800 shadow rounded-xl p-4 text-center">
            <div class="text-3xl font-bold text-orange-500">0</div>
            <div class="text-sm text-gray-500">Sin Carrera</div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="bg-white dark:bg-zinc-800 shadow rounded-xl p-4">
        <h2 class="font-semibold mb-4">Filtros de Búsqueda</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <input type="text" placeholder="Buscar por nombre, apellido, email o DNI..." 
                class="w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-900" />

            <select class="w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-900">
                <option>Todas las carreras</option>
                <option>Programación</option>
                <option>Ingeniería Mecánica</option>
            </select>

            <select class="w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-900">
                <option>Todas las comisiones</option>
                <option>2.1</option>
                <option>3.1</option>
            </select>
        </div>
    </div>

    <!-- Tabla Estudiantes -->
    <div class="bg-white dark:bg-zinc-800 shadow rounded-xl p-4">
        <h2 class="font-semibold mb-4">Estudiantes (3)</h2>
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
                    <tr>
                        <td class="p-2">
                            <div class="flex items-center gap-2">
                                <span class="h-8 w-8 flex items-center justify-center rounded-full bg-gray-200 text-gray-700">LC</span>
                                <div>
                                    <div class="font-semibold">Lorena Caballero</div>
                                    <div class="text-sm text-gray-500">180pasteleria@gmail.com</div>
                                </div>
                            </div>
                        </td>
                        <td class="p-2">38823149</td>
                        <td class="p-2">
                            <span class="px-2 py-1 rounded bg-blue-100 text-blue-700 text-xs font-medium">EN PROGRAMACION</span>
                        </td>
                        <td class="p-2">2.1</td>
                        <td class="p-2">
                            <div class="text-sm">180pasteleria@gmail.com</div>
                            <div class="text-sm">370429791</div>
                        </td>
                        <td class="p-2 flex gap-2">
                            <a href="#" class="px-3 py-1 bg-gray-100 rounded-lg text-sm hover:bg-gray-200">👁 Ver Perfil</a>
                            <a href="https://wa.me/54370429791" target="_blank" class="px-3 py-1 bg-green-100 rounded-lg text-sm hover:bg-green-200">💬 WhatsApp</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="p-2">
                            <div class="flex items-center gap-2">
                                <span class="h-8 w-8 flex items-center justify-center rounded-full bg-gray-200 text-gray-700">SG</span>
                                <div>
                                    <div class="font-semibold">Santiago Gines</div>
                                    <div class="text-sm text-gray-500">gustavogines2014@gmail.com</div>
                                </div>
                            </div>
                        </td>
                        <td class="p-2">43455758</td>
                        <td class="p-2">
                            <span class="px-2 py-1 rounded bg-blue-100 text-blue-700 text-xs font-medium">EN PROGRAMACION</span>
                        </td>
                        <td class="p-2">2.1</td>
                        <td class="p-2">
                            <div class="text-sm">gustavogines2014@gmail.com</div>
                            <div class="text-sm">3704889655</div>
                        </td>
                        <td class="p-2 flex gap-2">
                            <a href="#" class="px-3 py-1 bg-gray-100 rounded-lg text-sm hover:bg-gray-200">👁 Ver Perfil</a>
                            <a href="https://wa.me/543704889655" target="_blank" class="px-3 py-1 bg-green-100 rounded-lg text-sm hover:bg-green-200">💬 WhatsApp</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
