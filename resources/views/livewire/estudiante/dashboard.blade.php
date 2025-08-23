<?php

use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Gate;
use App\Models\Profile;
use function Livewire\Volt\layout;

new class extends Component {
    use WithFileUploads;

    public bool $editing = false;

    // Campos del perfil
    public $nombre, $apellido, $dni, $telefono, $carrera, $comision;

    // Enlaces sociales (JSON)
    public $instagram, $facebook, $linkedin, $web;

    // Lectura
    public $email;

    // Foto
    public $foto; // archivo subido
    public ?Profile $profile = null;

    public function mount(?\App\Models\Profile $profile = null): void
    {
        if ($profile) {
            \Illuminate\Support\Facades\Gate::authorize('view', $profile);
            $this->profile = $profile;
            $this->email   = $profile->user->email;
        } else {
            $u = auth()->user();
            $this->profile = $u->profile;   // puede ser null
            $this->email   = $u->email;
            // No Gate::authorize aquí
        }
    
        $p = $this->profile;
        $this->nombre   = $p->nombre   ?? null;
        $this->apellido = $p->apellido ?? null;
        $this->dni      = $p->dni      ?? null;
        $this->telefono = $p->telefono ?? null;
        $this->carrera  = $p->carrera  ?? null;
        $this->comision = $p->comision ?? null;
    
        $links = $p->social_links ?? [];
        $this->instagram = $links['instagram'] ?? null;
        $this->facebook  = $links['facebook']  ?? null;
        $this->linkedin  = $links['linkedin']  ?? null;
        $this->web       = $links['web']       ?? null;
    }



    public function rules(): array
    {
        $id = $this->profile?->id ?? 'NULL';

        return [
            'nombre'   => ['required','string','max:100'],
            'apellido' => ['required','string','max:100'],
            'dni'      => ['nullable','string','max:20','unique:profiles,dni,'.$id],
            'telefono' => ['nullable','string','max:30'],
            'carrera'  => ['nullable','string','max:120'],
            'comision' => ['nullable','string','max:50'],

            'instagram'=> ['nullable','url'],
            'facebook' => ['nullable','url'],
            'linkedin' => ['nullable','url'],
            'web'      => ['nullable','url'],

            'foto'     => ['nullable','image','max:2048'], // 2MB
        ];
    }

    /** Botón Editar: chequea permiso antes de habilitar edición */
    public function startEditing(): void
    {
        Gate::authorize('update', $this->profile);
        $this->editing = true;
    }

    /** Guardia extra: impedir que seteen editing=true sin permiso */
    public function updatingEditing($value): void
    {
        if ($value && Gate::denies('update', $this->profile)) {
            $this->editing = false;
        }
    }

    public function save(): void
    {
        // Solo el dueño (estudiante) puede actualizar
        Gate::authorize('update', $this->profile);

        $this->validate();

        $user = auth()->user();

        // Foto (si se sube)
        $path = $this->profile?->foto_path;
        if ($this->foto) {
            $path = $this->foto->store('profiles', 'public');
        }

        // Crear/actualizar solo el propio perfil del usuario autenticado
        $this->profile = Profile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'nombre'      => $this->nombre,
                'apellido'    => $this->apellido,
                'dni'         => $this->dni,
                'telefono'    => $this->telefono,
                'carrera'     => $this->carrera ?: null,
                'comision'    => $this->comision ?: null,
                'foto_path'   => $path,
                'social_links'=> array_filter([
                    'instagram' => $this->instagram,
                    'facebook'  => $this->facebook,
                    'linkedin'  => $this->linkedin,
                    'web'       => $this->web,
                ]),
            ]
        );

        $this->editing = false;
        session()->flash('success', 'Perfil actualizado con éxito.');
    }

    public function whatsappUrl(): ?string
    {
        $digits = preg_replace('/\D+/', '', (string) $this->telefono);
        if (!$digits) return null;

        if (str_starts_with($digits, '0')) {
            $digits = ltrim($digits, '0');
        }
        if (!str_starts_with($digits, '54')) {
            $digits = '54'.$digits;
        }
        return "https://wa.me/{$digits}";
    }
};

layout('components.layouts.app');
?>

