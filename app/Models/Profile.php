<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','apellido','nombre','comision','telefono','carrera','dni','foto_path','social_links'
    ];

    // Convierte JSON <-> array (como pide el README)
    protected $casts = [
        'social_links' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Ayudante pedido en el README.
     * Normaliza a un link wa.me con prefijo +54 (Argentina) por defecto.
     * No modifica cómo se guarda el teléfono; solo construye la URL.
     */
    public function whatsappUrl(): string
    {
        $raw = (string) ($this->telefono ?? '');
        $digits = preg_replace('/\D+/', '', $raw); // solo dígitos

        if ($digits === '') {
            return '#';
        }
        if (str_starts_with($digits, '0')) {
            $digits = substr($digits, 1); // quita 0 inicial
        }
        if (!str_starts_with($digits, '54')) {
            $digits = '54'.$digits;       // AR por defecto
        }
        return 'https://wa.me/'.$digits;
    }

    public function getRouteKeyName()
    {
        return 'dni';
    }
}
