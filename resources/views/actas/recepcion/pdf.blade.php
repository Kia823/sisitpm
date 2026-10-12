<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
<<<<<<< HEAD
    <title>Acta de Entrega y Recepción</title>
    <style>
        @page { size: 216mm 330mm; margin: 12mm 10mm; }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Helvetica, Arial, sans-serif; font-size: 9px; color: #000; line-height: 1.3; }

        /* ============ ENCABEZADO CON LOGO ============ */
        .header-table { width: 100%; border-collapse: collapse; margin-bottom: 8px; }
        .header-table td { vertical-align: middle; }
        .logo-cell {
            width: 80px;
            text-align: center;
        }
        .logo-img {
            width: 70px;
            height: 70px;
            object-fit: contain;
        }
        .header-center {
            text-align: center;
        }
        .title-main {
            font-weight: bold;
            font-size: 12px;
            text-transform: uppercase;
        }
        .title-sub {
            font-size: 9px;
            margin-top: 2px;
        }
        .title-acta {
            font-weight: bold;
            font-size: 10px;
            margin-top: 4px;
            text-transform: uppercase;
        }
        .fecha-acta {
            font-size: 8px;
            font-weight: bold;
            margin-top: 2px;
        }
        .box-right {
            border: 1px solid #000;
            padding: 4px 6px;
            text-align: center;
            font-size: 8px;
            font-weight: bold;
            width: 110px;
        }

        /* ============ TEXTO LEGAL ============ */
        .legal-text {
            font-size: 8px;
            text-align: justify;
            margin: 8px 0;
            border: 1px solid #000;
            padding: 5px;
            background: #fcfcfc;
            line-height: 1.4;
        }

        /* ============ TABLA DE INFO ============ */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }
        .info-table th,
        .info-table td {
            border: 1px solid #000;
            padding: 4px 6px;
            font-size: 8px;
            text-align: left;
        }
        .info-table th {
            background-color: #f2f2f2;
            width: 22%;
            font-weight: bold;
        }

        /* ============ TABLA PRINCIPAL DE ACTIVOS ============ */
        .grid-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }
        .grid-table th,
        .grid-table td {
            border: 1px solid #000;
            padding: 4px;
            text-align: center;
            font-size: 7px;
            vertical-align: middle;
        }
        .grid-table th {
            background-color: #e5e7eb;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 7px;
        }
        .grid-table td.descripcion {
            text-align: left;
            padding: 5px 6px;
            line-height: 1.35;
        }

        /* ============ FOTOS EN GRID ============ */
        .fotos-grid {
            display: table;
            width: 100%;
            border-collapse: collapse;
        }
        .foto-item {
            display: table-cell;
            width: 33.33%;
            padding: 2px;
            text-align: center;
            vertical-align: middle;
        }
        .foto-img {
            width: 55px;
            height: 55px;
            object-fit: cover;
            border: 1px solid #999;
            border-radius: 3px;
            display: block;
            margin: 0 auto;
        }
        .foto-label {
            font-size: 6px;
            color: #666;
            margin-top: 1px;
            text-transform: uppercase;
            font-weight: bold;
        }
        .foto-vacia {
            font-size: 6px;
            color: #888;
            font-style: italic;
        }

        /* ============ OBSERVACIONES ============ */
        .obs-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }
        .obs-table th,
        .obs-table td {
            border: 1px solid #000;
            padding: 5px 6px;
            font-size: 8px;
            text-align: left;
            vertical-align: top;
        }
        .obs-table th {
            background-color: #f2f2f2;
            width: 15%;
            font-weight: bold;
        }

        /* ============ FIRMAS ============ */
        .signatures-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }
        .signatures-table td {
            width: 50%;
            padding: 8px;
            vertical-align: top;
            height: 90px;
            text-align: center;
        }
        .firma-linea {
            border-top: 1px solid #000;
            padding-top: 4px;
            font-size: 8px;
            font-weight: bold;
            line-height: 1.4;
        }
        .firma-detalle {
            font-weight: normal;
            font-size: 7px;
            color: #333;
        }

        /* ============ NOTA FINAL ============ */
        .footer-note {
            font-size: 7px;
            margin-top: 12px;
            text-align: justify;
            line-height: 1.4;
            border-top: 1px solid #ccc;
            padding-top: 6px;
        }
        .footer-note strong {
            font-weight: bold;
        }
