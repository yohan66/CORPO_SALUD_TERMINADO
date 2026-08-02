<?php

namespace App\Http\Controllers;

use App\Models\ActaVerificacion;
use Illuminate\Http\Request;

class VerificacionActaController extends Controller
{
    public function show(Request $request, string $hash)
    {
        $acta = ActaVerificacion::where('hash_documento', $hash)->firstOrFail();
        $acta->load('bienes');

        return response()->json([
            'valid' => true,
            'acta' => $acta,
        ]);
    }
}
