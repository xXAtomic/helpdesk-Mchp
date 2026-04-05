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
