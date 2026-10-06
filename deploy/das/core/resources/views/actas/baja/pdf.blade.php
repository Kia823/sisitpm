<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
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
</body>
</html>
