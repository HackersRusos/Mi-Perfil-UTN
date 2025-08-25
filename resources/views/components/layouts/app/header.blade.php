<flux:header container class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
    <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

    {{-- Logo redirige al dashboard según rol --}}
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

    {{-- Navbar links (solo desktop) --}}
    <flux:navbar class="-mb-px max-lg:hidden">

        {{-- Mi Perfil: válido para estudiante y profesor --}}
        @if($u->hasAnyRole('estudiante','1','profesor','2'))
            <flux:navlist.item icon="user"
                :href="route('estudiante.dashboard')"
                :current="request()->routeIs('estudiante*')"
                wire:navigate>
                Mi Perfil
            </flux:navlist.item>
        @endif
        
        {{-- Profesores tienen además Estudiantes --}}
        @if($u->hasAnyRole('profesor','2'))
            <flux:navlist.item icon="users"
                :href="route('profesor.dashboard')"
                :current="request()->routeIs('profesor*')"
                wire:navigate>
                Estudiantes
            </flux:navlist.item>
        @endif

        {{-- Admin → Usuarios --}}
        @if($u->hasAnyRole('admin','3'))
            <flux:navlist.item icon="shield-check"
                :href="route('admin.dashboard')"
                :current="request()->routeIs('admin*')"
                wire:navigate>
                Usuarios
            </flux:navlist.item>
        @endif
    </flux:navbar>

    <flux:spacer />

    {{-- User menu --}}
    <flux:dropdown position="top" align="end">
        <flux:profile class="cursor-pointer" :initials="auth()->user()->initials()" />
        <flux:menu>
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
</flux:header>
