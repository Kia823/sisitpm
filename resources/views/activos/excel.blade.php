<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        table { border-collapse: collapse; width: 100%; }
        th { background-color: #e5e7eb; border: 1px solid #000000; font-weight: bold; text-align: center; }
        td { border: 1px solid #000000; text-align: left; vertical-align: middle; padding: 4px; }
    </style>
</head>
<body>
    <h2>Inventario de Activos Fijos - SISActivos</h2>
    <p>Generado el {{ date('d/m/Y H:i') }}</p>

    <table>
        <thead>
            <tr style="height: 25px;">
                <th style="width: 50px; text-align: center;">Imagen</th>
                <th>Código</th>
                <th>Activo</th>
                <th>Marca / Modelo</th>
                <th>Serie</th>
                <th>Categoría</th>
                <th>Ambiente</th>
                <th>Custodio</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($activos as $a)
                {{-- Se define una altura fija a la fila de la tabla en Excel --}}
                <tr style="height: 45px;">
                    <td style="text-align: center; vertical-align: middle; width: 45px; height: 45px;">
                        @if($a->imagen && file_exists(public_path('storage/' . ltrim($a->imagen, '/'))))
                            {{-- Dimensiones ajustadas a 35px para caber exactamente en el texto --}}
                            <img src="{{ asset('storage/' . $a->imagen) }}" width="35" height="35" style="display: block; margin: auto;" />
                        @else
                            <span style="color: #94a3b8; font-size: 10px;">Sin foto</span>
                        @endif
                    </td>
                    <td><b>{{ $a->codigo_activo }}</b></td>
                    <td>{{ $a->nombre }}</td>
                    <td>{{ $a->marca }} {{ $a->modelo }}</td>
                    <td>{{ $a->numero_serie ?? '—' }}</td>
                    <td>{{ $a->categoria?->nombre }}</td>
                    <td>{{ $a->ambiente?->nombre }}</td>
                    <td>{{ $a->custodioActual?->nombre_completo ?? 'Sin asignar' }}</td>
                    <td>{{ $a->estado_registro }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
