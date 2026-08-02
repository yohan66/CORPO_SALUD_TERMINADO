<?php

namespace App\Http\Controllers;

use App\Models\Bien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Services\QRCodeService;

class BienController extends Controller
{
    public function index()
    {
        $bienes = Bien::all();
        return response()->json($bienes);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'codigo_patrimonial'  => ['required', 'string', 'max:50', Rule::unique('bienes', 'codigo_patrimonial')],
            'descripcion'         => ['required', 'string', 'max:1000'],
            'serial_fabrica'      => ['nullable', 'string', 'max:100'],
            'valor_adquisicion'   => ['required', 'numeric', 'min:0'],
            'estado_conservacion' => ['required', Rule::in(['Excelente', 'Bueno', 'Regular', 'Malo'])],
            'custodio_cedula'     => ['required', 'string', 'max:15'],
            'categoria'           => ['nullable', 'string', 'max:120'],
            'ubicacion'           => ['nullable', 'string', 'max:180'],
        ]);

        DB::beginTransaction();
        try {
            $bien = Bien::create($data);
            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => 'Bien nacional registrado exitosamente.',
                'data'    => $bien,
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'  => 'error',
                'message' => 'Error al registrar el bien público.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function show(Bien $bien)
    {
        return response()->json($bien);
    }

    public function update(Request $request, Bien $bien)
    {
        $data = $request->validate([
            'codigo_patrimonial'  => ['required', 'string', 'max:50', Rule::unique('bienes', 'codigo_patrimonial')],
            'descripcion'         => ['required', 'string', 'max:1000'],
            'serial_fabrica'      => ['nullable', 'string', 'max:100'],
            'valor_adquisicion'   => ['required', 'numeric', 'min:0'],
            'estado_conservacion' => ['required', Rule::in(['Excelente', 'Bueno', 'Regular', 'Malo'])],
            'estatus'             => ['required', Rule::in(['Activo', 'En Proceso de Desincorporación', 'Desincorporado', 'Transferido'])],
            'custodio_cedula'     => ['required', 'string', 'max:15'],
            'categoria'           => ['nullable', 'string', 'max:120'],
            'ubicacion'           => ['nullable', 'string', 'max:180'],
        ]);

        $bien->update($data);

        return response()->json([
            'status'  => 'success',
            'message' => 'Bien actualizado exitosamente.',
            'data'    => $bien,
        ]);
    }

    public function destroy(Bien $bien)
    {
        $bien->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Bien eliminado exitosamente.',
        ]);
    }

    public function qr(Bien $bien)
    {
        $bien->loadMissing('bienes');
        $qrBase64 = QRCodeService::generarQR($bien);

        return response()->json([
            'status' => 'success',
            'data' => [
                'qr_base64' => $qrBase64,
                'codigo_patrimonial' => $bien->codigo_patrimonial,
                'descripcion' => $bien->descripcion,
                'serial_fabrica' => $bien->serial_fabrica,
                'categoria' => $bien->categoria,
                'ubicacion' => $bien->ubicacion,
                'custodio_cedula' => $bien->custodio_cedula,
            ],
        ]);
    }

    public function etiquetaPdf(Bien $bien)
    {
        $pdfBase64 = QRCodeService::generarPDFEtiqueta($bien);

        return response()->json([
            'status' => 'success',
            'data' => [
                'pdf_base64' => $pdfBase64,
                'filename' => "etiqueta-{$bien->codigo_patrimonial}.pdf",
            ],
        ]);
    }
}
