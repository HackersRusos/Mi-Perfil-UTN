
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

        <!-- Volver al inicio -->
        <div class="mb-4">
            <a href="{{ url('/') }}" class="flex items-center text-blue-400 hover:text-blue-500 text-sm">
                <!-- Icono flecha (Heroicon) -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Volver al inicio
            </a>
        </div>

        <!-- Título -->
        <h1 class="text-2xl font-bold text-center text-white">Mi Perfil UTN</h1>
        <p class="text-sm text-gray-400 text-center mb-6">
            Sistema de gestión de perfiles estudiantiles
        </p>

        <!-- Botones Iniciar Sesión / Registrarse -->
        <div class="flex mb-6">
            <a href="{{ route('login') }}"
               class="w-1/2 text-center py-2 border border-slate-700 rounded-l-lg
                      text-gray-300 hover:bg-slate-700 transition">
                Iniciar Sesión
            </a>
            <span class="w-1/2 text-center py-2 bg-slate-700 text-white rounded-r-lg">
                Registrarse
            </span>
        </div>

        <!-- Formulario -->
        <form wire:submit.prevent="register" class="space-y-4">

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

            <!-- Confirmar Contraseña -->
            <div>
                <label class="block text-sm text-gray-300 mb-1">Confirmar Contraseña</label>
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
                    <input type="password" wire:model="password_confirmation" placeholder="********"
                           class="w-full pl-8 p-2 bg-slate-900 border border-slate-700
                                  rounded-md text-white focus:ring-2 focus:ring-blue-500">
                    @error('password_confirmation')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Botón -->
            <button type="submit"
                    class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600 
                           transition font-semibold">
                Registrarse
            </button>
        </form>
    </div>
</div>
