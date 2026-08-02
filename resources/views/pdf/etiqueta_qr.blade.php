<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            margin: 0;
            padding: 5mm;
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10px;
        }
        .etiqueta {
            border: 1px solid #333;
            padding: 3mm;
            width: 50mm;
            height: 28mm;
            box-sizing: border-box;
        }
        .header {
            text-align: center;
            font-weight: bold;
            font-size: 8px;
            border-bottom: 1px solid #333;
            padding-bottom: 2mm;
            margin-bottom: 2mm;
        }
        .content {
            display: flex;
            align-items: center;
        }
        .qr-col {
            flex: 0 0 40%;
            text-align: center;
        }
        .info-col {
            flex: 0 0 60%;
            padding-left: 2mm;
        }
        .info-col .label {
            font-weight: bold;
            font-size: 8px;
        }
        .info-col .value {
            font-size: 8px;
            margin-bottom: 0.2mm;
            word-wrap: break-word;
        }
        .qr-img {
            width: 20mm;
            height: 20mm;
        }
    </style>
</head>
<body>
    <div class="etiqueta">
        <div class="header">
            REPÚBLICA BOLIVARIANA DE VENEZUELA<br>
            SISTEMA DE CONTROL PATRIMONIAL
        </div>
        <div class="content">
            <div class="qr-col">
                <img src="data:image/png;base64,{{ $qrBase64 }}" class="qr-img" alt="QR">
            </div>
            <div class="info-col">
                <div>
                    <span class="label">CÓDIGO:</span>
                    <span class="value">{{ $bien->codigo_patrimonial }}</span>
                </div>
                <div>
                    <span class="label">NOMBRE:</span>
                    <span class="value">{{ \Illuminate\Support\Str::limit($bien->descripcion, 25) }}</span>
                </div>
                <div>
                    <span class="label">CATEGORÍA:</span>
                    <span class="value">{{ $bien->categoria ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="label">UBICACIÓN:</span>
                    <span class="value">{{ $bien->ubicacion ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="label">RESPONSABLE:</span>
                    <span class="value">{{ $bien->custodio_cedula }}</span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
