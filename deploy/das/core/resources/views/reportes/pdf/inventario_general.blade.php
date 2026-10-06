<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario General</title>
    @include('reportes.pdf._styles')
</head>
<body>

    <div class="header">
        <table style="width:100%;">
            <tr>
                <td style="text-align:left; font-size:9px; font-weight:bold;">FORMULARIO A</td>
                <td style="text-align:center; font-size:9px; font-weight:bold;">
                    EQUIPOS OTORGADOS EL MINISTERIO DE EDUCACIÓN
                </td>
                <td style="text-align:right; font-size:9px; font-weight:bold;">GESTIÓN {{ date('Y') }}</td>
            </tr>
        </table>
        <div class="titulo" style="margin-top:3px;">
            @if(($tipoBien ?? 'TODOS') === 'NO_ACTIVO')
                INVENTARIO DE BIENES NO ACTIVOS (MATERIAL DE CONSUMO)
            @elseif(($tipoBien ?? 'TODOS') === 'ACTIVO_FIJO')
                INVENTARIO DE MAQUINARIA, HERRAMIENTAS Y EQUIPOS DE LABORATORIO
            @else
                INVENTARIO GENERAL DE BIENES
            @endif
        </div>
    </div>

    <table class="datos">
        <tr>
            <td class="label">INSTITUTO:</td>
            <td colspan="3">TECNOLÓGICO "PUERTO DE MEJILLONES"</td>
            <td class="label">DEPARTAMENTO:</td>
            <td>LA PAZ</td>
        </tr>
        <tr>
            <td class="label">DIRECTOR/RECTOR:</td>
            <td colspan="3">LIC. JIMMY OVIDIO SIRPA CHOQUE</td>
            <td class="label">PROVINCIA:</td>
            <td>MURILLO</td>
        </tr>
        <tr>
            <td class="label">DIR. ADMINISTRATIVA:</td>
            <td colspan="3">LIC. ANA LÍA ZAPANA CORTEZ</td>
            <td class="label">MUNICIPIO:</td>
            <td>LA PAZ</td>
        </tr>
        <tr>
            <td class="label">UBICACIÓN:</td>
            <td colspan="3">LABORATORIO 3 — INFORMÁTICA</td>
            <td class="label">CIUDAD:</td>
            <td>EL ALTO</td>
        </tr>
    </table>

    <table class="inventario">
        <thead>
            <tr>
                <th class="col-num">N°</th>
                <th class="col-cod">CÓDIGO</th>
                <th class="col-desc">DESCRIPCIÓN DEL EQUIPO</th>
                <th class="col-estado" style="width:60px;">TIPO</th>
                <th class="col-carac">CARACTERÍSTICAS</th>
                <th class="col-cant">CANT.</th>
                <th class="col-estado">ESTADO</th>
                <th class="col-fuente">FUENTE</th>
                <th class="col-fecha">FECHA</th>
                <th class="col-uso">USO / ÁREA</th>
                <th class="col-obs">OBS.</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($agrupados as $i => $g)
                <tr>
                    <td class="col-num">{{ $i + 1 }}</td>
                    <td class="col-cod">{!! nl2br(e($g->codigos)) !!}</td>
                    <td class="col-desc">{{ $g->nombre }}</td>
                    <td class="col-estado">{{ $g->tipo_bien_texto ?? '—' }}</td>
                    <td class="col-carac">
                        {{ $g->descripcion }}
                        @if($g->marca) <br><strong>Marca:</strong> {{ $g->marca }} @endif
                        @if($g->modelo) <br><strong>Modelo:</strong> {{ $g->modelo }} @endif
                    </td>
                    <td class="col-cant">{{ $g->cantidad }}</td>
                    <td class="col-estado">{{ $g->estado_texto }}</td>
                    <td class="col-fuente">{{ $g->fuente_codigo }}</td>
                    <td class="col-fecha">{{ $g->gestion }}</td>
                    <td class="col-uso">LABORATORIO 3 INFORMÁTICA</td>
                    <td class="col-obs">{{ $g->observaciones }}</td>
                </tr>
            @empty
                <tr><td colspan="11" style="text-align:center;">Sin bienes</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="leyenda">
        <table>
            <tr>
                <td><strong>B</strong> = BUENO</td>
                <td><strong>R</strong> = REGULAR</td>
                <td><strong>M</strong> = MALO</td>
                <td><strong>FF</strong> = FUERA DE FUNCIONAMIENTO</td>
            </tr>
        </table>
    </div>

    <table class="firmas">
        <tr>
            <td><div class="linea">Lic. Patricia Regina Flores Chuquimia<br>C.I.: 3451328</div></td>
            <td><div class="linea">Lic. Johnny Chavez Quispe<br>C.I.: 6032467</div></td>
            <td><div class="linea">Lic. Eliza Nina Coronel<br>C.I.: 4286280</div></td>
        </tr>
        <tr>
            <td><div class="linea" style="margin-top:25px;">Lic. Ana Lía Zapana Cortez<br>C.I.: 4756925</div></td>
            <td><div class="linea" style="margin-top:25px;">Lic. Juan Carlos Osco<br>C.I.: 4243543</div></td>
            <td><div class="linea" style="margin-top:25px;">Lic. Jhimmy Ovidio Sirpa<br>C.I.: 4960313</div></td>
        </tr>
    </table>

</body>
</html>
