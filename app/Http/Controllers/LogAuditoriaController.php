<?php

namespace App\Http\Controllers;

use App\Models\LogAuditoria;
use Illuminate\Http\Request;

class LogAuditoriaController extends Controller
{
    public function index(Request $request)
    {
        $query = LogAuditoria::query();

        if ($request->has('tabla_afectada')) {
            $query->where('tabla_afectada', $request->tabla_afectada);
        }

        if ($request->has('usuario_cedula')) {
            $query->where('usuario_cedula', $request->usuario_cedula);
        }

        if ($request->has('accion')) {
            $query->where('accion', $request->accion);
        }

        $logs = $query->orderByDesc('creado_el')->paginate(50);

        return response()->json($logs);
    }

    public function show(LogAuditoria $log)
    {
        return response()->json($log);
    }
}
