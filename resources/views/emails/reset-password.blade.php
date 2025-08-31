<x-mail::message>
<div style="text-align: center; margin-bottom: 20px;">
    <img src="{{ asset('images/UTN_FRRE.png') }}" alt="Logo UTN" style="height: 70px;">
</div>

# 🔐 Restablecé tu contraseña

¡Hola {{ $user->name }}! 👋  

Recibiste este correo porque solicitaste restablecer tu contraseña en **Mi Perfil UTN**.

<x-mail::button :url="$url">
Restablecer contraseña
</x-mail::button>

Si no solicitaste el cambio, podés ignorar este correo.  

Gracias,<br>
**El equipo de Mi Perfil UTN 👩‍💻👨‍💻**
</x-mail::message>
