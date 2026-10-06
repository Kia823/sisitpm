<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        body { font-family: Arial, sans-serif; font-size: 9pt; }
        table { border-collapse: collapse; width: 100%; }
        .text-center { text-align: center; }
        .text-left { text-align: left; }
        .text-right { text-align: right; }
        .bold { font-weight: bold; }
        .border-all { border: 1px solid #000000; }
        .bg-gray { background-color: #f2f2f2; }
        .bg-blue { background-color: #1e3a8a; color: #ffffff; }
        .valign-middle { vertical-align: middle; }
        .valign-top { vertical-align: top; }
        .text-format { mso-number-format: "\@"; }
    </style>
</head>
<body>

<table border="0" cellpadding="3" cellspacing="0">
    <!-- Encabezado Institucional y Formulario N° 1 -->
    <tr>
        <td colspan="5" class="bold text-center valign-middle" style="font-size: 11pt; height: 30px;">
            INSTITUTO TECNOLÓGICO "PUERTO DE MEJILLONES"
        </td>
        <td colspan="2" class="bold text-center border-all bg-gray valign-middle" style="font-size: 9pt;">
            FORMULARIO N° 1
        </td>
    </tr>

    <!-- Subtítulo y Fecha -->
    <tr>
        <td colspan="5" class="bold text-center valign-middle" style="font-size: 9pt; height: 20px;">
            DIRECCIÓN ADMINISTRATIVA - ACTA DE ENTREGA Y RECEPCIÓN
        </td>
        <td colspan="2" class="text-center border-all valign-middle" style="font-size: 8pt;">
            FECHA: {{ date('d/m/Y') }}
        </td>
    </tr>

    <!-- Espaciador -->
    <tr><td colspan="7" style="height: 10px;"></td></tr>

    <!-- Texto de Respaldo Legal -->
    <tr>
        <td colspan="7" class="border-all text-left valign-middle" style="font-size: 8pt; padding: 6px; text-align: justify;">
            En cumplimiento al D.S. 0181 Normas Básicas del Sistema de Administración de Bienes y Servicios en su Art. 146, 147, 157 (Asignación de Activos Fijos Muebles), la Dirección Administrativa del Instituto Tecnológico "Puerto de Mejillones", procedió a la verificación y asignación de los siguientes activos.
        </td>
    </tr>

    <!-- Espaciador -->
    <tr><td colspan="7" style="height: 10px;"></td></tr>

    <!-- Datos del Responsable / Custodio -->
    @php $first = $activos->first(); @endphp
    <tr>
        <td class="bold bg-gray border-all valign-middle text-left" style="width: 80px; height: 22px;">CUSTODIO:</td>
        <td colspan="2" class="border-all valign-middle text-left text-format" style="width: 200px;">{{ $first?->custodioActual?->nombre_completo ?? 'N/A' }}</td>
        <td class="bold bg-gray border-all valign-middle text-center" style="width: 60px;">C.I.:</td>
        <td colspan="3" class="border-all valign-middle text-left text-format" style="width: 250px;">{{ $first?->custodioActual?->ci ?? 'N/A' }}</td>
    </tr>
    <tr>
        <td class="bold bg-gray border-all valign-middle text-left" style="height: 22px;">CARGO:</td>
        <td colspan="2" class="border-all valign-middle text-left text-format">{{ $first?->custodioActual?->cargo ?? 'N/A' }}</td>
        <td class="bold bg-gray border-all valign-middle text-center">UNIDAD:</td>
        <td colspan="3" class="border-all valign-middle text-left text-format">{{ $first?->custodioActual?->unidad_organizacional ?? 'N/A' }}</td>
    </tr>
    <tr>
        <td class="bold bg-gray border-all valign-middle text-left" style="height: 22px;">AMBIENTE:</td>
        <td colspan="2" class="border-all valign-middle text-left text-format">{{ $first?->ambiente?->nombre ?? 'N/A' }}</td>
        <td class="bold bg-gray border-all valign-middle text-center">CARRERA:</td>
        <td colspan="3" class="border-all valign-middle text-left text-format">{{ $first?->ambiente?->carrera?->nombre ?? 'N/A' }}</td>
    </tr>

    <!-- Espaciador -->
    <tr><td colspan="7" style="height: 10px;"></td></tr>

    <!-- Encabezados de la Tabla de Ítems -->
    <thead>
        <tr class="bg-blue bold text-center valign-middle" style="height: 25px;">
            <th class="border-all text-center" style="width: 45px;">ITEM</th>
            <th class="border-all text-center" style="width: 110px;">CÓDIGO</th>
            <th class="border-all text-center" style="width: 90px;">FUENTE</th>
            <th class="border-all text-center" style="width: 60px;">EST.</th>
            <th class="border-all text-center" style="width: 50px;">CANT.</th>
            <th class="border-all text-center" style="width: 320px;">DESCRIPCIÓN Y ESPECIFICACIONES</th>
            <th class="border-all text-center" style="width: 110px;">N° SERIE</th>
        </tr>
    </thead>
    <tbody>
        @foreach($activos as $index => $act)
            <tr>
                <td class="border-all text-center valign-middle" style="height: 45px;">{{ $index + 1 }}</td>
                <td class="border-all bold text-center valign-middle text-format">{{ $act->codigo_activo }}</td>
                <td class="border-all text-center valign-middle">{{ $act->fuenteFinanciamiento?->nombre ?? 'GAEDP' }}</td>
                <td class="border-all text-center valign-middle">{{ $act->estado_fisico }}</td>
                <td class="border-all text-center valign-middle">1</td>
                <td class="border-all text-left valign-middle text-format" style="padding: 5px;">
                    <strong>{{ $act->nombre }}</strong> - MARCA: {{ $act->marca }} | MODELO: {{ $act->modelo }}<br/>
                    {{ $act->descripcion }}
                </td>
                <td class="border-all text-center valign-middle text-format">{{ $act->numero_serie ?? '—' }}</td>
            </tr>
        @endforeach
    </tbody>

    <!-- Espaciador -->
    <tr><td colspan="7" style="height: 10px;"></td></tr>

    <!-- Observaciones -->
    <tr>
        <td class="bold bg-gray border-all valign-middle text-left" style="height: 22px;">OBSERVACIONES:</td>
        <td colspan="6" class="border-all valign-middle text-left" style="padding-left: 5px;">
            ASIGNACIÓN DE ACTIVO FIJO SEGÚN REGISTRO SISTEMA DE INVENTARIOS.
        </td>
    </tr>

    <!-- Espaciador para firmas -->
    <tr><td colspan="7" style="height: 45px;"></td></tr>

    <!-- Bloque de Firmas -->
    <tr>
        <td colspan="3" class="bold text-center valign-top" style="border-top: 1px solid #000000; font-size: 8pt; height: 50px;">
            RESPONSABLE DEL BIEN EN USO / CUSTODIO<br/>
            Nombre: {{ $first?->custodioActual?->nombre_completo ?? '' }}<br/>
            C.I.: {{ $first?->custodioActual?->ci ?? '' }}
        </td>
        <td></td>
        <td colspan="3" class="bold text-center valign-top" style="border-top: 1px solid #000000; font-size: 8pt;">
            RESPONSABLE DE INVENTARIACIÓN / SABS<br/>
            DIRECCIÓN ADMINISTRATIVA<br/>
            INSTITUTO TECNOLÓGICO "PUERTO DE MEJILLONES"
        </td>
    </tr>

    <!-- Espaciador -->
    <tr><td colspan="7" style="height: 15px;"></td></tr>

    <!-- Nota de Responsabilidad -->
    <tr>
        <td colspan="7" class="text-left" style="font-size: 7pt; font-style: italic;">
            <strong>NOTA:</strong> Como responsable del bien de uso me comprometo a dar cumplimiento al D.S.0181 Art. 116 (RESPONSABILIDAD POR EL MANEJO DE BIENES). Todos los servidores públicos son responsables por el debido uso, custodia, preservación y demanda de servicios de mantenimiento de los bienes que les fueran asignados.
        </td>
    </tr>
</table>

</body>
</html>
