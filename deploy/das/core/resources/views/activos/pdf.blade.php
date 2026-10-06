<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Inventario de activos</title>
    <style>
        body { font-family: Arial, sans-serif; color: #111; margin: 10px; }
        @page { size: landscape; margin: 10mm; }
        h1 { margin-bottom: 2px; font-size: 20px; }
        p { color: #555; font-size: 11px; margin-top: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #aaa; padding: 6px 8px; text-align: left; font-size: 11px; vertical-align: middle; }
        th { background: #e5e7eb; font-weight: bold; }
        .img-activo { width: 50px; height: 50px; object-fit: cover; border-radius: 4px; display: block; margin: 0 auto; }
    </style>
</head>
<body>

    <h1>Inventario de activos fijos</h1>
    <p>Generado el {{ date('d/m/Y H:i') }} · SISActivos</p>

    <table>
        <thead>
            <tr>
                <th style="width: 60px; text-align: center;">Imagen</th>
                <th>Código</th>
                <th>Activo</th>
                <th>Serie</th>
                <th>Categoría</th>
                <th>Ambiente</th>
                <th>Custodio</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse($activos as $activo)
                @php
                    $imagenPath = $activo->imagen ? public_path('storage/' . ltrim($activo->imagen, '/')) : null;
                    $hasImagen = $imagenPath && file_exists($imagenPath);
                @endphp
                <tr>
                    <td style="text-align: center;">
                        @if($hasImagen)
                            @php
                                try {
                                    $base64 = base64_encode(file_get_contents($imagenPath));
                                } catch (\Exception $e) {
                                    $base64 = null;
                                }
                            @endphp

                            @if($base64)
                                <img src="data:image/png;base64,{{ $base64 }}" class="img-activo" />
                            @else
                                <span style="color: #94a3b8; font-size: 10px;">Error img</span>
                            @endif
                        @else
                            <span style="color: #94a3b8; font-size: 10px;">Sin foto</span>
                        @endif
                    </td>
                    <td><strong>{{ $activo->codigo_activo }}</strong></td>
                    <td>
                        {{ $activo->nombre }}<br>
                        <small style="color:#64748b;">{{ $activo->marca }} {{ $activo->modelo }}</small>
                    </td>
                    <td>{{ $activo->numero_serie ?? '—' }}</td>
                    <td>{{ $activo->categoria?->nombre ?? '—' }}</td>
                    <td>{{ $activo->ambiente?->nombre ?? '—' }}</td>
                    <td>{{ $activo->custodioActual?->nombre_completo ?? 'Sin asignar' }}</td>
                    <td>{{ $activo->estado_registro }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; color: #64748b; padding: 20px;">No hay activos registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
