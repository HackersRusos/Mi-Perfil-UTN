<flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
    <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

    @php
        $u = auth()->user();
        if ($u->hasAnyRole('admin','3')) {
            $panel = route('admin.dashboard');
        } elseif ($u->hasAnyRole('profesor','2')) {
            $panel = route('profesor.dashboard');
        } elseif ($u->hasAnyRole('estudiante','1')) {
            $panel = route('estudiante.dashboard');
        } else {
            $panel = route('home');
        }
    @endphp

    <a href="{{ $panel }}" class="ms-2 me-5 flex items-center space-x-2 rtl:space-x-reverse lg:ms-0" wire:navigate>
        <img src="{{ asset('images/UTN_FRRE.png') }}" alt="UTN FRRe" class="h-10 w-auto">
        <span class="text-lg font-semibold text-[#1F3B70]">Formosa</span>
    </a>

    {{-- Navegación dinámica según rol --}}
    <flux:navlist.group heading="Navegación" class="grid">

        {{-- Estudiante y Profesor comparten "Mi Perfil" --}}
        @if(auth()->user()->hasAnyRole('estudiante','1','profesor','2'))
            <flux:navlist.item icon="user"
                :href="route('estudiante.dashboard')"
                :current="request()->routeIs('estudiante.dashboard')"
                wire:navigate>
                Mi Perfil
            </flux:navlist.item>
        @endif

        {{-- Solo Profesor --}}
        @if(auth()->user()->hasAnyRole('profesor','2'))
            <flux:navlist.item icon="users"
                :href="route('profesor.dashboard')"
                :current="request()->routeIs('profesor*')"
                wire:navigate>
                Estudiantes
            </flux:navlist.item>
        @endif

        {{-- Solo Admin --}}
        @if(auth()->user()->hasAnyRole('admin','3'))
            <flux:navlist.item icon="shield-check"
                :href="route('admin.dashboard')"
                :current="request()->routeIs('admin*')"
                wire:navigate>
                Usuarios
            </flux:navlist.item>
        @endif
    </flux:navlist.group>

    <flux:spacer />

    {{-- Menú de usuario con Logout --}}
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
                            <span class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
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
                <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
            </flux:menu.radio.group>

            <flux:menu.separator />

            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                    {{ __('Cerrar sesión') }}
                </flux:menu.item>
            </form>
        </flux:menu>
    </flux:dropdown>
</flux:sidebar>
