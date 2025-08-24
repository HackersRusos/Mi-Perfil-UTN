@php
    $isLogin = $this->isLogin;
@endphp

<div class="flex flex-col gap-6 mx-auto w-full max-w-md">
    {{-- Volver al inicio --}}
    <div>
        <flux:link href="{{ url('/') }}" wire:navigate class="inline-flex items-center text-sm text-[#6F84A9] hover:text-[#1F3B70]">
            &#8592; Volver al inicio
        </flux:link>
    </div>

    {{-- Encabezado institucional --}}
    <div class="text-center space-y-1">
        <h1 class="text-2xl font-bold tracking-tight text-[#1F3B70]">Mi Perfil UTN</h1>
        <p class="text-sm text-[#6F84A9]">Sistema de gestión de perfiles estudiantiles</p>
    </div>

    {{-- Tabs dinámicos --}}
    <div class="grid grid-cols-2 p-1 rounded-xl bg-[#EEF1F6]">
        <button type="button"
           wire:click="showLogin"
           class="text-center py-2 rounded-lg text-sm font-medium {{ $isLogin ? 'bg-white shadow text-[#1F3B70]' : 'text-[#6F84A9] hover:text-[#1F3B70]' }}">
            Iniciar Sesión
        </button>
        <button type="button"
           wire:click="showRegister"
           class="text-center py-2 rounded-lg text-sm font-medium {{ $isLogin ? 'text-[#6F84A9] hover:text-[#1F3B70]' : 'bg-white shadow text-[#1F3B70]' }}">
            Registrarse
        </button>
    </div>

    <x-auth-session-status class="text-center" :status="session('status')" />

    {{-- ========== LOGIN ========== --}}
    @if ($isLogin)
        <form wire:submit="login" class="space-y-5">
            {{-- Email --}}
            <div>
                <label class="block text-sm font-medium mb-1 text-[#1F3B70]">Email Institucional</label>
                <div class="relative h-12 rounded-xl border border-[#D9E3F2] bg-[#F9FBFD]
                            focus-within:border-[#9DB2D6] focus-within:ring-1 focus-within:ring-[#9DB2D6]">
                    <flux:input
                        wire:model="email"
                        type="email"
                        required
                        autofocus
                        autocomplete="email"
                        placeholder="usuario@frre.utn.edu.ar"
                        class="pl-4 pr-4 w-full !h-12 !bg-transparent !ring-0 !border-0 focus:!ring-0 focus:!border-0" />
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

                <div class="relative h-12 rounded-xl border border-[#D9E3F2] bg-[#F9FBFD]
                            focus-within:border-[#9DB2D6] focus-within:ring-1 focus-within:ring-[#9DB2D6]">
                    <button type="button" wire:click="togglePassword"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-[#7C8FB1] hover:text-[#1F3B70]">
                        {{ $showPassword ? 'Ocultar' : 'Mostrar' }}
                    </button>
                    <flux:input
                        wire:model="password"
                        :type="$showPassword ? 'text' : 'password'"
                        required
                        autocomplete="current-password"
                        placeholder="••••••••"
                        class="pl-4 pr-16 w-full !h-12 !bg-transparent !ring-0 !border-0 focus:!ring-0 focus:!border-0" />
                </div>
                <flux:error name="password" />
            </div>

            {{-- Remember --}}
            <div class="text-[#1F3B70]">
                <flux:checkbox wire:model="remember" :label="__('Recuérdame')" />
            </div>

            {{-- Submit --}}
            <div>
                <flux:button variant="primary" type="submit" class="w-full !bg-[#0B2A6B] hover:!bg-[#0A245D] !text-white">
                    Iniciar Sesión
                </flux:button>
            </div>
        </form>
    @endif

    {{-- ========== REGISTER ========== --}}
    @unless ($isLogin)
        <form wire:submit="register" class="space-y-5">
            {{-- Nombre --}}
            <div>
                <label class="block text-sm font-medium mb-1 text-[#1F3B70]">Nombre</label>
                <div class="relative h-12 rounded-xl border border-[#D9E3F2] bg-[#F9FBFD]
                            focus-within:border-[#9DB2D6] focus-within:ring-1 focus-within:ring-[#9DB2D6]">
                    <flux:input
                        wire:model="first_name"
                        type="text"
                        required
                        autofocus
                        autocomplete="given-name"
                        placeholder="Ej: Juan"
                        class="pl-4 pr-4 w-full !h-12 !bg-transparent !ring-0 !border-0 focus:!ring-0 focus:!border-0" />
                </div>
                <flux:error name="first_name" />
            </div>

            {{-- Apellido --}}
            <div>
                <label class="block text-sm font-medium mb-1 text-[#1F3B70]">Apellido</label>
                <div class="relative h-12 rounded-xl border border-[#D9E3F2] bg-[#F9FBFD]
                            focus-within:border-[#9DB2D6] focus-within:ring-1 focus-within:ring-[#9DB2D6]">
                    <flux:input
                        wire:model="last_name"
                        type="text"
                        required
                        autocomplete="family-name"
                        placeholder="Ej: Pérez"
                        class="pl-4 pr-4 w-full !h-12 !bg-transparent !ring-0 !border-0 focus:!ring-0 focus:!border-0" />
                </div>
                <flux:error name="last_name" />
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-sm font-medium mb-1 text-[#1F3B70]">Email Institucional</label>
                <div class="relative h-12 rounded-xl border border-[#D9E3F2] bg-[#F9FBFD]
                            focus-within:border-[#9DB2D6] focus-within:ring-1 focus-within:ring-[#9DB2D6]">
                    <flux:input
                        wire:model="email"
                        type="email"
                        required
                        autocomplete="email"
                        placeholder="usuario@frre.utn.edu.ar"
                        class="pl-4 pr-4 w-full !h-12 !bg-transparent !ring-0 !border-0 focus:!ring-0 focus:!border-0" />
                </div>
                <flux:error name="email" />
            </div>

            {{-- Password --}}
            <div>
                <label class="block text-sm font-medium mb-1 text-[#1F3B70]">Contraseña</label>
                <div class="relative h-12 rounded-xl border border-[#D9E3F2] bg-[#F9FBFD]
                            focus-within:border-[#9DB2D6] focus-within:ring-1 focus-within:ring-[#9DB2D6]">
                    <button type="button" wire:click="togglePassword"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-[#7C8FB1] hover:text-[#1F3B70] text-sm">
                        {{ $showPassword ? 'Ocultar' : 'Mostrar' }}
                    </button>
                    <flux:input
                        wire:model="password"
                        :type="$showPassword ? 'text' : 'password'"
                        required
                        autocomplete="new-password"
                        placeholder="••••••••"
                        class="pl-4 pr-16 w-full !h-12 !bg-transparent !ring-0 !border-0 focus:!ring-0 focus:!border-0" />
                </div>
                <flux:error name="password" />
            </div>

            {{-- Confirmación --}}
            <div>
                <label class="block text-sm font-medium mb-1 text-[#1F3B70]">Confirmar contraseña</label>
                <div class="relative h-12 rounded-xl border border-[#D9E3F2] bg-[#F9FBFD]
                            focus-within:border-[#9DB2D6] focus-within:ring-1 focus-within:ring-[#9DB2D6]">
                    <button type="button" wire:click="togglePasswordConfirm"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-[#7C8FB1] hover:text-[#1F3B70] text-sm">
                        {{ $showPasswordConfirm ? 'Ocultar' : 'Mostrar' }}
                    </button>
                    <flux:input
                        wire:model="password_confirmation"
                        :type="$showPasswordConfirm ? 'text' : 'password'"
                        required
                        autocomplete="new-password"
                        placeholder="••••••••"
                        class="pl-4 pr-16 w-full !h-12 !bg-transparent !ring-0 !border-0 focus:!ring-0 focus:!border-0" />
                </div>
                <flux:error name="password_confirmation" />
            </div>

            {{-- Botón --}}
            <div>
                <flux:button variant="primary" type="submit" class="w-full !bg-[#0B2A6B] hover:!bg-[#0A245D] !text-white">
                    Registrarse
                </flux:button>
            </div>
        </form>
    @endunless
</div>
