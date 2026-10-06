<table border="1" style="font-family:Arial; font-size:10px; width:100%;">
    <thead>
        <tr style="background:#e5e5e5;">
            <th>N°</th>
            <th>CÓDIGO</th>
            <th>TIPO</th>
            <th>DESCRIPCIÓN</th>
            <th>CARACTERÍSTICAS</th>
            <th>CANT.</th>
            <th>ESTADO</th>
            <th>FUENTE</th>
            <th>GESTIÓN</th>
            <th>USO</th>
            <th>OBS.</th>
        </tr>
        <tr>
            <td colspan="11" style="background:#f8fafc;font-weight:bold;">
                @if(($tipoBien ?? 'TODOS') === 'NO_ACTIVO')
                    INVENTARIO DE BIENES NO ACTIVOS (MATERIAL DE CONSUMO)
                @elseif(($tipoBien ?? 'TODOS') === 'ACTIVO_FIJO')
                    INVENTARIO DE MAQUINARIA, HERRAMIENTAS Y EQUIPOS DE LABORATORIO
                @else
                    INVENTARIO GENERAL DE BIENES
                @endif
            </td>
        </tr>
    </thead>
    <tbody>
        @php $i = 1; @endphp
        @forelse($activos as $g)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $g->codigo_activo }}</td>
                <td align="center">{{ $g->tipo_bien_texto }}</td>
                <td>{{ $g->nombre }}</td>
                <td>
                    {{ $g->descripcion }}
                    @if($g->marca) <br>Marca: {{ $g->marca }} @endif
                    @if($g->modelo) <br>Modelo: {{ $g->modelo }} @endif
                    @if($g->numero_serie) <br>N° serie: {{ $g->numero_serie }} @endif
                </td>
                <td align="center">1</td>
                <td align="center">{{ $g->estado_registro_texto }}</td>
                <td align="center">{{ $g->fuente?->codigo ?? '—' }}</td>
                <td align="center">{{ $g->gestion }}</td>
                <td>{{ $g->ambiente?->nombre ?? '—' }}</td>
                <td>{{ $g->observaciones }}</td>
            </tr>
        @empty
            <tr><td colspan="11" align="center">Sin bienes</td></tr>
        @endforelse
    </tbody>
</table>