<div class="flex flex-col gap-6 p-6">
    {{-- Encabezado --}}
    <div class="bg-white dark:bg-zinc-800 rounded-xl shadow p-6 flex items-center gap-6 border border-neutral-200 dark:border-neutral-700">
        @php
            $avatar = $profile?->foto_path ? asset('storage/'.$profile->foto_path) : null;
            $ini = strtoupper(
                mb_substr(($nombre ?: auth()->user()->name), 0, 1) .
                mb_substr(($apellido ?: ''), 0, 1)
            );
        @endphp

        <div class="relative">
            @if ($avatar)
                <img src="{{ $avatar }}" alt="Foto" class="w-20 h-20 rounded-full object-cover border">
            @else
                <div class="flex items-center justify-center w-20 h-20 rounded-full bg-neutral-200 text-xl font-bold text-gray-700">
                    {{ $ini }}
                </div>
            @endif
        </div>

        <div class="flex-1">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                {{ $nombre ?: '-' }} {{ $apellido ?: '' }}
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                {{ $carrera ?: 'Carrera no asignada' }}
            </p>
            <div class="flex gap-2 mt-2">
                <span class="px-3 py-1 rounded-lg text-xs font-medium bg-blue-100 text-blue-700">Estudiante UTN</span>
                <span class="px-3 py-1 rounded-lg text-xs font-medium bg-gray-100 text-gray-700">Comisión {{ $comision ?: 'N/A' }}</span>
            </div>
        </div>

        <div class="hidden md:block">
            @if ($editing)
                <button wire:click="save" class="px-4 py-2 rounded-lg bg-green-600 hover:bg-green-700 text-white">Guardar</button>
            @else
                @can('update', $profile)
                    <button wire:click="startEditing" class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white">Editar</button>
                @endcan
            @endif
        </div>
    </div>

    {{-- Alertas --}}
    @if (session('success'))
        <div class="rounded-md border border-green-200 bg-green-50 px-4 py-3 text-green-800 dark:border-green-800 dark:bg-green-900/30 dark:text-green-200">
            {{ session('success') }}
        </div>
    @endif

    {{-- Información --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Personal --}}
        <div class="bg-white dark:bg-zinc-800 rounded-xl shadow p-6 border border-neutral-200 dark:border-neutral-700">
            <h3 class="text-lg font-semibold mb-4">Información Personal</h3>

            @if (!$editing)
                <ul class="text-sm text-gray-600 dark:text-gray-300 space-y-2">
                    <li><strong>Nombre:</strong> {{ $nombre ?: '-' }}</li>
                    <li><strong>Apellido:</strong> {{ $apellido ?: '-' }}</li>
                    <li><strong>DNI:</strong> {{ $dni ?: '-' }}</li>
                    <li><strong>Teléfono:</strong>
                        @if ($telefono)
                            <a href="{{ $this->whatsappUrl() }}" target="_blank" class="text-blue-600 underline">
                                {{ $telefono }} (WhatsApp)
                            </a>
                        @else
                            -
                        @endif
                    </li>
                    <li><strong>Email:</strong> {{ $email }}</li>
                </ul>
            @else
                @can('update', $profile)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs mb-1">Nombre</label>
                            <input type="text" wire:model.defer="nombre" class="w-full rounded-md border px-3 py-2 bg-white dark:bg-zinc-900">
                            @error('nombre') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs mb-1">Apellido</label>
                            <input type="text" wire:model.defer="apellido" class="w-full rounded-md border px-3 py-2 bg-white dark:bg-zinc-900">
                            @error('apellido') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs mb-1">DNI</label>
                            <input type="text" wire:model.defer="dni" class="w-full rounded-md border px-3 py-2 bg-white dark:bg-zinc-900">
                            @error('dni') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs mb-1">Teléfono</label>
                            <input type="text" wire:model.defer="telefono" class="w-full rounded-md border px-3 py-2 bg-white dark:bg-zinc-900">
                            @error('telefono') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs mb-1">Foto (opcional)</label>
                            <input type="file" wire:model="foto" accept="image/*" class="w-full rounded-md border px-3 py-2 bg-white dark:bg-zinc-900">
                            @error('foto') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            @if ($foto)
                                <p class="text-xs mt-2">Vista previa:</p>
                                <img src="{{ $foto->temporaryUrl() }}" class="mt-1 w-20 h-20 rounded-full object-cover border">
                            @endif
                        </div>
                    </div>
                @endcan
            @endif
        </div>

        {{-- Académica --}}
        <div class="bg-white dark:bg-zinc-800 rounded-xl shadow p-6 border border-neutral-200 dark:border-neutral-700">
            <h3 class="text-lg font-semibold mb-4">Información Académica</h3>

            @if (!$editing)
                <ul class="text-sm text-gray-600 dark:text-gray-300 space-y-2">
                    <li><strong>Carrera:</strong> {{ $carrera ?: '-' }}</li>
                    <li><strong>Comisión:</strong> {{ $comision ?: '-' }}</li>
                    <li><strong>Instagram:</strong> {{ $instagram ?: '-' }}</li>
                    <li><strong>Facebook:</strong> {{ $facebook ?: '-' }}</li>
                    <li><strong>LinkedIn:</strong> {{ $linkedin ?: '-' }}</li>
                    <li><strong>Web:</strong> {{ $web ?: '-' }}</li>
                </ul>
            @else
                @can('update', $profile)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs mb-1">Carrera</label>
                            <input type="text" wire:model.defer="carrera" class="w-full rounded-md border px-3 py-2 bg-white dark:bg-zinc-900">
                            @error('carrera') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs mb-1">Comisión</label>
                            <input type="text" wire:model.defer="comision" class="w-full rounded-md border px-3 py-2 bg-white dark:bg-zinc-900">
                            @error('comision') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs mb-1">Instagram (URL)</label>
                            <input type="url" wire:model.defer="instagram" placeholder="https://instagram.com/usuario" class="w-full rounded-md border px-3 py-2 bg-white dark:bg-zinc-900">
                            @error('instagram') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs mb-1">Facebook (URL)</label>
                            <input type="url" wire:model.defer="facebook" placeholder="https://facebook.com/usuario" class="w-full rounded-md border px-3 py-2 bg-white dark:bg-zinc-900">
                            @error('facebook') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs mb-1">LinkedIn (URL)</label>
                            <input type="url" wire:model.defer="linkedin" placeholder="https://linkedin.com/in/usuario" class="w-full rounded-md border px-3 py-2 bg-white dark:bg-zinc-900">
                            @error('linkedin') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs mb-1">Web personal (URL)</label>
                            <input type="url" wire:model.defer="web" placeholder="https://tu-sitio.com" class="w-full rounded-md border px-3 py-2 bg-white dark:bg-zinc-900">
                            @error('web') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                @endcan
            @endif
        </div>
    </div>
</div>
