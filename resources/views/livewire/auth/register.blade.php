<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $first_name = '';
    public string $last_name = '';
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
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['name'] = trim($validated['first_name'].' '.$validated['last_name']);
        unset($validated['first_name'], $validated['last_name']);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($user = User::create($validated))));

        Auth::login($user);

        $this->redirectIntended(route('dashboard', absolute: false), navigate: true);
    }
};
?>

<div class="min-h-screen flex flex-col justify-center items-center bg-slate-900">
    <div class="w-full max-w-md sm:max-w-xl md:max-w-3xl bg-slate-800 rounded-lg shadow-lg p-8">

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

            <!-- Nombre y Apellido -->
            <div class="flex gap-3">
                <div class="w-1/2">
                    <label class="block text-sm text-gray-300 mb-1">Nombre</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-2 flex items-center text-gray-400">
                            <!-- Heroicon usuario -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a8.25 
                                      8.25 0 1115 0v.75H4.5v-.75z"/>
                            </svg>
                        </span>
                        <input type="text" wire:model="first_name" placeholder="Ej: Juan"
                               class="w-full pl-8 p-2 bg-slate-900 border border-slate-700
                                      rounded-md text-white focus:ring-2 focus:ring-blue-500">
                        @error('first_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="w-1/2">
                    <label class="block text-sm text-gray-300 mb-1">Apellido</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-2 flex items-center text-gray-400">
                            <!-- Heroicon usuario -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a8.25 
                                      8.25 0 1115 0v.75H4.5v-.75z"/>
                            </svg>
                        </span>
                        <input type="text" wire:model="last_name" placeholder="Ej: Pérez"
                               class="w-full pl-8 p-2 bg-slate-900 border border-slate-700
                                      rounded-md text-white focus:ring-2 focus:ring-blue-500">
                        @error('last_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm text-gray-300 mb-1">Email Institucional</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-2 flex items-center text-gray-400">
                        <!-- Heroicon correo -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 
                                  2.25H4.5a2.25 2.25 0 01-2.25-2.25V6.75m19.5 
                                  0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 
                                  00-2.25 2.25m19.5 0v.243a2.25 2.25 0 
                                  01-1.07 1.916l-7.5 4.615a2.25 2.25 0 
                                  01-2.36 0L3.32 8.91a2.25 2.25 0 
                                  01-1.07-1.916V6.75"/>
                        </svg>
                    </span>
                    <input type="email" wire:model="email" placeholder="usuario@frre.utn.edu.ar"
                           class="w-full pl-8 p-2 bg-slate-900 border border-slate-700
                                  rounded-md text-white focus:ring-2 focus:ring-blue-500">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Contraseña -->
            <div>
                <label class="block text-sm text-gray-300 mb-1">Contraseña</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-2 flex items-center text-gray-400">
                        <!-- Heroicon candado -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M16.5 10.5V7.125a4.125 4.125 0 
                                  10-8.25 0V10.5m11.25 0H4.5A2.25 2.25 
                                  0 002.25 12.75v7.5A2.25 2.25 0 
                                  004.5 22.5h15a2.25 2.25 0 
                                  002.25-2.25v-7.5a2.25 2.25 
                                  0 00-2.25-2.25z"/>
                        </svg>
                    </span>
                    <input type="password" wire:model="password" placeholder="********"
                           class="w-full pl-8 p-2 bg-slate-900 border border-slate-700
                                  rounded-md text-white focus:ring-2 focus:ring-blue-500">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
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
                    </span>
                    <input type="password" wire:model="password_confirmation" placeholder="********"
                           class="w-full pl-8 p-2 bg-slate-900 border border-slate-700
                                  rounded-md text-white focus:ring-2 focus:ring-blue-500">
                    @error('password_confirmation')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
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
