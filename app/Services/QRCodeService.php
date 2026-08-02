<?php

namespace App\Services;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Bien;

class QRCodeService
{
    public static function generarQR(Bien $bien): string
    {
        $datos = [
            'inst' => 'GOB-EDO-TACHIRA',
            'codigo'    => $bien->codigo_patrimonial,
            'nombre'    => $bien->descripcion,
            'categoria' => $bien->categoria ?? 'N/A',
            'ubicacion' => $bien->ubicacion ?? 'N/A',
            'responsable' => $bien->custodio_cedula,
            'ver'  => url('/actas/verificar/' . $bien->hash_unico ?? ''),
        ];

        if (empty($bien->hash_unico)) {
            $hash = hash('sha256', $bien->codigo_patrimonial . $bien->id . now());
            $bien->update(['hash_unico' => $hash]);
            $datos['ver'] = url('/actas/verificar/' . $hash);
        }

        return base64_encode(
            QrCode::format('png')
                ->size(300)
                ->errorCorrection('Q')
                ->generate(json_encode($datos, JSON_UNESCAPED_UNICODE))
        );
    }

    public static function generarPDFEtiqueta(Bien $bien): string
    {
        $qrBase64 = self::generarQR($bien);

        $html = view('pdf.etiqueta_qr', [
            'bien' => $bien,
            'qrBase64' => $qrBase64,
        ])->render();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html);
        $pdf->setPaper([0, 0, 144, 252], 'portrait');

        return base64_encode($pdf->output());
    }
}
