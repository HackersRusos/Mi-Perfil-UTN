<div class="flex flex-col gap-6 mx-auto w-full max-w-md">

    {{-- Encabezado institucional --}}
    <x-auth-header
    title="Verificá tu correo"
    description="Te enviamos un enlace de verificación a tu email. Si no lo recibiste, podés solicitar otro." />


    {{-- Título --}}
    <div class="text-center space-y-1">
        <h2 class="text-2xl font-bold text-[#1F3B70]">Verificá tu correo</h2>
        <p class="text-sm text-[#6F84A9]">
            Te enviamos un enlace de verificación a tu email. Si no lo recibiste, podés solicitar otro.
        </p>
    </div>

    {{-- Mensaje de estado --}}
    <x-auth-session-status class="text-center" :status="session('status')" />

    {{-- Botón para reenviar el correo --}}
    <form wire:submit="resendVerificationEmail" class="space-y-6">

        <flux:button variant="primary"
                     type="submit"
                     class="w-full !bg-[#0B2A6B] hover:!bg-[#0A245D] !text-white">
            Reenviar enlace de verificación
        </flux:button>
    </form>
</div>
