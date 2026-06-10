@php
    $links = [
        [
            'name' => 'Posts', //Nombre del enlace
            'icon' => 'layout-grid', //Icono del enlace (puede ser un nombre de icono de tu biblioteca de iconos)
            'url' => route('posts.index'), //URL a la que apunta el enlace
            'current' => request()->routeIs('posts.*'), //Determina si el enlace está activo basándose en la ruta actual
        ],
    ];
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>
        {{ filled($title ?? null) ? $title . ' - ' . config('app.name', 'Laravel') : config('app.name', 'Laravel') }}
    </title>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- importar SweetAlert2 -->

    {{-- Permite agregar estilos adicionales desde las vistas que extienden este layout --}}
    @stack('css')

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance

</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">
    <flux:header container class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.toggle class="lg:hidden mr-2" icon="bars-2" inset="left" />

        <x-app-logo href="{{ route('dashboard') }}" wire:navigate />

        <flux:navbar class="-mb-px max-lg:hidden">
            @foreach ($links as $link)
                <flux:navbar.item :icon="$link['icon']" :href="$link['url']" :current="$link['current']"
                    wire:navigate>
                    {{ $link['name'] }}
                </flux:navbar.item>
            @endforeach
        </flux:navbar>

        <flux:spacer />
        @auth
            <x-desktop-user-menu />
        @else
            <flux:dropdown position="bottom" align="start">
                <flux:button class="cursor-pointer" icon="user" />
                <flux:menu>
                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('login')" wire:navigate>
                            {{ __('Ingresar') }}
                        </flux:menu.item>
                        <flux:menu.item :href="route('register')" wire:navigate>
                            {{ __('Registrarse') }}
                        </flux:menu.item>
                    </flux:menu.radio.group>
                </flux:menu>
            </flux:dropdown>

        @endauth

    </flux:header>

    <!-- Mobile Menu -->
    <flux:sidebar collapsible="mobile" sticky
        class="lg:hidden border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.header>
            <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
            <flux:sidebar.collapse
                class="in-data-flux-sidebar-on-desktop:not-in-data-flux-sidebar-collapsed-desktop:-mr-2" />
        </flux:sidebar.header>

        <flux:sidebar.nav>
            <flux:sidebar.group :heading="__('Platform')">
                @foreach ($links as $link)
                    <flux:sidebar.item :icon="$link['icon']" :href="$link['url']" :current="$link['current']"
                        wire:navigate>
                        {{ $link['name'] }}
                    </flux:sidebar.item>
                @endforeach
            </flux:sidebar.group>
        </flux:sidebar.nav>

        <flux:spacer />

        <flux:sidebar.nav>
            <flux:sidebar.item icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit"
                target="_blank">
                {{ __('Repository') }}
            </flux:sidebar.item>
            <flux:sidebar.item icon="book-open-text" href="https://laravel.com/docs/starter-kits#livewire"
                target="_blank">
                {{ __('Documentation') }}
            </flux:sidebar.item>
        </flux:sidebar.nav>
    </flux:sidebar>

    <flux:main>
        {{ $slot }}
    </flux:main>

    @persist('toast')
        <flux:toast.group>
            <flux:toast />
        </flux:toast.group>
    @endpersist

    @fluxScripts
    @stack('js') {{-- Permite agregar scripts adicionales desde las vistas que extienden este layout --}}

    @if (session('swal'))
        {{-- condicional para mostrar el mensaje de SweetAlert2 si existe en la sesión --}}
        <script>
            Swal.fire(
                @json(session('swal'))); //Convierte el mensaje de la sesión a formato JSON para usarlo en SweetAlert2
        </script>
    @endif
</body>

</html>
