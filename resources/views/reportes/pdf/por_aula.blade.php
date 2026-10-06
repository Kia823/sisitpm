<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario por Aula</title>
    @include('reportes.pdf._styles')
    <style>
        .filtros-info {
            font-size: 7px;
            background: #f5f5f5;
            padding: 4px 6px;
            border: 0.5px solid #ccc;
            margin-bottom: 5px;
        }
        .stats {
            width: 100%;
            border-collapse: collapse;
            font-size: 8px;
            margin-bottom: 6px;
        }
        .stats td {
            border: 1px solid #000;
            padding: 3px;
            text-align: center;
            width: 20%;
        }
        .stats .num { font-size: 11px; font-weight: bold; display: block; }
    </style>
</head>
<body>

    {{-- ENCABEZADO --}}
    <div class="header">
        <table style="width:100%;">
            <tr>
                <td style="text-align:left; font-size:9px; font-weight:bold;">FORMULARIO A</td>
                <td style="text-align:center; font-size:9px; font-weight:bold;">
                    INVENTARIO POR AULA
                </td>
                <td style="text-align:right; font-size:9px; font-weight:bold;">GESTIÓN {{ date('Y') }}</td>
            </tr>
        </table>
        <div class="titulo" style="margin-top:3px;">
            {{ $ambiente->nombre }} — {{ $ambiente->carrera->nombre ?? '' }}
        </div>
    </div>

    {{-- DATOS --}}
    <table class="datos">
        <tr>
            <td class="label">AMBIENTE:</td>
            <td>{{ $ambiente->nombre }}</td>
            <td class="label">CÓDIGO:</td>
            <td>{{ $ambiente->codigo }}</td>
        </tr>
        <tr>
            <td class="label">CARRERA:</td>
            <td>{{ $ambiente->carrera->nombre ?? '—' }}</td>
            <td class="label">UBICACIÓN:</td>
            <td>Bloque {{ $ambiente->bloque }} — Piso {{ $ambiente->piso }}</td>
        </tr>
        <tr>
            <td class="label">FECHA REPORTE:</td>
            <td>{{ date('d/m/Y H:i') }}</td>
            <td class="label">RESPONSABLE:</td>
            <td>{{ Auth::user()->nombre_completo ?? '—' }}</td>
        </tr>
    </table>

    {{-- ESTADÍSTICAS --}}
    <table class="stats">
        <tr>
            <td><span class="num">{{ $activos->count() }}</span>TOTAL</td>
            <td><span class="num">{{ $activos->where('estado_fisico','B')->count() }}</span>BUENOS</td>
            <td><span class="num">{{ $activos->where('estado_fisico','R')->count() }}</span>REGULARES</td>
            <td><span class="num">{{ $activos->where('estado_fisico','M')->count() }}</span>MALOS</td>
            <td><span class="num">{{ $activos->where('estado_fisico','FF')->count() }}</span>FUERA SERV.</td>
        </tr>
    </table>

    {{-- TABLA --}}
    <table class="inventario">
        <thead>
            <tr>
                <th class="col-num">N°</th>
                <th class="col-cod">CÓDIGO</th>
                <th class="col-desc">DESCRIPCIÓN</th>
                <th class="col-carac">CARACTERÍSTICAS</th>
                <th class="col-cant">CANT.</th>
                <th class="col-estado">ESTADO</th>
                <th class="col-fuente">FUENTE</th>
                <th class="col-fecha">GESTIÓN</th>
                <th class="col-obs">OBS.</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($agrupados as $i => $g)
                <tr>
                    <td class="col-num">{{ $i + 1 }}</td>
                    <td class="col-cod">{!! nl2br(e($g->codigos)) !!}</td>
                    <td class="col-desc">{{ $g->nombre }}</td>
                    <td class="col-carac">{{ $g->descripcion }}
                        @if($g->marca) <br><strong>Marca:</strong> {{ $g->marca }} @endif
                        @if($g->modelo) <br><strong>Modelo:</strong> {{ $g->modelo }} @endif
                    </td>
                    <td class="col-cant">{{ $g->cantidad }}</td>
                    <td class="col-estado">{{ $g->estado_texto }}</td>
                    <td class="col-fuente">{{ $g->fuente_codigo }}</td>
                    <td class="col-fecha">{{ $g->gestion }}</td>
                    <td class="col-obs">{{ $g->observaciones }}</td>
                </tr>
            @empty
                <tr><td colspan="9" style="text-align:center;">Sin activos en este ambiente</td></tr>
            @endforelse
        </tbody>
    </table>

    {{-- FIRMAS --}}
    <table class="firmas">
        <tr>
            <td><div class="linea">{{ Auth::user()->nombre_completo ?? 'Jefe de Carrera' }}<br>C.I.: {{ Auth::user()->ci ?? '—' }}</div></td>
            <td><div class="linea">Responsable de Inventario<br>C.I.: —</div></td>
            <td><div class="linea">Dirección Administrativa<br>C.I.: —</div></td>
        </tr>
    </table>

</body>
</html>
