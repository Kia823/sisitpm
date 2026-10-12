<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
<<<<<<< HEAD
    <title>Acta de Baja - {{ $acta->numero_acta }}</title>
    <style>
        @page {
            size: letter landscape;
            margin: 1cm;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #000;
            line-height: 1.3;
        }
        .header-title {
            font-size: 16px;
            font-weight: bold;
            color: #0f172a;
            margin-bottom: 4px;
        }
        .info-table, .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .items-table th, .items-table td {
            border: 1px solid #cbd5e1;
            padding: 8px;
            text-align: left;
            font-size: 11px;
        }
        .items-table th {
            background: #f1f5f9;
            font-weight: bold;
            color: #334155;
            text-transform: uppercase;
        }
    </style>
</head>
<body>

    <div class="header-title">ACTA DE BAJA DE ACTIVO FIJO</div>
    <div style="font-size: 13px; font-weight: bold; margin-bottom: 15px;">Número: {{ $acta->numero_acta }}</div>

    <div style="display: flex; justify-content: space-between; margin-bottom: 15px; font-size: 12px;">
        <div>
            <strong>Fecha:</strong> {{ \Carbon\Carbon::parse($acta->fecha_baja ?? $acta->created_at)->format('d/m/Y') }}<br>
            <strong>Motivo:</strong> {{ $acta->motivo ?? '—' }}<br>
            <strong>Observaciones:</strong> {{ $acta->observaciones ?? '—' }}
        </div>
        <div>
            <strong>Solicitante:</strong> {{ $acta->usuario->nombre_completo ?? '—' }}
        </div>
    </div>

    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 130px;">CÓDIGO</th>
                <th style="width: 180px;">NOMBRE</th>
                <th>CATEGORÍA</th>
                <th>UBICACIÓN</th>
                <th style="width: 100px; text-align: right;">VALOR</th>
            </tr>
        </thead>
        <tbody>
            @if($acta->activo)
            <tr>
                <td><strong>{{ $acta->activo->codigo_activo }}</strong></td>
                <td>{{ $acta->activo->nombre }}</td>
                <td>{{ $acta->activo->categoria->nombre ?? '—' }}</td>
                <td>{{ $acta->activo->ambiente->nombre ?? '—' }}</td>
                <td style="text-align: right;">${{ number_format($acta->activo->valor_adquisicion ?? 0, 2) }}</td>
            </tr>
            @endif
        </tbody>
    </table>

    <div style="margin-top: 25px; font-size: 10px; color: #64748b; border-top: 1px solid #cbd5e1; padding-top: 8px;">
        Este documento se genera desde SISActivos. Los activos incluidos pasan a estado de registro BAJA.
    </div>

=======
    <title>Acta de Baja {{ $acta->numero_acta ?? '' }}</title>
    <style>
        body { font-family: "Helvetica Neue", Arial, sans-serif; color:#1e293b; margin:30px; }
        h1 { font-size:20px; margin:0 0 4px; }
        h2 { font-size:14px; margin:0 0 12px; color:#64748b; }
        table { width:100%; border-collapse:collapse; margin-top:14px; }
        th, td { border:1px solid #cbd5e1; padding:8px; font-size:12px; }
        th { background:#f1f5f9; font-weight:800; text-transform:uppercase; font-size:10px; }
        .meta { font-size:12px; color:#475569; margin:2px 0; }
        .muted { color:#94a3b8; }
    </style>
</head>
<body>
    @php
        // Obtener la lista de activos sin importar cómo esté definida la relación en el modelo
        $listaActivos = $acta->activos ?? ($acta->activo ? collect([$acta->activo]) : collect());
        if ($listaActivos instanceof \Illuminate\Database\Eloquent\Model) {
            $listaActivos = collect([$listaActivos]);
        }
    @endphp

    <div style="display:flex;justify-content:space-between;">
        <div>
            <h1>ACTA DE BAJA DE ACTIVO FIJO</h1>
            <h2>Número: {{ $acta->numero_acta ?? '—' }}</h2>
        </div>
        <div style="text-align:right;">
            <div class="meta"><strong>Fecha:</strong> {{ optional($acta->fecha_baja ?? $acta->fecha_acta ?? $acta->created_at)->format('d/m/Y') ?? '—' }}</div>
            <div class="meta"><strong>Solicitante:</strong> {{ optional($acta->solicitante ?? $acta->usuario)->nombre_completo ?? 'Administrador' }}</div>
            <div class="meta muted">{{ optional($acta->solicitante ?? $acta->usuario)->rol ?? 'ADMINISTRADOR' }}</div>
        </div>
    </div>

    <div class="meta"><strong>Ambiente:</strong> {{ optional($acta->ambiente)->nombre ?? optional(optional($listaActivos->first())->ambiente)->nombre ?? '—' }}</div>
    <div class="meta"><strong>Estado:</strong> {{ $acta->estado ?? 'FINALIZADO' }}</div>
    <div class="meta"><strong>Motivo:</strong> {{ $acta->motivo_baja ?? $acta->motivo ?? '—' }}</div>
    <div class="meta"><strong>Observaciones:</strong> {{ $acta->observaciones ?? '—' }}</div>

    <table>
        <thead>
            <tr>
                <th>Código</th><th>Nombre</th><th>Categoría</th><th>Ubicación</th><th>Valor</th>
            </tr>
        </thead>
        <tbody>
            @forelse($listaActivos as $a)
                <tr>
                    <td>{{ $a->codigo_activo ?? '—' }}</td>
                    <td>{{ $a->nombre ?? '—' }}</td>
                    <td>{{ optional($a->categoria)->nombre ?? '—' }}</td>
                    <td>{{ optional(optional($a->ambiente)->carrera)->nombre ?? '' }} {{ optional($a->ambiente)->nombre ?? '—' }}</td>
                    <td>${{ number_format((float)($a->valor_adquisicion ?? 0), 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: #94a3b8;">Sin activos asociados</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <p class="muted" style="margin-top:20px;font-size:11px;">
        Este documento se genera desde SISActivos. Los activos incluidos pasan a estado de registro BAJA.
    </p>
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
</body>
</html>
