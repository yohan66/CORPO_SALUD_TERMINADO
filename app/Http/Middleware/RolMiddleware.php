<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RolMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $usuario = auth()->user();

        if (!in_array($usuario->rol, $roles)) {
            abort(403, 'Acceso denegado. No tiene los permisos necesarios para esta acción.');
        }

        return $next($request);
    }
}
