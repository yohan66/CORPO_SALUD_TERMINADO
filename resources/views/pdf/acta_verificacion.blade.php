<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acta de Constatación Física - {{ $acta->numero }}</title>
    <style>
        @page {
            size: legal;
            margin: 2.5cm 2cm 2.5cm 2cm;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #1a1a1a;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .logo {
            width: 90px;
            height: auto;
        }
        .title-header {
            text-align: center;
            font-weight: bold;
            font-size: 12px;
            text-transform: uppercase;
        }
        .acta-meta {
            text-align: right;
            font-size: 10px;
        }
        .acta-numero {
            font-weight: bold;
            color: #c00000;
            font-size: 12px;
        }
        .seccion-titulo {
            font-weight: bold;
            background-color: #f2f2f2;
            padding: 5px;
            margin-top: 15px;
            margin-bottom: 8px;
            border-left: 4px solid #003366;
            text-transform: uppercase;
            font-size: 10px;
        }
        .datos-tabla {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .datos-tabla td {
            padding: 4px;
            vertical-align: top;
        }
        .inventario-tabla {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .inventario-tabla th {
            background-color: #003366;
            color: #ffffff;
            font-weight: bold;
            padding: 6px;
            font-size: 10px;
            text-align: left;
            border: 1px solid #002244;
        }
        .inventario-tabla td {
            padding: 6px;
            border: 1px solid #dddddd;
            font-size: 10px;
        }
        .inventario-tabla tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .resumen-box {
            width: 40%;
            margin-top: 15px;
            border: 1px solid #cccccc;
            padding: 8px;
            background-color: #fafafa;
            float: right;
        }
        .resumen-row {
            clear: both;
            overflow: hidden;
            padding: 2px 0;
        }
        .footer-signatures {
            width: 100%;
            margin-top: 60px;
            border-collapse: collapse;
            page-break-inside: avoid;
        }
        .firma-linea {
            width: 45%;
            text-align: center;
            vertical-align: bottom;
        }
        .linea {
            border-top: 1px solid #000000;
            width: 80%;
            margin: 0 auto 5px auto;
        }
        .qr-container {
            width: 10%;
            text-align: center;
            vertical-align: middle;
        }
        .text-justify {
            text-align: justify;
        }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td style="width: 20%;">
                <!-- Reemplazar con el logo institucional -->
                &nbsp;
            </td>
            <td class="title-header" style="width: 60%;">
                República Bolivariana de Venezuela<br>
                {{ $acta->institucion_nombre }}<br>
                <span style="font-size: 10px; font-weight: normal;">Dirección de Administración y Finanzas - Unidad de Bienes Públicos</span>
            </td>
            <td class="acta-meta" style="width: 20%;">
                Acta Nro:<br>
                <span class="acta-numero">{{ $acta->numero }}</span><br>
                Fecha: {{ $acta->fecha_emision }}<br>
                Hora: {{ $acta->hora_emision }}
            </td>
        </tr>
    </table>

    <p class="text-justify">
        Quienes suscriben, en fiel cumplimiento con el Decreto con Rango, Valor y Fuerza de <strong>Ley Orgánica de Bienes Públicos</strong> de la República Bolivariana de Venezuela y las providencias normativas dictadas por la <strong>SUDEBIP</strong>, hacen constar de manera formal que en la fecha indicada se procedió a efectuar la auditoría, constatación física y verificación del estado de conservación de los bienes nacionales adscritos e inventariados en la dependencia especificada a continuación.
    </p>

    <div class="seccion-titulo">1. Datos de Identificación y Ubicación</div>
    <table class="datos-tabla">
        <tr>
            <td style="width: 20%;"><strong>Sede / Dirección:</strong></td>
            <td style="width: 30%;">{{ $acta->sede_nombre }}</td>
            <td style="width: 20%;"><strong>Código de Oficina:</strong></td>
            <td style="width: 30%;">{{ $acta->sede_codigo }}</td>
        </tr>
        <tr>
            <td><strong>Auditor Actuante:</strong></td>
            <td>{{ $acta->auditor_nombre }} (C.I. {{ $acta->auditor_cedula }})</td>
            <td><strong>Responsable de Sede:</strong></td>
            <td>{{ $acta->custodio_nombre }} (C.I. {{ $acta->custodio_cedula }})</td>
        </tr>
    </table>

    <div class="seccion-titulo">2. Detalle de Bienes Verificados en Campo</div>
    <table class="inventario-tabla">
        <thead>
            <tr>
                <th style="width: 15%;">Código Patrimonial</th>
                <th style="width: 35%;">Descripción del Activo</th>
                <th style="width: 15%;">Serial de Fábrica</th>
                <th style="width: 12%;">Estado Físico</th>
                <th style="width: 23%;">Observación / Novedad</th>
            </tr>
        </thead>
        <tbody>
            @foreach($acta->bienes as $bien)
            <tr>
                <td><strong>{{ $bien->codigo_patrimonial }}</strong></td>
                <td>{{ $bien->descripcion }}</td>
                <td>{{ $bien->serial_fabrica ?? 'N/A' }}</td>
                <td>{{ $bien->pivot->estado_conservacion ?? $bien->estado_conservacion }}</td>
                <td>{{ $bien->pivot->observacion_auditoria ?? 'Sin novedades' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="resumen-box">
        <div class="resumen-row">
            <span style="float: left;"><strong>Bienes Asignados en Sistema:</strong></span>
            <span style="float: right;">{{ $acta->total_asignados }}</span>
        </div>
        <div class="resumen-row">
            <span style="float: left;"><strong>Bienes Constatados:</strong></span>
            <span style="float: right;">{{ $acta->total_verificados }}</span>
        </div>
        <div class="resumen-row" style="color: #c00000;">
            <span style="float: left;"><strong>Discrepancias / Faltantes:</strong></span>
            <span style="float: right;">{{ $acta->total_faltantes }}</span>
        </div>
    </div>

    <div style="clear: both;"></div>

    <table class="footer-signatures">
        <tr>
            <td class="qr-container">
                <img src="data:image/png;base64,{{ $qrBase64 }}" alt="QR Validación" style="width: 75px; height: 75px;">
                <div style="font-size: 7px; margin-top: 3px;">Código de Verificación</div>
            </td>
            <td class="firma-linea">
                <div class="linea"></div>
                <strong>Por la Unidad de Bienes Públicos</strong><br>
                Auditor: {{ $acta->auditor_nombre }}<br>
                C.I. V-{{ $acta->auditor_cedula }}
            </td>
            <td style="width: 10%;"></td>
            <td class="firma-linea">
                <div class="linea"></div>
                <strong>Por la Dependencia Auditada</strong><br>
                Responsable: {{ $acta->custodio_nombre }}<br>
                C.I. V-{{ $acta->custodio_cedula }}
            </td>
        </tr>
    </table>

</body>
</html>
