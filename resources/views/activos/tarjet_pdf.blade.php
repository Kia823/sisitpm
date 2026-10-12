<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Tarjeta de Activo Fijo</title>
    <style>
        @page {
            size: letter portrait;
            margin: 0;
        }
        body {
            font-family: Arial, sans-serif;
            color: #1e293b;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
        }

        /* Contenedor de pantalla completa para centrado absoluto en PDF */
        .page-container {
            width: 100%;
            height: 100vh;
            border-collapse: collapse;
        }
        .page-container td {
            vertical-align: middle;
            text-align: center;
        }

        /* Tarjeta Centrada */
        .card-box {
            width: 360px;
            margin: 0 auto;
            border: 2px solid #cbd5e1;
            border-radius: 12px;
            padding: 20px;
            background-color: #ffffff;
            text-align: left;
        }
        .card-header {
            text-align: center;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 8px;
            margin-bottom: 12px;
        }
        .card-title {
            font-size: 16px;
            font-weight: bold;
            color: #0f172a;
            margin: 0;
            text-transform: uppercase;
        }
        .card-subtitle {
            font-size: 11px;
            color: #2563eb;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .img-container {
            text-align: center;
            margin: 10px 0;
        }
        .img-activo {
            width: 110px;
            height: 110px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #cbd5e1;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }
        .data-table td {
            padding: 4px 0;
            font-size: 11px;
            vertical-align: top;
        }
        .label {
            font-weight: bold;
            color: #475569;
            width: 38%;
        }
        .value {
            color: #0f172a;
        }
        .qr-section {
            text-align: center;
            margin-top: 10px;
            padding-top: 8px;
            border-top: 1px dashed #cbd5e1;
        }
        .qr-img {
            width: 85px;
            height: 85px;
        }
    </style>
</head>
<body>

    <table class="page-container">
        <tr>
            <td>
                <div class="card-box">
                    <div class="card-header">
                        <div class="card-subtitle">CONTROL DE ACTIVO FIJO</div>
                        <h2 class="card-title">{{ $activo->nombre }}</h2>
                    </div>

                    {{-- Imagen del activo --}}
                    <div class="img-container">
                        @if($activo->imagen && file_exists(public_path('storage/' . ltrim($activo->imagen, '/'))))
                            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('storage/' . ltrim($activo->imagen, '/')))) }}" class="img-activo" />
                        @else
                            <div style="font-size: 10px; color: #94a3b8; border: 1px dashed #cbd5e1; padding: 15px; border-radius: 6px;">Sin imagen registrada</div>
                        @endif
                    </div>

                    {{-- Detalles del activo --}}
                    <table class="data-table">
                        <tr>
                            <td class="label">Código:</td>
                            <td class="value"><strong>{{ $activo->codigo_activo }}</strong></td>
                        </tr>
                        <tr>
                            <td class="label">Marca/Modelo:</td>
                            <td class="value">{{ $activo->marca }} {{ $activo->modelo }}</td>
                        </tr>
                        <tr>
                            <td class="label">N° Serie:</td>
                            <td class="value">{{ $activo->numero_serie ?? '—' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Ambiente:</td>
                            <td class="value">{{ $activo->ambiente?->nombre ?? '—' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Custodio:</td>
                            <td class="value">{{ $activo->custodioActual?->nombre_completo ?? 'Sin asignar' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Estado:</td>
                            <td class="value">{{ $activo->estado_registro }}</td>
                        </tr>
                    </table>

                    {{-- Código QR --}}
                    @if($activo->ruta_qr && file_exists(public_path('storage/' . ltrim($activo->ruta_qr, '/'))))
                        <div class="qr-section">
                            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('storage/' . ltrim($activo->ruta_qr, '/')))) }}" class="qr-img" />
                        </div>
                    @endif
                </div>
            </td>
        </tr>
    </table>

</body>
</html>
