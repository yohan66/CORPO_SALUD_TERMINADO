<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TwoFactorMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (!empty($roles) && !in_array(auth()->user()->rol, $roles)) {
            abort(403, 'Acceso denegado.');
        }

        /* @var \App\Models\User $user */
        $user = auth()->user();

        if (!$user->hasVerifiedTwoFactor()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Debe completar la autenticación de dos factores para acceder.',
                'require_2fa' => true,
            ], 403);
        }

        return $next($request);
    }
}
