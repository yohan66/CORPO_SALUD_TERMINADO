<?php

namespace App\Http\Controllers;

use App\Models\ActaVerificacion;
use App\Models\Bien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;

class ActaVerificacionController extends Controller
{
    public function index()
    {
        $actas = ActaVerificacion::orderByDesc('created_at')->get();
        return response()->json($actas);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'institucion_nombre' => ['required', 'string', 'max:255'],
            'sede_nombre'        => ['required', 'string', 'max:255'],
            'sede_codigo'        => ['nullable', 'string', 'max:50'],
            'auditor_nombre'     => ['required', 'string', 'max:150'],
            'auditor_cedula'     => ['required', 'string', 'max:15'],
            'custodio_nombre'    => ['required', 'string', 'max:150'],
            'custodio_cedula'    => ['required', 'string', 'max:15'],
            'bienes_ids'         => ['required', 'array', 'min:1'],
            'bienes_ids.*'       => ['exists:bienes,id'],
            'observaciones'      => ['nullable', 'array'],
            'observaciones.*'    => ['nullable', 'string'],
            'estados_fisicos'    => ['nullable', 'array'],
            'estados_fisicos.*'  => [Rule::in(['Excelente', 'Bueno', 'Regular', 'Malo'])],
        ]);

        DB::beginTransaction();
        try {
            $totalAsignados = count($data['bienes_ids']);
            $totalVerificados = $totalAsignados;

            $numActa = 'ACTA-VER-' . now()->format('Y') . '-' . str_pad((ActaVerificacion::count() + 1), 5, '0', STR_PAD_LEFT);
            $hash = hash('sha256', $numActa . now() . $request->user()->cedula);

            $acta = ActaVerificacion::create([
                'numero' => $numActa,
                'institucion_nombre' => $data['institucion_nombre'],
                'sede_nombre' => $data['sede_nombre'],
                'sede_codigo' => $data['sede_codigo'],
                'auditor_nombre' => $data['auditor_nombre'],
                'auditor_cedula' => $data['auditor_cedula'],
                'custodio_nombre' => $data['custodio_nombre'],
                'custodio_cedula' => $data['custodio_cedula'],
                'fecha_emision' => now(),
                'hora_emision' => now(),
                'total_asignados' => $totalAsignados,
                'total_verificados' => $totalVerificados,
                'total_faltantes' => 0,
                'url_verificacion' => url('/actas/verificar/' . $hash),
                'hash_documento' => $hash,
            ]);

            $bienes = Bien::whereIn('id', $data['bienes_ids'])->get();
            $observaciones = $data['observaciones'] ?? [];
            $estadosFisicos = $data['estados_fisicos'] ?? [];

            foreach ($bienes as $index => $bien) {
                $acta->bienes()->attach($bien->id, [
                    'observacion_auditoria' => $observaciones[$index] ?? null,
                    'estado_conservacion'   => $estadosFisicos[$index] ?? $bien->estado_conservacion,
                ]);
            }

            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => 'Acta de verificación generada exitosamente.',
                'data'    => $acta->load('bienes'),
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'  => 'error',
                'message' => 'Error al generar el acta de verificación.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function show(ActaVerificacion $acta)
    {
        return response()->json($acta->load('bienes'));
    }

    public function pdf(ActaVerificacion $acta)
    {
        $acta->load('bienes');

        $qrBase64 = base64_encode(
            QrCode::format('png')->size(150)->margin(0)->generate($acta->url_verificacion)
        );

        $pdf = Pdf::loadView('pdf.acta_verificacion', [
            'acta' => $acta,
            'qrBase64' => $qrBase64,
        ]);

        $pdf->setPaper('legal', 'portrait');

        return $pdf->download("Acta-Verificacion-{$acta->numero}.pdf");
    }
}
