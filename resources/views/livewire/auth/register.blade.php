<div class="min-h-screen flex flex-col justify-center items-center bg-gray-100 p-4">

    <!-- Contenedor principal -->
    <div class="w-full max-w-md bg-white rounded-2xl shadow-md p-8">

        <!-- Logo / Ícono -->
        <div class="flex justify-center mb-6">
            <svg class="w-16 h-16 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2L1 7l11 5 9-4.09V17h2V7L12 2z"/>
            </svg>
        </div>

        <!-- Encabezado -->
        <x-auth-header 
            :title="__('Create an account')" 
            :description="__('Enter your details below to create your account')" 
            class="text-center mb-6"
        />

        <!-- Session Status -->
        <x-auth-session-status class="text-center mb-4" :status="session('status')" />

        <!-- Formulario -->
        <form wire:submit="register" class="flex flex-col gap-4">

            <!-- Nombre -->
            <flux:input
                wire:model="name"
                :label="__('Name')"
                type="text"
                required
                autofocus
                autocomplete="name"
                :placeholder="__('Full name')"
                class="rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
            />

            <!-- Email -->
            <flux:input
                wire:model="email"
                :label="__('Email address')"
                type="email"
                required
                autocomplete="email"
                placeholder="email@example.com"
                class="rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
            />

            <!-- Password -->
            <flux:input
                wire:model="password"
                :label="__('Password')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('Password')"
                viewable
                class="rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
            />

            <!-- Confirm Password -->
            <flux:input
                wire:model="password_confirmation"
                :label="__('Confirm password')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('Confirm password')"
                viewable
                class="rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
            />

            <!-- Botón -->
            <div class="mt-4">
                <flux:button type="submit" variant="primary" class="w-full py-2 px-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium shadow-sm">
                    {{ __('Create account') }}
                </flux:button>
            </div>

        </form>

        <!-- Link a login -->
        <div class="mt-6 text-center text-sm text-gray-600">
            {{ __('Already have an account?') }}
            <flux:link :href="route('login')" wire:navigate class="text-indigo-600 hover:text-indigo-500 font-medium">
                {{ __('Log in') }}
            </flux:link>
        </div>

    </div>
</div>
