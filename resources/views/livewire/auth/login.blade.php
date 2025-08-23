<?php

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;
    public bool $showPassword = false;

    public function togglePassword(): void
    {
        $this->showPassword = ! $this->showPassword;
    }

    public function login(): void
    {
        $this->validate();
        $this->ensureIsNotRateLimited();

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages(['email' => __('auth.failed')]);
        }

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        $u = Auth::user();
        
        $to = match (true) {
            $u->hasAnyRole('admin','3')      => route('admin.dashboard'),
            $u->hasAnyRole('profesor','2')   => route('profesor.dashboard'),
            $u->hasAnyRole('estudiante','1') => route('dashboard'),
            default                          => route('home'),
        };

        return $this->redirect($to, navigate: false);
    }

    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) return;

        event(new Lockout(request()));
        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }
}; ?>

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

    {{-- Estado --}}
    <x-auth-session-status class="text-center" :status="session('status')" />

    {{-- Formulario --}}
    <form wire:submit="login" class="space-y-5">
        {{-- Email --}}
        <div>
            <label class="block text-sm font-medium mb-1 text-[#1F3B70]">Email Institucional</label>

            {{-- WRAPPER con borde y fondo (input transparente dentro) --}}
            <div class="relative h-12 rounded-xl border border-[#D9E3F2] bg-[#F9FBFD]
                        focus-within:border-[#9DB2D6] focus-within:ring-1 focus-within:ring-[#9DB2D6]">

                {{-- Ícono --}}
                <svg class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 h-5 w-5 text-[#7C8FB1]"
                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M1.5 6.75A2.25 2.25 0 013.75 4.5h16.5a2.25 2.25 0 012.25 2.25v10.5A2.25 2.25 0 0120.25 19.5H3.75A2.25 2.25 0 011.5 17.25V6.75zM3 7.5l9 5.25L21 7.5" />
                </svg>

                {{-- Input transparente (sin borde/ring) --}}
                <flux:input
                    wire:model="email"
                    type="email"
                    required
                    autofocus
                    autocomplete="email"
                    placeholder="usuario@frre.utn.edu.ar"
                    class="pl-12 pr-4 w-full !h-12 !bg-transparent !ring-0 !border-0 focus:!ring-0 focus:!border-0" />
            </div>

            <flux:error name="email" />
        </div>

        {{-- Password --}}
        <div>
            <div class="flex items-center justify-between">
                <label class="block text-sm font-medium mb-1 text-[#1F3B70]">Contraseña</label>
                @if (Route::has('password.request'))
                    <flux:link class="text-sm text-[#6F84A9] hover:text-[#1F3B70]" :href="route('password.request')" wire:navigate>
                        ¿Olvidaste tu contraseña?
                    </flux:link>
                @endif
            </div>

            {{-- WRAPPER con borde y fondo (input transparente dentro) --}}
            <div class="relative h-12 rounded-xl border border-[#D9E3F2] bg-[#F9FBFD]
                        focus-within:border-[#9DB2D6] focus-within:ring-1 focus-within:ring-[#9DB2D6]">

                {{-- Ícono candado --}}
                <svg class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 h-5 w-5 text-[#7C8FB1]"
                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd" d="M12 1.5a4.5 4.5 0 00-4.5 4.5v3H6a2.25 2.25 0 00-2.25 2.25v7.5A2.25 2.25 0 006 21h12a2.25 2.25 0 002.25-2.25v-7.5A2.25 2.25 0 0018 9h-1.5v-3A4.5 4.5 0 0012 1.5zm-3 7.5v-3a3 3 0 116 0v3H9z" clip-rule="evenodd"/>
                </svg>

                {{-- Botón ojo (derecha) --}}
                <button type="button" wire:click="togglePassword"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-[#7C8FB1] hover:text-[#1F3B70]">
                    @if($showPassword)
                        {{-- Ojo abierto --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M2.25 12s3.75-7.5 9.75-7.5S21.75 12 21.75 12s-3.75 7.5-9.75 7.5S2.25 12 2.25 12z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    @else
                        {{-- Ojo tachado --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M3 3l18 18M10.5 10.5a3 3 0 014.243 4.243M6.25 6.252C4.19 8.084 2.94 10.137 2.25 12c0 0 3.75 7.5 9.75 7.5a9.748 9.748 0 006.873-2.748" />
                        </svg>
                    @endif
                </button>

                {{-- Input transparente (sin borde/ring) --}}
                <flux:input
                    wire:model="password"
                    :type="$showPassword ? 'text' : 'password'"
                    required
                    autocomplete="current-password"
                    placeholder="••••••••"
                    class="pl-12 pr-12 w-full !h-12 !bg-transparent !ring-0 !border-0 focus:!ring-0 focus:!border-0" />
            </div>

            <flux:error name="password" />
        </div>

        {{-- Remember --}}
        <div class="text-[#1F3B70]">
            <flux:checkbox wire:model="remember" :label="__('Recuérdame')" />
        </div>

        {{-- Botón principal --}}
        <div>
            <flux:button
                variant="primary"
                type="submit"
                class="w-full !bg-[#0B2A6B] hover:!bg-[#0A245D] !text-white">
                Iniciar Sesión
            </flux:button>
        </div>
    </form>

    {{-- Registro --}}
    @if (Route::has('register'))
        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-[#6F84A9] mt-4">
            ¿No tenés cuenta?
            <flux:link :href="route('register')" wire:navigate class="text-[#1F3B70] hover:opacity-90">Registrate</flux:link>
        </div>
    @endif
</div>
