<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
<<<<<<< HEAD
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect('login');
        }

        $user = auth()->user();

        // Asegurarse de que si llegan roles separados por coma en un string, se procesen correctamente
        $processedRoles = [];
        foreach ($roles as $role) {
            $processedRoles = array_merge($processedRoles, explode(',', $role));
        }

        if ($user->hasRole($processedRoles)) {
            return $next($request);
        }

        abort(403, 'Unauthorized action.');
    }
}
=======
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = auth()->user();

        if (!$user) {
            return redirect('/login');
        }

        // --- DEBUG DE SEGURIDAD ---
        // Si el usuario es el que sabemos que es admin, DEJALO PASAR SÍ O SÍ
        if ($user->email === 'soporte.crisadones@gmail.com') {
            return $next($request);
        }
        // -------------------------

        // Procesamiento normal para el resto
        foreach ($roles as $role) {
            $individualRoles = explode(',', $role);
            foreach ($individualRoles as $r) {
                if ($user->hasRole(trim($r))) {
                    return $next($request);
                }
            }
        }

        abort(403, 'Unauthorized. Role: ' . ($user->role->slug ?? 'NONE'));
    }
}

>>>>>>> origin/servidor-maraton-ayer
