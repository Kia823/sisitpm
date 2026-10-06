<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acta de Entrega y Recepción</title>
    <style>
        @page { margin: 15mm 15mm 15mm 15mm; }
        body { font-family: Helvetica, Arial, sans-serif; font-size: 9px; color: #000; line-height: 1.2; }

        .header-table { width: 100%; border-collapse: collapse; margin-bottom: 8px; }
        .header-table td { text-align: center; vertical-align: middle; }
        .title-main { font-weight: bold; font-size: 11px; text-transform: uppercase; }
        .title-sub { font-weight: bold; font-size: 10px; margin-top: 2px; }

        .box-right { border: 1px solid #000; padding: 4px; text-align: center; font-size: 8px; font-weight: bold; float: right; width: 110px; }

        .legal-text { font-size: 8px; text-align: justify; margin: 8px 0; border: 1px solid #000; padding: 5px; background: #fcfcfc; }

        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 8px; }
        .info-table th, .info-table td { border: 1px solid #000; padding: 4px; font-size: 8px; text-align: left; }
        .info-table th { background-color: #f2f2f2; width: 25%; font-weight: bold; }

        .grid-table { width: 100%; border-collapse: collapse; margin-bottom: 8px; }
        .grid-table th, .grid-table td { border: 1px solid #000; padding: 4px; text-align: center; font-size: 8px; vertical-align: middle; }
        .grid-table th { background-color: #e5e7eb; font-weight: bold; text-transform: uppercase; }

        .photo-img { width: 80px; height: 80px; object-fit: cover; display: block; margin: 0 auto; }

        .signatures-table { width: 100%; border-collapse: collapse; margin-top: 25px; }
        .signatures-table td { width: 50%; border: 1px solid #000; padding: 8px; vertical-align: top; height: 80px; }

        .footer-note { font-size: 7px; margin-top: 10px; text-align: justify; }
    </style>
</head>
<body>

    <div class="box-right">
        FORMULARIO N° 1<br>
        <span style="font-weight: normal; font-size: 7px;">HOJA N° 1 de 1</span>
    </div>

    <table class="header-table">
        <tr>
            <td>
                <div class="title-main">Instituto Tecnológico "Puerto de Mejillones"</div>
                <div style="font-size: 8px;">DIRECCIÓN ADMINISTRATIVA</div>
                <div class="title-sub">ACTA DE ENTREGA Y RECEPCIÓN</div>
                <div style="font-size: 8px; font-weight: bold;">FECHA: {{ date('d \d\e F \d\e Y') }}</div>
            </td>
        </tr>
    </table>

    <div class="legal-text">
        En cumplimiento al D.S. 0181 Normas Básicas del Sistema de Administración de Bienes y Servicios en su Art. 146, 147, 157 (Asignación de Activos Fijos Muebles), la Dirección Administrativa del Instituto Tecnológico "Puerto de Mejillones", procedió a la verificación y asignación de los siguientes activos.
    </div>

    <!-- Tabla del Custodio/Responsable -->
    <table class="info-table">
        <tr>
            <th>NOMBRE DEL CUSTODIO:</th>
            <td>{{ $activos->first()?->custodioActual?->nombre_completo ?? 'N/A' }}</td>
            <th>C.I.:</th>
            <td>{{ $activos->first()?->custodioActual?->ci ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>CARGO:</th>
            <td>{{ $activos->first()?->custodioActual?->cargo ?? 'N/A' }}</td>
            <th>UNIDAD ORGANIZACIONAL:</th>
            <td>{{ $activos->first()?->custodioActual?->unidad_organizacional ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>UBICACIÓN / AMBIENTE:</th>
            <td>{{ $activos->first()?->ambiente?->nombre ?? 'N/A' }}</td>
            <th>CARRERA:</th>
            <td>{{ $activos->first()?->ambiente?->carrera?->nombre ?? 'N/A' }}</td>
        </tr>
    </table>

    <!-- Listado de Activos con Foto -->
    <table class="grid-table">
        <thead>
            <tr>
                <th style="width: 30px;">ITEM</th>
                <th style="width: 85px;">CÓDIGO</th>
                <th style="width: 50px;">FUENTE</th>
                <th style="width: 40px;">EST.</th>
                <th style="width: 35px;">CANT.</th>
                <th>DESCRIPCIÓN Y ESPECIFICACIONES</th>
                <th style="width: 90px;">IMAGEN / FOTO</th>
            </tr>
        </thead>
        <tbody>
            @forelse($activos as $index => $act)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><strong>{{ $act->codigo_activo }}</strong><br><small>{{ $act->numero_serie }}</small></td>
                    <td>{{ $act->fuenteFinanciamiento?->nombre ?? 'GAEDP' }}</td>
                    <td>{{ $act->estado_fisico }}</td>
                    <td>1</td>
                    <td style="text-align: left;">
                        <strong>{{ $act->nombre }}</strong><br>
                        MARCA: {{ $act->marca }} | MODELO: {{ $act->modelo }}<br>
                        <small>{{ $act->descripcion }}</small>
                    </td>
                    <td>
                        @if($act->imagen && file_exists(public_path('storage/' . $act->imagen)))
                            <img class="photo-img" src="{{ public_path('storage/' . $act->imagen) }}" alt="Foto">
                        @else
                            <span style="font-size: 7px; color: #888;">[SIN IMAGEN]</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">No hay activos asignados para este reporte.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Bloque de Observaciones -->
    <table class="info-table">
        <tr>
            <th style="width: 15%;">OBSERVACIONES:</th>
            <td>ASIGNACIÓN PROVISIONAL / DEFINITIVA DE ACTIVOS FIJOS SEGÚN REGISTRO SISTEMA.</td>
        </tr>
    </table>

    <!-- Bloque de Firmas -->
    <table class="signatures-table">
        <tr>
            <td>
                <br><br><br>
                <div style="border-top: 1px solid #000; text-align: center; font-weight: bold; font-size: 8px;">
                    RESPONSABLE DEL BIEN EN USO / CUSTODIO<br>
                    Nombre: {{ $activos->first()?->custodioActual?->nombre_completo ?? '' }}<br>
                    C.I.: {{ $activos->first()?->custodioActual?->ci ?? '' }}
                </div>
            </td>
            <td>
                <br><br><br>
                <div style="border-top: 1px solid #000; text-align: center; font-weight: bold; font-size: 8px;">
                    RESPONSABLE DE INVENTARIACIÓN / SABS<br>
                    DIRECCIÓN ADMINISTRATIVA<br>
                    INSTITUTO TECNOLÓGICO "PUERTO DE MEJILLONES"
                </div>
            </td>
        </tr>
    </table>

    <div class="footer-note">
        <strong>NOTA:</strong> Como responsable del bien de uso me comprometo a dar cumplimiento al D.S.0181 Art. 116 (RESPONSABILIDAD POR EL MANEJO DE BIENES). Todos los servidores públicos son responsables por el debido uso, custodia, preservación y demanda de servicios de mantenimiento de los bienes que les fueran asignados.
    </div>

</body>
</html>
