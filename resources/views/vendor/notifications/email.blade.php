<x-mail::message>
{{-- Logo UTN --}}
<div style="text-align: center; margin-bottom: 20px;">
    <img src="{{ asset('images/UTN_FRRE.png') }}" alt="Logo UTN" style="height: 70px;">
</div>

{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Whoops!')
@else
# @lang('Hola!')
@endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

{{-- Action Button --}}
@isset($actionText)
<?php
    $color = match ($level) {
        'success', 'error' => $level,
        default => 'primary',
    };
?>
<x-mail::button :url="$actionUrl" :color="$color">
{{ $actionText }}
</x-mail::button>
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
Saludos,<br>
**El equipo de Mi Perfil UTN 👩‍💻👨‍💻**
@endif

{{-- Subcopy --}}
@isset($actionText)
<x-slot:subcopy>
@lang(
    "Si tenés problemas haciendo clic en el botón \":actionText\", copiá y pegá la URL siguiente\n".
    'en tu navegador:',
    [
        'actionText' => $actionText,
    ]
) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
</x-slot:subcopy>
@endisset

{{-- Footer Institucional --}}
<hr style="margin:20px 0;">

<p style="text-align:center; font-size:12px; color:#6F84A9;">
Universidad Tecnológica Nacional – Facultad Regional Resistencia<br>
Sistema Mi Perfil UTN © {{ date('Y') }}
</p>
</x-mail::message>
