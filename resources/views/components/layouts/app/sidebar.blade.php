    @php
        $u = auth()->user();
    
        if ($u->hasAnyRole('admin','3')) {
            $panel = route('admin.dashboard');
        } elseif ($u->hasAnyRole('profesor','2')) {
            $panel = route('profesor.dashboard');
        } elseif ($u->hasAnyRole('estudiante','1')) {
            // Mi perfil del estudiante ahora es por DNI
            $panel = route('estudiantes.show', $u->profile->dni);
        } else {
            $panel = route('home');
        }
    @endphp

<flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
    <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

    {{-- Logo superior --}}
    <a href="{{ $panel }}" class="ms-2 me-5 flex items-center space-x-2 rtl:space-x-reverse lg:ms-0" wire:navigate>
        <img src="{{ asset('images/UTN_FRRE.png') }}" alt="UTN FRRe" class="h-10 w-auto">
        <span class="text-lg font-semibold text-[#1F3B70]">Formosa</span>
    </a>

    {{-- Navegación dinámica --}}
    <flux:navlist.group heading="Navegación" class="grid">

        {{-- Mi Perfil: válido para estudiante y profesor --}}
        @if($u->hasAnyRole('estudiante','1','profesor','2'))
            <flux:navlist.item icon="user"
                :href="route('estudiantes.show', auth()->user()->profile?->dni ?? 'no-perfil')"
                :current="request()->routeIs('estudiantes.show') && request()->route('profile')->dni === auth()->user()->profile->dni"
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

    </flux:navlist.group>

    <flux:spacer />

    {{-- Menú de usuario --}}
    <flux:dropdown position="bottom" align="start">
        <flux:profile
            :name="auth()->user()->name"
            :initials="auth()->user()->initials()"
            icon-trailing="chevrons-up-down"
        />
        <flux:menu class="w-[220px]">
            <div class="px-3 py-2 text-sm">
                <p class="font-semibold">{{ auth()->user()->name }}</p>
                <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
            </div>
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
