<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
<<<<<<< HEAD
    <title>Acta de Transferencia - {{ $acta->numero_acta }}</title>
    <style>
        @page {
            size: legal landscape;
            margin: 1cm;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #000;
            line-height: 1.2;
        }
        .header-table, .info-table, .items-table {
            width: 100%;
            border-collapse: collapse;
        }
        .header-table td {
            text-align: center;
            font-weight: bold;
            font-size: 12px;
        }
        .titulo-acta {
            text-align: center;
            font-size: 15px;
            font-weight: bold;
            text-decoration: underline;
            color: #000000;
            margin: 10px 0 4px 0;
        }
        .subtitulo-fecha {
            text-align: center;
            font-size: 12px;
            font-weight: bold;
            color: #cc0000;
            margin-bottom: 12px;
        }
        .info-table {
            margin-bottom: 15px;
            font-size: 10px;
        }
        .info-table th, .info-table td {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: top;
        }
        .info-box-title {
            font-weight: bold;
            background: #f1f1f1;
        }
        .red-text {
            color: #cc0000;
            font-weight: bold;
        }
        .items-table th, .items-table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
            font-size: 10px;
        }
        .items-table th {
            background: #e2e8f0;
            font-weight: bold;
        }
        .text-left {
            text-align: left !important;
        }
        .observaciones {
            margin-top: 15px;
            border: 1px solid #000;
            padding: 8px;
            font-weight: bold;
            font-size: 11px;
=======
    <title>Acta de Transferencia</title>
    <style>
        @page { size: 216mm 330mm; margin: 15mm 15mm; }
        * { box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 10px; color: #111; line-height: 1.5; }

        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header h1 { font-size: 14px; margin: 0; text-transform: uppercase; }
        .header h2 { font-size: 11px; margin: 3px 0 0 0; font-weight: normal; }
        .header h3 { font-size: 13px; margin: 12px 0 4px 0; text-transform: uppercase; }
        .header .fecha { font-size: 10px; margin-top: 6px; }

        .section { margin-bottom: 15px; }
        .section-title {
            font-size: 11px; font-weight: bold; background: #f0f0f0;
            padding: 6px 8px; border: 1px solid #000; text-transform: uppercase;
        }
        .section-body { padding: 8px 10px; border: 1px solid #999; border-top: none; }

        table.info { width: 100%; border-collapse: collapse; font-size: 10px; }
        table.info td { padding: 4px 6px; vertical-align: top; border-bottom: 0.5px solid #ddd; }
        table.info td.label { font-weight: bold; width: 28%; background: #fafafa; }

        .box {
            border: 1px solid #000; padding: 10px; margin-bottom: 10px;
        }
        .box-title { font-weight: bold; text-transform: uppercase; font-size: 10px; margin-bottom: 6px; }

        .firmas { margin-top: 80px; width: 100%; border-collapse: collapse; }
        .firmas td {
            text-align: center; padding-top: 40px; font-size: 10px;
            vertical-align: bottom; width: 50%;
        }
        .firmas .linea {
            border-top: 1px solid #000; margin: 0 30px;
            padding-top: 5px; font-weight: bold;
        }

        .texto-legal {
            font-size: 8px; color: #444; line-height: 1.4;
            margin-top: 25px; padding: 8px; border: 1px dashed #999;
            background: #fafafa;
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
        }
    </style>
</head>
<body>

<<<<<<< HEAD
    <table class="header-table">
        <tr>
            <td>INSTITUTO TECNOLÓGICO PUERTO DE MEJILLONES</td>
        </tr>
        <tr>
            <td>DIRECCIÓN ADMINISTRATIVA</td>
        </tr>
    </table>

    <div class="titulo-acta">ACTA DE TRANSFERENCIA</div>
    <div class="subtitulo-fecha">
        {{ strtoupper(\Carbon\Carbon::parse($acta->fecha_transferencia)->translatedFormat('d DE F_ DE Y')) }}
    </div>

    <table class="info-table">
        <tr>
            <td style="width: 50%;">
                <strong>TRANSFERENCIA INTERNA:</strong> <span class="red-text">{{ $acta->numero_acta }}</span>
            </td>
            <td style="width: 50%;">
                <strong>UBICACIÓN ACTUAL:</strong> <span class="red-text">{{ strtoupper($acta->origenAmbiente->nombre ?? '—') }}</span>
            </td>
        </tr>
        <tr>
            <td>
                <strong>DE OF.:</strong> {{ strtoupper($acta->origenAmbiente->nombre ?? '—') }}<br>
                <strong>RESPONSABLE:</strong> <span class="red-text">{{ strtoupper($acta->custodioAnterior->nombre_completo ?? '—') }}</span><br>
                <strong>CARGO:</strong> <span class="red-text">CUSTODIO / DOCENTE</span>
            </td>
            <td>
                <strong>DE OF.:</strong> <span class="red-text">{{ strtoupper($acta->destinoAmbiente->nombre ?? '—') }}</span><br>
                <strong>RESPONSABLE:</strong> <span class="red-text">{{ strtoupper($acta->custodioNuevo->nombre_completo ?? '—') }}</span><br>
                <strong>CARGO:</strong> <span class="red-text">CUSTODIO / RESPONSABLE</span>
=======
    {{-- ENCABEZADO --}}
    <div class="header">
        <h1>INSTITUTO TECNOLÓGICO "PUERTO DE MEJILLONES"</h1>
        <h2>DIRECCIÓN ADMINISTRATIVA</h2>
        <h3>ACTA DE TRANSFERENCIA INTERNA DE ACTIVO FIJO</h3>
        <div class="fecha">
            N° <strong>{{ $acta->numero_acta }}</strong> ·
            El Alto, {{ \Carbon\Carbon::parse($acta->fecha_transferencia)->translatedFormat('d \d\e F \d\e Y') }}
        </div>
    </div>

    {{-- DATOS DEL ACTIVO --}}
    <div class="section">
        <div class="section-title">1. Datos del Activo Transferido</div>
        <div class="section-body">
            <table class="info">
                <tr>
                    <td class="label">Código de Activo:</td>
                    <td>{{ $acta->activo->codigo_activo ?? '—' }}</td>
                </tr>
                <tr>
                    <td class="label">Descripción:</td>
                    <td>{{ $acta->activo->nombre ?? '—' }}</td>
                </tr>
                <tr>
                    <td class="label">Marca / Modelo:</td>
                    <td>{{ $acta->activo->marca ?? '—' }} / {{ $acta->activo->modelo ?? '—' }}</td>
                </tr>
                <tr>
                    <td class="label">N° de Serie:</td>
                    <td>{{ $acta->activo->numero_serie ?? '—' }}</td>
                </tr>
                <tr>
                    <td class="label">Categoría:</td>
                    <td>{{ $acta->activo->categoria->nombre ?? '—' }}</td>
                </tr>
                <tr>
                    <td class="label">Fuente Financiamiento:</td>
                    <td>{{ $acta->activo->fuente->nombre ?? '—' }}</td>
                </tr>
                <tr>
                    <td class="label">Estado Físico:</td>
                    <td>{{ $acta->activo->estado_fisico_texto ?? '—' }}</td>
                </tr>
            </table>
        </div>
    </div>

    {{-- ORIGEN Y DESTINO --}}
    <div class="section">
        <div class="section-title">2. Entrega y Recepción</div>
        <div class="section-body">

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px; margin-bottom:10px;">
                <div class="box">
                    <div class="box-title">ENTREGA (Origen)</div>
                    <table class="info">
                        <tr><td class="label">Ambiente:</td><td>{{ $acta->origenAmbiente->nombre ?? '—' }}</td></tr>
                        <tr><td class="label">Carrera:</td><td>{{ $acta->origenAmbiente->carrera->nombre ?? '—' }}</td></tr>
                        <tr><td class="label">Custodio:</td><td>{{ $acta->custodioAnterior->nombre_completo ?? '—' }}</td></tr>
                        <tr><td class="label">C.I.:</td><td>{{ $acta->custodioAnterior->ci ?? '—' }}</td></tr>
                        <tr><td class="label">Cargo:</td><td>{{ $acta->custodioAnterior->cargo ?? '—' }}</td></tr>
                    </table>
                </div>
                <div class="box">
                    <div class="box-title">RECIBE (Destino)</div>
                    <table class="info">
                        <tr><td class="label">Ambiente:</td><td>{{ $acta->destinoAmbiente->nombre ?? '—' }}</td></tr>
                        <tr><td class="label">Carrera:</td><td>{{ $acta->destinoAmbiente->carrera->nombre ?? '—' }}</td></tr>
                        <tr><td class="label">Custodio:</td><td>{{ $acta->custodioNuevo->nombre_completo ?? '—' }}</td></tr>
                        <tr><td class="label">C.I.:</td><td>{{ $acta->custodioNuevo->ci ?? '—' }}</td></tr>
                        <tr><td class="label">Cargo:</td><td>{{ $acta->custodioNuevo->cargo ?? '—' }}</td></tr>
                    </table>
                </div>
            </div>

        </div>
    </div>

    {{-- OBSERVACIONES --}}
    @if($acta->observaciones)
        <div class="section">
            <div class="section-title">3. Observaciones</div>
            <div class="section-body">
                {{ $acta->observaciones }}
            </div>
        </div>
    @endif

    {{-- FIRMAS --}}
    <table class="firmas">
        <tr>
            <td>
                <div class="linea">
                    {{ $acta->custodioAnterior->nombre_completo ?? 'Custodio Anterior' }}<br>
                    C.I.: {{ $acta->custodioAnterior->ci ?? '—' }}<br>
                    <span style="font-weight:normal;">ENTREGA (Custodio Saliente)</span>
                </div>
            </td>
            <td>
                <div class="linea">
                    {{ $acta->custodioNuevo->nombre_completo ?? 'Custodio Nuevo' }}<br>
                    C.I.: {{ $acta->custodioNuevo->ci ?? '—' }}<br>
                    <span style="font-weight:normal;">RECIBE (Custodio Entrante)</span>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding-top:60px;">
                <div class="linea" style="margin: 0 150px;">
                    LIC. ANA LÍA ZAPANA CORTEZ<br>
                    C.I.: 4756925<br>
                    <span style="font-weight:normal;">DIRECTORA ADMINISTRATIVA</span>
                </div>
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
            </td>
        </tr>
    </table>

<<<<<<< HEAD
    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 40px;">ITEM</th>
                <th style="width: 140px;">CODIGO</th>
                <th style="width: 70px;">ESTADO</th>
                <th style="width: 60px;">CANT.</th>
                <th>DESCRIPCIÓN</th>
            </tr>
        </thead>
        <tbody>
            @php $activo = $acta->activo; @endphp
            <tr>
                <td><strong>1</strong></td>
                <td><strong>{{ $activo->codigo_activo ?? '—' }}</strong></td>
                <td><strong>{{ $activo->estado_fisico ?? 'B' }}</strong></td>
                <td><strong>1</strong></td>
                <td class="text-left">
                    <strong>{{ strtoupper($activo->nombre ?? '') }}</strong><br>
                    Marca: {{ $activo->marca ?? 'S/M' }} | Modelo: {{ $activo->modelo ?? 'S/Mod' }} | Serie: {{ $activo->numero_serie ?? 'S/N' }}<br>
                    <span style="font-size: 9px; color: #475569;">{{ $activo->descripcion }}</span>
                </td>
            </tr>
            {{-- Rellenar filas vacías para mantener el formato estético impreso del formato oficial --}}
            @for($i = 2; $i <= 8; $i++)
            <tr>
                <td>{{ $i }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @endfor
        </tbody>
    </table>

    <div class="observaciones">
        OBSERVACIONES: {{ strtoupper($acta->observaciones ?? 'NINGUNA') }}
=======
    {{-- LEYENDA LEGAL --}}
    <div class="texto-legal">
        <strong>IMPORTANTE:</strong> Como responsable del bien de uso, me comprometo a dar cumplimiento al
        D.S. 0181 Art. 116 (Responsabilidad por el Manejo de Bienes), Parágrafo III. Todos los Servidores
        Públicos son responsables por el debido uso, custodia, preservación y demanda de servicios de
        mantenimiento de los bienes que les fueran asignados, de acuerdo al régimen de Responsabilidad
        por la Función Pública, establecido en la Ley 1178 y sus reglamentos.
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
    </div>

</body>
</html>
