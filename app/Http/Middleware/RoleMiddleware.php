<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * 
     * Uso: ->middleware(['auth','verified','role:profesor'])
     *      ->middleware(['auth','role:admin,profesor']) // varios roles
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();
    
        if (!$user) {
            return $request->expectsJson()
                ? abort(401, 'No autenticado')
                : redirect()->route('login');
        }
    
        // Normalizar roles (separar por coma si vinieron en una sola cadena)
        if (count($roles) === 1 && str_contains($roles[0], ',')) {
            $roles = explode(',', $roles[0]);
        }
    
        if ($user->hasAnyRole(...$roles)) {
            return $next($request);
        }
    
        return $request->expectsJson()
            ? abort(403, 'Acceso denegado')
            : abort(403, 'Acceso denegado'); // o redirect a vista de "sin permisos"
    }

}
