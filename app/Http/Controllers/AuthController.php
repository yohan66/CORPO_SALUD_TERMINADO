<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Credenciales inválidas.',
            ], 401);
        }

        $request->session()->regenerate();

        $usuario = Auth::user();

        return response()->json([
            'status'  => 'success',
            'message' => 'Inicio de sesión exitoso.',
            'data'    => [
                'id'    => $usuario->id,
                'nombre' => $usuario->nombre,
                'email' => $usuario->email,
                'cedula' => $usuario->cedula,
                'rol'   => $usuario->rol,
            ],
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'status'  => 'success',
            'message' => 'Sesión cerrada exitosamente.',
        ]);
    }

    public function me(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['status' => 'error', 'message' => 'No autenticado.'], 401);
        }

        return response()->json([
            'status' => 'success',
            'data'   => Auth::user(),
        ]);
    }
}
