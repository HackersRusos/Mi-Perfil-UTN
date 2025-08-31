<div class="flex flex-col gap-6 mx-auto w-full max-w-md">

    {{-- Encabezado institucional --}}
    <x-auth-header
    title=""
    description="" />


    {{-- Título --}}
    <div class="text-center space-y-1">
        <h2 class="text-2xl font-bold text-[#1F3B70]">¿Olvidaste tu contraseña?</h2>
        <p class="text-sm text-[#6F84A9]">
            Ingresá tu email institucional y te enviaremos un enlace para restablecerla.
        </p>
    </div>

    {{-- Estado de sesión --}}
    <x-auth-session-status class="text-center" :status="session('status')" />

    {{-- Formulario --}}
    <form wire:submit="sendPasswordResetLink" class="space-y-6">

        {{-- Email --}}
        <x-auth.input label="Email Institucional"
                      name="email"
                      model="email"
                      type="email"
                      placeholder="usuario@frre.utn.edu.ar" />

        {{-- Botón --}}
        <flux:button variant="primary"
                     type="submit"
                     class="w-full !bg-[#0B2A6B] hover:!bg-[#0A245D] !text-white">
            Enviar enlace de recuperación
        </flux:button>
    </form>
</div>
