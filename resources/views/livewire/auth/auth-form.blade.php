@php $isLogin = $this->isLogin; @endphp

<div class="flex flex-col gap-6 mx-auto w-full max-w-md">

    {{-- Encabezado institucional --}}
    <x-auth-header
    title="Mi Perfil UTN"
    description="Sistema de gestión de perfiles estudiantiles" />

    {{-- Tabs dinámicos --}}
    <div class="grid grid-cols-2 p-1 rounded-xl bg-[#EEF1F6] shadow-inner">
        <button type="button"
                wire:click="showLogin"
                class="py-2 rounded-lg text-sm font-semibold transition-all duration-150
                       {{ $isLogin ? 'bg-white shadow text-[#1F3B70]' : 'text-[#6F84A9] hover:text-[#1F3B70]' }}">
            Iniciar Sesión
        </button>
        <button type="button"
                wire:click="showRegister"
                class="py-2 rounded-lg text-sm font-semibold transition-all duration-150
                       {{ !$isLogin ? 'bg-white shadow text-[#1F3B70]' : 'text-[#6F84A9] hover:text-[#1F3B70]' }}">
            Registrarse
        </button>
    </div>

    {{-- Estado de sesión --}}
    <x-auth-session-status class="text-center" :status="session('status')" />

    {{-- ================= LOGIN ================= --}}
    @if ($isLogin)
        <form wire:submit="login" class="space-y-5">
            {{-- Email --}}
            <x-auth.input label="Email Institucional"
                          name="email"
                          model="email"
                          type="email"
                          placeholder="usuario@frre.utn.edu.ar" />

            {{-- Contraseña --}}
            <x-auth.password label="Contraseña"
                             model="password"
                             show="{{ $showPassword }}"
                             toggle="togglePassword"
                             placeholder="••••••••" />

            {{-- Link a recuperación --}}
            <div class="text-right">
                @if (Route::has('password.request'))
                    <flux:link class="text-sm text-[#6F84A9] hover:text-[#1F3B70] transition"
                               :href="route('password.request')"
                               wire:navigate>
                        ¿Olvidaste tu contraseña?
                    </flux:link>
                @endif
            </div>

            {{-- Remember me --}}
            <div class="text-[#1F3B70]">
                <flux:checkbox wire:model="remember" :label="__('Recuérdame')" />
            </div>

            {{-- Submit --}}
            <flux:button variant="primary"
                         type="submit"
                         class="w-full !bg-[#0B2A6B] hover:!bg-[#0A245D] !text-white">
                Iniciar Sesión
            </flux:button>
        </form>
    @endif

    {{-- ================= REGISTER ================= --}}
    @unless ($isLogin)
        <form wire:submit="register" class="space-y-5">
            <x-auth.input label="Nombre" name="first_name" model="first_name" placeholder="Ej: Juan" />
            <x-auth.input label="Apellido" name="last_name" model="last_name" placeholder="Ej: Pérez" />
            <x-auth.input label="Email Institucional" name="email" model="email" type="email" placeholder="usuario@frre.utn.edu.ar" />

            {{-- Contraseña --}}
            <x-auth.password label="Contraseña"
                             model="password"
                             show="{{ $showPassword }}"
                             toggle="togglePassword"
                             placeholder="••••••••" />

            {{-- Confirmación --}}
            <x-auth.password label="Confirmar contraseña"
                             model="password_confirmation"
                             show="{{ $showPasswordConfirm }}"
                             toggle="togglePasswordConfirm"
                             placeholder="••••••••" />

            <flux:button variant="primary"
                         type="submit"
                         class="w-full !bg-[#0B2A6B] hover:!bg-[#0A245D] !text-white">
                Registrarse
            </flux:button>
        </form>
    @endunless
</div>
