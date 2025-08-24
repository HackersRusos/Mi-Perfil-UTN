<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Si el usuario ya está autenticado y entra a /login o /register,
     * redirigí según su rol.
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $u = Auth::guard($guard)->user();

                $to = match (true) {
                    $u->hasAnyRole('admin', '3')       => route('admin.dashboard'),
                    $u->hasAnyRole('profesor', '2')    => route('profesor.dashboard'),
                    $u->hasAnyRole('estudiante', '1')  => route('estudiante.dashboard'),
                    default                            => route('home'),
                };

                return redirect($to);
            }
        }

        return $next($request);
    }
}
