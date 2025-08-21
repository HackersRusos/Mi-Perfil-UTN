<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen flex bg-white dark:bg-zinc-800">
        @php
            $u = auth()->user();
            $homeRoute = route('home');
            if ($u) {
                if ($u->hasAnyRole('admin','3'))      $homeRoute = route('admin.dashboard');
                elseif ($u->hasAnyRole('profesor','2')) $homeRoute = route('profesor.dashboard');
                elseif ($u->hasAnyRole('estudiante','1')) $homeRoute = route('dashboard');
            }
        @endphp

        <!-- Sidebar -->
        <flux:sidebar sticky stashable 
            class="h-screen border-e border-zinc-200 bg-zinc-50 
                   dark:border-zinc-700 dark:bg-zinc-900 w-64 flex-shrink-0">

            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ $homeRoute }}" 
               class="me-5 flex items-center space-x-2 rtl:space-x-reverse p-4" 
               wire:navigate>
                <x-app-logo />
            </a>

            <flux:navlist.group heading="Navegación" class="grid">
                {{-- Estudiante (rol 1) --}}
                @role('estudiante','1')
                <flux:navlist.item icon="home"
                    :href="route('dashboard')"
                    :current="request()->routeIs('dashboard')"
                    wire:navigate>
                    Mi Perfil
                </flux:navlist.item>
                @endrole

                {{-- Profesor (rol 2) --}}
                @role('profesor','2')
                <flux:navlist.item icon="users"
                    :href="route('profesor.dashboard')"
                    :current="request()->routeIs('profesor*')"
                    wire:navigate>
                    Estudiantes
                </flux:navlist.item>
                @endrole

                {{-- Admin (rol 3) --}}
                @role('admin','3')
                <flux:navlist.item icon="users"
                    :href="route('admin.dashboard')"
                    :current="request()->routeIs('admin*')"
                    wire:navigate>
                    Gestión de Usuarios
                </flux:navlist.item>
                @endrole
            </flux:navlist.group>

            <flux:spacer />

            <!-- Desktop User Menu -->
            <flux:dropdown position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevrons-up-down"
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>
                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" 
                            icon="cog" wire:navigate>
                            {{ __('Settings') }}
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" 
                            icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <!-- Contenido principal -->
        <main class="flex-1 p-6 overflow-y-auto">
            {{ $slot }}
        </main>

        @fluxScripts
    </body>
</html>
