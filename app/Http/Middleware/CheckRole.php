<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
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

