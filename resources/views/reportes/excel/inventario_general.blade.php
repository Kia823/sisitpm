<table border="1" style="font-family:Arial; font-size:10px; width:100%;">
    <thead>
        <tr style="background:#e5e5e5;">
<<<<<<< HEAD
            <th>Nº</th>
            <th>CÓDIGO</th>
            <th>DESCRIPCIÓN DEL EQUIPO</th>
            <th>CARACTERÍSTICAS</th>
            <th>CANTIDAD</th>
            <th>COSTO (Bs.)</th>
            <th>ESTADO</th>
            <th>FUENTE</th>
            <th>FECHA ENTREGA</th>
            <th>DÍA</th>
            <th>MES</th>
            <th>AÑO</th>
            <th>USO EN ÁREA (CARRERA)</th>
            <th>OBSERVACIONES</th>
            <th>IMAGEN</th>
        </tr>
        <tr>
            <td colspan="15" style="background:#f8fafc;font-weight:bold;">
=======
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
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
                @if(($tipoBien ?? 'TODOS') === 'NO_ACTIVO')
                    INVENTARIO DE BIENES NO ACTIVOS (MATERIAL DE CONSUMO)
                @elseif(($tipoBien ?? 'TODOS') === 'ACTIVO_FIJO')
                    INVENTARIO DE MAQUINARIA, HERRAMIENTAS Y EQUIPOS DE LABORATORIO
                @else
<<<<<<< HEAD
                    INVENTARIO GENERAL DE BIENES (AGRUPADOS)
=======
                    INVENTARIO GENERAL DE BIENES
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
                @endif
            </td>
        </tr>
    </thead>
    <tbody>
<<<<<<< HEAD
        @forelse($reportes as $r)
            <tr>
                <td>{{ $r->nro }}</td>
                <td>{{ $r->codigos }}</td>
                <td>{{ $r->descripcion }}</td>
                <td>{{ $r->caracteristicas }}</td>
                <td align="center">{{ $r->cantidad }}</td>
                <td align="right">{{ number_format($r->costo_total, 2) }}</td>
                <td align="center">{{ $r->estado_fisico_texto }}</td>
                <td align="center">{{ $r->fuente ?? '—' }}</td>
                <td align="center">{{ $r->fecha_entrega ? $r->fecha_entrega->format('d/m/Y') : '—' }}</td>
                <td align="center">{{ $r->dia }}</td>
                <td align="center">{{ $r->mes }}</td>
                <td align="center">{{ $r->anio }}</td>
                <td>{{ $r->carrera }}</td>
                <td>{{ $r->observaciones ?? '—' }}</td>
                <td align="center">
                    @if($r->imagen)
                        [IMG]
                    @else
                        —
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="15" align="center">Sin bienes</td></tr>
        @endforelse
        <tr style="font-weight:bold; background:#f8fafc;">
            <td colspan="4" style="text-align:right;">TOTALES:</td>
            <td align="center">{{ $reportes->sum('cantidad') }}</td>
            <td align="right">{{ number_format($reportes->sum('costo_total'), 2) }}</td>
            <td colspan="9"></td>
        </tr>
=======
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
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
    </tbody>
</table>