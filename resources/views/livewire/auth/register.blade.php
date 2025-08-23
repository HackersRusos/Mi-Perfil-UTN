<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public bool $showPassword = false;
    public bool $showPasswordConfirm = false;

    public function togglePassword(): void
    {
        $this->showPassword = ! $this->showPassword;
    }

    public function togglePasswordConfirm(): void
    {
        $this->showPasswordConfirm = ! $this->showPasswordConfirm;
    }

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($user = User::create($validated))));

        Auth::login($user);

        $this->redirectIntended(route('dashboard', absolute: false), navigate: true);
    }
};
?>

@php
    $isLogin = request()->routeIs('login');
@endphp

<div class="flex flex-col gap-6 mx-auto w-full max-w-md">
    {{-- Volver al inicio --}}
    <div>
        <flux:link href="{{ url('/') }}" wire:navigate class="inline-flex items-center text-sm text-[#6F84A9] hover:text-[#1F3B70]">
            &#8592; Volver al inicio
        </flux:link>
    </div>

    {{-- Encabezado --}}
    <div class="text-center space-y-1">
        <h1 class="text-2xl font-bold tracking-tight text-[#1F3B70]">Mi Perfil UTN</h1>
        <p class="text-sm text-[#6F84A9]">Sistema de gestión de perfiles estudiantiles</p>
    </div>

    {{-- Tabs --}}
    <div class="grid grid-cols-2 p-1 rounded-xl bg-[#EEF1F6]">
        <a href="{{ route('login') }}"
           wire:navigate
           class="text-center py-2 rounded-lg text-sm font-medium {{ $isLogin ? 'bg-white shadow text-[#1F3B70]' : 'text-[#6F84A9] hover:text-[#1F3B70]' }}">
            Iniciar Sesión
        </a>
        <a href="{{ route('register') }}"
           wire:navigate
           class="text-center py-2 rounded-lg text-sm font-medium {{ $isLogin ? 'text-[#6F84A9] hover:text-[#1F3B70]' : 'bg-white shadow text-[#1F3B70]' }}">
            Registrarse
        </a>
    </div>

    {{-- Formulario --}}
    <form wire:submit="register" class="space-y-5">
        {{-- Nombre completo --}}
        <div>
            <label class="block text-sm font-medium mb-1 text-[#1F3B70]">Nombre completo</label>

            <div class="relative h-12 rounded-xl border border-[#D9E3F2] bg-[#F9FBFD]
                        focus-within:border-[#9DB2D6] focus-within:ring-1 focus-within:ring-[#9DB2D6]">
                {{-- Ícono --}}
                <svg class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 h-5 w-5 text-[#7C8FB1]"
                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 12a5 5 0 100-10 5 5 0 000 10zm7 8.25A7.5 7.5 0 0011.5 13h-1A7.5 7.5 0 003 20.25V21h16v-.75z"/>
                </svg>

                <flux:input
                    wire:model="name"
                    type="text"
                    required
                    placeholder="Ej: Juan Pérez"
                    class="pl-12 pr-4 w-full !h-12 !bg-transparent !ring-0 !border-0 focus:!ring-0 focus:!border-0" />
            </div>

            <flux:error name="name" />
        </div>

        {{-- Email --}}
        <div>
            <label class="block text-sm font-medium mb-1 text-[#1F3B70]">Email Institucional</label>

            <div class="relative h-12 rounded-xl border border-[#D9E3F2] bg-[#F9FBFD]
                        focus-within:border-[#9DB2D6] focus-within:ring-1 focus-within:ring-[#9DB2D6]">
                <svg class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 h-5 w-5 text-[#7C8FB1]"
                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M1.5 6.75A2.25 2.25 0 013.75 4.5h16.5a2.25 2.25 0 012.25 2.25v10.5A2.25 2.25 0 0120.25 19.5H3.75A2.25 2.25 0 011.5 17.25V6.75zM3 7.5l9 5.25L21 7.5" />
                </svg>

                <flux:input
                    wire:model="email"
                    type="email"
                    required
                    autocomplete="email"
                    placeholder="usuario@frre.utn.edu.ar"
                    class="pl-12 pr-4 w-full !h-12 !bg-transparent !ring-0 !border-0 focus:!ring-0 focus:!border-0" />
            </div>

            <flux:error name="email" />
        </div>

        {{-- Contraseña --}}
        <div>
            <label class="block text-sm font-medium mb-1 text-[#1F3B70]">Contraseña</label>

            <div class="relative h-12 rounded-xl border border-[#D9E3F2] bg-[#F9FBFD]
                        focus-within:border-[#9DB2D6] focus-within:ring-1 focus-within:ring-[#9DB2D6]">
                {{-- Ícono candado --}}
                <svg class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 h-5 w-5 text-[#7C8FB1]"
                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd" d="M12 1.5a4.5 4.5 0 00-4.5 4.5v3H6a2.25 2.25 0 00-2.25 2.25v7.5A2.25 2.25 0 006 21h12a2.25 2.25 0 002.25-2.25v-7.5A2.25 2.25 0 0018 9h-1.5v-3A4.5 4.5 0 0012 1.5zm-3 7.5v-3a3 3 0 116 0v3H9z" clip-rule="evenodd"/>
                </svg>

                {{-- Botón ojo --}}
                <button type="button" wire:click="togglePassword"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-[#7C8FB1] hover:text-[#1F3B70]">
                    @if($showPassword)
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M2.25 12s3.75-7.5 9.75-7.5S21.75 12 21.75 12s-3.75 7.5-9.75 7.5S2.25 12 2.25 12z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M3 3l18 18M10.5 10.5a3 3 0 014.243 4.243M6.25 6.252C4.19 8.084 2.94 10.137 2.25 12c0 0 3.75 7.5 9.75 7.5a9.748 9.748 0 006.873-2.748" />
                        </svg>
                    @endif
                </button>

                <flux:input
                    wire:model="password"
                    :type="$showPassword ? 'text' : 'password'"
                    required
                    autocomplete="new-password"
                    placeholder="••••••••"
                    class="pl-12 pr-12 w-full !h-12 !bg-transparent !ring-0 !border-0 focus:!ring-0 focus:!border-0" />
            </div>

            <flux:error name="password" />
        </div>

        {{-- Confirmación --}}
        <div>
            <label class="block text-sm font-medium mb-1 text-[#1F3B70]">Confirmar contraseña</label>

            <div class="relative h-12 rounded-xl border border-[#D9E3F2] bg-[#F9FBFD]
                        focus-within:border-[#9DB2D6] focus-within:ring-1 focus-within:ring-[#9DB2D6]">
                {{-- Ícono candado --}}
                <svg class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 h-5 w-5 text-[#7C8FB1]"
                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd" d="M12 1.5a4.5 4.5 0 00-4.5 4.5v3H6a2.25 2.25 0 00-2.25 2.25v7.5A2.25 2.25 0 006 21h12a2.25 2.25 0 002.25-2.25v-7.5A2.25 2.25 0 0018 9h-1.5v-3A4.5 4.5 0 0012 1.5zm-3 7.5v-3a3 3 0 116 0v3H9z" clip-rule="evenodd"/>
                </svg>

                {{-- Botón ojo --}}
                <button type="button" wire:click="togglePasswordConfirm"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-[#7C8FB1] hover:text-[#1F3B70]">
                    @if($showPasswordConfirm)
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M2.25 12s3.75-7.5 9.75-7.5S21.75 12 21.75 12s-3.75 7.5-9.75 7.5S2.25 12 2.25 12z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M3 3l18 18M10.5 10.5a3 3 0 014.243 4.243M6.25 6.252C4.19 8.084 2.94 10.137 2.25 12c0 0 3.75 7.5 9.75 7.5a9.748 9.748 0 006.873-2.748" />
                        </svg>
                    @endif
                </button>

                <flux:input
                    wire:model="password_confirmation"
                    :type="$showPasswordConfirm ? 'text' : 'password'"
                    required
                    autocomplete="new-password"
                    placeholder="••••••••"
                    class="pl-12 pr-12 w-full !h-12 !bg-transparent !ring-0 !border-0 focus:!ring-0 focus:!border-0" />
            </div>

            <flux:error name="password_confirmation" />
        </div>

        {{-- Botón principal --}}
        <div>
            <flux:button
                variant="primary"
                type="submit"
                class="w-full !bg-[#0B2A6B] hover:!bg-[#0A245D] !text-white">
                Registrarse
            </flux:button>
        </div>
    </form>

    {{-- ¿Ya tenés cuenta? --}}
    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-[#6F84A9] mt-4">
        ¿Ya tenés cuenta?
        <flux:link :href="route('login')" wire:navigate class="text-[#1F3B70] hover:opacity-90">Iniciá sesión</flux:link>
    </div>
</div>
