<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string[] ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = auth()->user();

        // 1. Si no hay usuario, mandarlo al login
        if (!$user) {
            return redirect('/login');
        }

        // 2. --- BYPASS DE SEGURIDAD PARA EL DUEÑO ---
        // Esto garantiza que siempre puedas entrar si algo falla en la DB.
        if ($user->email === 'soporte.crisadones@gmail.com') {
            return $next($request);
        }

        // 3. Verificación normal de roles (usando slugs)
        foreach ($roles as $role) {
            // El role puede llegar como string separado por comas: "admin,boss"
            $individualRoles = explode(',', $role);
            foreach ($individualRoles as $r) {
                if ($user->hasRole(trim($r))) {
                    return $next($request);
                }
            }
        }

        // 4. Si no tiene ninguno, denegar acceso
        abort(403, 'Acceso denegado: No tienes el rol necesario (' . ($user->role->slug ?? 'Sin Rol') . ')');
    }
}
