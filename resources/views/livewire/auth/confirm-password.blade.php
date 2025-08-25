<div class="flex flex-col gap-6 mx-auto w-full max-w-md">

    {{-- Encabezado institucional --}}
    <x-auth-header
    title="Confirmar contraseña"
    description="Por seguridad, confirmá tu contraseña antes de continuar." />

    {{-- Título --}}
    <div class="text-center space-y-1">
        <h2 class="text-2xl font-bold text-[#1F3B70]">Confirmar contraseña</h2>
        <p class="text-sm text-[#6F84A9]">Por seguridad, confirmá tu contraseña antes de continuar.</p>
    </div>

    {{-- Estado de sesión --}}
    <x-auth-session-status class="text-center" :status="session('status')" />

    {{-- Formulario --}}
    <form wire:submit="confirmPassword" class="space-y-6">

        {{-- Campo contraseña --}}
        <x-auth.password label="Contraseña"
                         model="password"
                         show="{{ $showPassword }}"
                         toggle="togglePassword"
                         placeholder="••••••••" />

        {{-- Botón --}}
        <flux:button variant="primary"
                     type="submit"
                     class="w-full !bg-[#0B2A6B] hover:!bg-[#0A245D] !text-white">
            Confirmar
        </flux:button>
    </form>
</div>
