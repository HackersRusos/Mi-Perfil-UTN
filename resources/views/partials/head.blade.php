<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

{{-- Title dinámico con fallback --}}
<title>{{ $title ?? config('app.name', 'Mi Perfil UTN') }}</title>

{{-- Favicon y PWA icons --}}
<link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
<link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
<link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">

{{-- Fuente institucional (puede cambiarse si la UTN tiene otra oficial) --}}
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600&display=swap" rel="stylesheet" />

{{-- CSS y JS de Vite --}}
@vite(['resources/css/app.css', 'resources/js/app.js'])

{{-- Flux UI para modo claro/oscuro --}}
@fluxAppearance

{{-- SEO básico --}}
<meta name="description" content="Sistema de gestión de perfiles estudiantiles - UTN FRRe Extensión Formosa">
<meta name="author" content="UTN FRRe">

{{-- Seguridad --}}
<meta name="csrf-token" content="{{ csrf_token() }}">