=======
    <title>Acta de Recepción</title>
    <style>
        @page { size: 216mm 330mm; margin: 15mm; }
        * { box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 10px; color: #111; line-height: 1.5; }

        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header h1 { font-size: 14px; margin: 0; text-transform: uppercase; }
        .header h2 { font-size: 11px; margin: 3px 0 0 0; font-weight: normal; }
        .header h3 { font-size: 13px; margin: 12px 0 4px 0; text-transform: uppercase; }

        .datos { width: 100%; border-collapse: collapse; font-size: 10px; margin-bottom: 12px; }
        .datos td { padding: 4px 6px; vertical-align: top; border: 0.5px solid #999; }
        .datos .label { font-weight: bold; background: #f0f0f0; width: 25%; }

        table.inventario { width: 100%; border-collapse: collapse; font-size: 8px; }
        table.inventario thead th {
            background: #e5e5e5; border: 0.7px solid #000; padding: 4px;
            text-align: center; font-weight: bold; text-transform: uppercase;
        }
        table.inventario tbody td { border: 0.5px solid #555; padding: 3px; vertical-align: top; }

        .firmas { margin-top: 50px; width: 100%; border-collapse: collapse; }
        .firmas td { text-align: center; padding-top: 40px; font-size: 10px; vertical-align: bottom; }
        .firmas .linea { border-top: 1px solid #000; margin: 0 30px; padding-top: 5px; font-weight: bold; }

        .legal { font-size: 8px; color: #444; margin-top: 20px; padding: 8px; border: 1px dashed #999; background: #fafafa; }
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
    </style>
</head>
<body>

<<<<<<< HEAD
    {{-- ============================================================ --}}
    {{-- ENCABEZADO CON LOGO --}}
    {{-- ============================================================ --}}
    <table class="header-table">
        <tr>
            {{-- LOGO INSTITUCIONAL --}}
            <td class="logo-cell">
                @if(file_exists(public_path('logo.png')))
                    <img class="logo-img" src="{{ public_path('logo.png') }}" alt="Logo">
                @elseif(file_exists(public_path('images/logo.png')))
                    <img class="logo-img" src="{{ public_path('images/logo.png') }}" alt="Logo">
                @else
                    <div style="font-size: 7px; color: #999;">[LOGO]</div>
                @endif
            </td>

            {{-- TÍTULO CENTRAL --}}
            <td class="header-center">
                <div class="title-main">Instituto Tecnológico "Puerto de Mejillones"</div>
                <div class="title-sub">DIRECCIÓN ADMINISTRATIVA</div>
                <div class="title-acta">ACTA DE ENTREGA Y RECEPCIÓN</div>
                <div class="fecha-acta">{{ now()->translatedFormat('d \d\e F \d\e Y') }}</div>
            </td>

            {{-- CAJA FORMULARIO --}}
            <td style="width: 110px; text-align: right; vertical-align: top;">
                <div class="box-right">
                    FORMULARIO N° 1<br>
                    <span style="font-weight: normal; font-size: 7px;">HOJA N° 1 de 1</span>
                </div>
            </td>
        </tr>
    </table>

    {{-- ============================================================ --}}
    {{-- TEXTO LEGAL --}}
    {{-- ============================================================ --}}
    <div class="legal-text">
        En cumplimiento al D.S. 0181 Normas Básicas del Sistema de Administración de Bienes y Servicios en su Art. 146, 147, 157
        (Asignación de Activos Fijos Muebles), la Dirección Administrativa del Instituto Tecnológico "Puerto de Mejillones",
        procedió a la verificación y asignación de los siguientes activos.
    </div>

    {{-- ============================================================ --}}
    {{-- DATOS DEL CUSTODIO --}}
    {{-- ============================================================ --}}
    @php $first = $activos->first(); @endphp
    <table class="info-table">
        <tr>
            <th>NOMBRE DEL CUSTODIO:</th>
            <td>{{ $first?->custodioActual?->nombre_completo ?? 'N/A' }}</td>
            <th>C.I.:</th>
            <td>{{ $first?->custodioActual?->ci ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>CARGO:</th>
            <td>{{ $first?->custodioActual?->cargo ?? 'N/A' }}</td>
            <th>UNIDAD ORGANIZACIONAL:</th>
            <td>{{ $first?->custodioActual?->unidad_organizacional ?? $first?->custodioActual?->unidad ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>UBICACIÓN / AMBIENTE:</th>
            <td>{{ $first?->ambiente?->nombre ?? 'N/A' }}</td>
            <th>CARRERA:</th>
            <td>{{ $first?->ambiente?->carrera?->nombre ?? 'N/A' }}</td>
        </tr>
    </table>

    {{-- ============================================================ --}}
    {{-- TABLA PRINCIPAL DE ACTIVOS --}}
    {{-- ============================================================ --}}
    <table class="grid-table">
        <thead>
            <tr>
                <th style="width: 30px;">ITEM</th>
                <th style="width: 80px;">CÓDIGO</th>
                <th style="width: 45px;">FUENTE</th>
                <th style="width: 35px;">EST.</th>
                <th style="width: 30px;">CANT.</th>
                <th>DESCRIPCIÓN Y ESPECIFICACIONES</th>
                <th style="width: 185px;">FOTOGRAFÍAS DEL ACTIVO</th>
            </tr>
        </thead>
        <tbody>
            @forelse($activos as $index => $act)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $act->codigo_activo }}</strong><br>
                        <small style="font-size: 6px; color: #666;">{{ $act->numero_serie ?? 'S/N' }}</small>
                    </td>
                    <td>{{ $act->fuente?->codigo ?? $act->fuenteFinanciamiento?->codigo ?? 'GAEDP' }}</td>
                    <td>{{ $act->estado_fisico }}</td>
                    <td>1</td>
                    <td class="descripcion">
                        <strong>{{ $act->nombre }}</strong><br>
                        MARCA: {{ $act->marca ?? '—' }} | MODELO: {{ $act->modelo ?? '—' }}<br>
                        <small style="color: #555;">{{ $act->descripcion }}</small>
                    </td>
                    <td style="padding: 3px;">
                        <div class="fotos-grid">
                            {{-- FOTO FRONTAL --}}
                            <div class="foto-item">
                                @if($act->imagen && file_exists(public_path('storage/' . $act->imagen)))
                                    <img class="foto-img" src="{{ public_path('storage/' . $act->imagen) }}" alt="Frontal">
                                @else
                                    <div class="foto-vacia">Sin foto</div>
                                @endif
                                <div class="foto-label">Frontal</div>
                            </div>

                            {{-- FOTO LATERAL --}}
                            <div class="foto-item">
                                @if($act->imagen_lateral && file_exists(public_path('storage/' . $act->imagen_lateral)))
                                    <img class="foto-img" src="{{ public_path('storage/' . $act->imagen_lateral) }}" alt="Lateral">
                                @else
                                    <div class="foto-vacia">Sin foto</div>
                                @endif
                                <div class="foto-label">Lateral</div>
                            </div>

                            {{-- FOTO DETALLE --}}
                            <div class="foto-item">
                                @if($act->imagen_detalle && file_exists(public_path('storage/' . $act->imagen_detalle)))
                                    <img class="foto-img" src="{{ public_path('storage/' . $act->imagen_detalle) }}" alt="Detalle">
                                @else
                                    <div class="foto-vacia">Sin foto</div>
                                @endif
                                <div class="foto-label">Detalle</div>
                            </div>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 20px;">
                        No hay activos asignados para este reporte.
                    </td>
                </tr>
=======
    <div class="header">
        <h1>INSTITUTO TECNOLÓGICO "PUERTO DE MEJILLONES"</h1>
        <h2>DIRECCIÓN ADMINISTRATIVA</h2>
        <h3>ACTA DE ENTREGA Y RECEPCIÓN</h3>
        <div style="font-size: 10px; margin-top: 6px;">
            El Alto, {{ now()->translatedFormat('d \d\e F \d\e Y') }}
        </div>
    </div>

    <table class="datos">
        <tr>
            <td class="label">Ambiente:</td>
            <td colspan="3"><strong>{{ $ambiente->nombre }}</strong></td>
        </tr>
        <tr>
            <td class="label">Carrera:</td>
            <td>{{ $ambiente->carrera->nombre ?? '—' }}</td>
            <td class="label">Código:</td>
            <td>{{ $ambiente->codigo }}</td>
        </tr>
        <tr>
            <td class="label">Custodio:</td>
            <td colspan="3">{{ $responsable->nombre_completo ?? 'Responsable' }}</td>
        </tr>
        <tr>
            <td class="label">Total Activos:</td>
            <td colspan="3">{{ $activos->count() }}</td>
        </tr>
    </table>

    <p style="font-size: 10px; text-align: justify; margin-bottom: 8px;">
        En cumplimiento al D.S. 0181 Normas Básicas del Sistema de Administración de Bienes y Servicios en su Art. 146, 147, 157, se procede a la entrega y recepción formal de los siguientes activos.
    </p>

    <table class="inventario">
        <thead>
            <tr>
                <th style="width: 4%;">N°</th>
                <th style="width: 15%;">CÓDIGO</th>
                <th style="width: 35%;">DESCRIPCIÓN</th>
                <th style="width: 12%;">CATEGORÍA</th>
                <th style="width: 8%;">CANT.</th>
                <th style="width: 8%;">ESTADO</th>
                <th style="width: 8%;">FUENTE</th>
            </tr>
        </thead>
        <tbody>
            @forelse($activos as $i => $act)
                <tr>
                    <td style="text-align: center;">{{ $i + 1 }}</td>
                    <td>{{ $act->codigo_activo }}</td>
                    <td>{{ $act->nombre }}</td>
                    <td>{{ $act->categoria->nombre ?? '—' }}</td>
                    <td style="text-align: center;">1</td>
                    <td style="text-align: center;">{{ $act->estado_fisico }}</td>
                    <td style="text-align: center;">{{ $act->fuente->codigo ?? '—' }}</td>
                </tr>
            @empty
                <tr><td colspan="7" style="text-align: center;">Sin activos</td></tr>
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
            @endforelse
        </tbody>
    </table>

<<<<<<< HEAD
    {{-- ============================================================ --}}
    {{-- OBSERVACIONES --}}
    {{-- ============================================================ --}}
    <table class="obs-table">
        <tr>
            <th>OBSERVACIONES:</th>
            <td>
                ASIGNACIÓN PROVISIONAL / DEFINITIVA DE ACTIVOS FIJOS SEGÚN REGISTRO SISTEMA DE INVENTARIOS.
            </td>
        </tr>
    </table>

    {{-- ============================================================ --}}
    {{-- BLOQUE DE FIRMAS (3 firmas) --}}
    {{-- ============================================================ --}}
    <table class="signatures-table">
        <tr>
            {{-- FIRMA 1: CUSTODIO --}}
            <td style="width: 33%;">
                <br><br><br>
                <div class="firma-linea">
                    RESPONSABLE DEL BIEN EN USO / CUSTODIO<br>
                    <span class="firma-detalle">
                        Nombre: {{ $first?->custodioActual?->nombre_completo ?? '—' }}<br>
                        C.I.: {{ $first?->custodioActual?->ci ?? '—' }}<br>
                        Cargo: {{ $first?->custodioActual?->cargo ?? '—' }}
                    </span>
                </div>
            </td>

            {{-- FIRMA 2: CUSTODIO ANTERIOR / ENTREGA --}}
            <td style="width: 33%;">
                <br><br><br>
                <div class="firma-linea">
                    RESPONSABLE ANTERIOR / ENTREGA<br>
                    <span class="firma-detalle">
                        Nombre: ____________________<br>
                        C.I.: ____________________<br>
                        Cargo: ____________________
                    </span>
                </div>
            </td>

            {{-- FIRMA 3: DIRECTORA ADMINISTRATIVA --}}
            <td style="width: 34%;">
                <br><br><br>
                <div class="firma-linea">
                    RESPONSABLE DE INVENTARIACIÓN / SABS<br>
                    <span class="firma-detalle">
                        Lic. Ana Lía Zapana Cortez<br>
                        C.I.: 4756925<br>
                        Directora Administrativa<br>
                        INSTITUTO TECNOLÓGICO "PUERTO DE MEJILLONES"
                    </span>
=======
    <table class="firmas">
        <tr>
            <td>
                <div class="linea">
                    ENTREGA<br>
                    {{ $responsable->nombre_completo ?? 'Responsable' }}<br>
                    C.I.: {{ $responsable->ci ?? '—' }}
                </div>
            </td>
            <td>
                <div class="linea">
                    RECIBE<br>
                    Lic. Ana Lía Zapana Cortez<br>
                    C.I.: 4756925
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
                </div>
            </td>
        </tr>
    </table>

<<<<<<< HEAD
    {{-- ============================================================ --}}
    {{-- NOTA DE RESPONSABILIDAD --}}
    {{-- ============================================================ --}}
    <div class="footer-note">
        <strong>IMPORTANTE:</strong> Como responsable del bien de uso me comprometo a dar cumplimiento al
        D.S. 0181 Art. 116 (RESPONSABILIDAD POR EL MANEJO DE BIENES) Parágrafo III. Todos los Servidores Públicos
        son responsables por el debido uso, custodia, preservación y demanda de servicios de mantenimiento de los
        bienes que les fueran asignados, de acuerdo al régimen de Responsabilidad por la Función Pública, establecido
        en la Ley 1178 y sus reglamentos.<br><br>
        <strong>Art. 157 (PROHIBICIONES PARA LOS FUNCIONARIOS PÚBLICOS SOBRE EL USO DE ACTIVOS FIJOS MUEBLES)</strong>
        Inc. A, b, c, d, e, f, g, h.<br><br>
        <strong>NOTA:</strong> COMO RESPONSABLE DEL USO Y CUSTODIO ME COMPROMETO CUMPLIR EL INCISO c :
        PRESTAR O TRANSFERIR EL BIEN A OTRO EMPLEADO PÚBLICO.
=======
    <div class="legal">
        <strong>IMPORTANTE:</strong> Como responsable del bien de uso, me comprometo a dar cumplimiento al D.S. 0181 Art. 116.
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
    </div>

</body>
</html>
