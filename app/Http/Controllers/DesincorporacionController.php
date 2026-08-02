<?php

namespace App\Http\Controllers;

use App\Models\Bien;
use App\Models\Desincorporacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DesincorporacionController extends Controller
{
    public function index()
    {
        $desincorporaciones = Desincorporacion::with('bien')->get();
        return response()->json($desincorporaciones);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'bien_id'             => ['required', 'exists:bienes,id'],
            'nro_providencia'     => ['required', 'string', 'max:50', 'unique:desincorporaciones,nro_providencia'],
            'motivo_baja'         => ['required', Rule::in(['Obsolescencia', 'Hurto', 'Deterioro', 'Donación', 'Desecho'])],
            'informe_tecnico_url' => ['required', 'string', 'max:255'],
            'aprobado_por_cedula' => ['required', 'string', 'max:15'],
            'fecha_baja'          => ['required', 'date'],
        ]);

        DB::beginTransaction();
        try {
            $desincorporacion = Desincorporacion::create($data);

            $bien = Bien::findOrFail($data['bien_id']);
            $bien->update(['estatus' => 'Desincorporado']);

            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => 'Desincorporación registrada exitosamente.',
                'data'    => $desincorporacion->load('bien'),
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'  => 'error',
                'message' => 'Error al registrar la desincorporación.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function show(Desincorporacion $desincorporacion)
    {
        return response()->json($desincorporacion->load('bien'));
    }
}
