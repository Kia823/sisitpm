<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acta de Alta — {{ $activo->codigo_activo }}</title>
    <style>
        @page { size: 216mm 330mm; margin: 12mm 10mm; }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
            color: #111;
            line-height: 1.4;
        }

        /* ============ ENCABEZADO ============ */
        .header {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 12px;
        }
        .header-top {
            display: table;
            width: 100%;
            margin-bottom: 4px;
        }
        .header-form {
            display: table-cell;
            text-align: left;
            font-size: 9px;
            font-weight: bold;
            width: 20%;
        }
        .header-gestion {
            display: table-cell;
            text-align: right;
            font-size: 9px;
            font-weight: bold;
            width: 20%;
        }
        .header-center {
            display: table-cell;
            text-align: center;
            width: 60%;
        }
        .header-center .mini-titulo {
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .header h1 {
            font-size: 14px;
            font-weight: 800;
            text-transform: uppercase;
            margin: 4px 0 2px 0;
            letter-spacing: 0.3px;
        }
        .header h2 {
            font-size: 11px;
            font-weight: normal;
            margin: 0;
        }
        .header .acta-titulo {
            font-size: 13px;
            font-weight: 800;
            text-transform: uppercase;
            margin-top: 8px;
            padding: 4px 8px;
            background: #ecfdf5;
            border: 1px solid #10b981;
            display: inline-block;
            color: #065f46;
        }

        /* ============ BLOQUE DE DESTACADO ============ */
        .destacado {
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
            border-left: 5px solid #10b981;
            padding: 10px 14px;
            margin: 12px 0;
            border-radius: 4px;
        }
        .destacado .titulo {
            font-size: 11px;
            font-weight: 800;
            color: #065f46;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
        }
        .destacado .subtitulo {
            font-size: 9px;
            color: #047857;
        }

        /* ============ TABLA DE DATOS ============ */
        .seccion {
            margin-bottom: 12px;
        }
        .seccion-titulo {
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            background: #1e293b;
            color: #ffffff;
            padding: 5px 10px;
            letter-spacing: 0.5px;
            border-radius: 3px 3px 0 0;
        }

        table.datos {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
            border: 1px solid #cbd5e1;
            border-top: none;
        }
        table.datos td {
            padding: 5px 8px;
            vertical-align: top;
            border-bottom: 0.5px solid #e2e8f0;
        }
        table.datos tr:last-child td {
            border-bottom: none;
        }
        table.datos .label {
            font-weight: 700;
            background: #f8fafc;
            color: #475569;
            width: 25%;
            border-right: 0.5px solid #e2e8f0;
        }
        table.datos .valor {
            color: #0f172a;
            font-weight: 600;
            width: 25%;
        }

        /* ============ FOTOS ============ */
        .fotos-grid {
            display: table;
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
            border: 1px solid #cbd5e1;
            border-top: none;
        }
        .foto-cell {
            display: table-cell;
            width: 33.33%;
            padding: 12px;
            vertical-align: top;
            text-align: center;
            border-right: 0.5px solid #e2e8f0;
        }
        .foto-cell:last-child {
            border-right: none;
        }
        .foto-titulo {
            font-size: 9px;
            font-weight: 800;
            color: #475569;
            text-transform: uppercase;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }
        .foto-container {
            width: 100%;
            height: 130px;
            border: 2px dashed #cbd5e1;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8fafc;
            overflow: hidden;
        }
        .foto-container img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
        .foto-sin {
            font-size: 9px;
            color: #94a3b8;
            font-style: italic;
        }

        /* ============ QR DESTACADO ============ */
        .qr-destacado {
            display: table;
            width: 100%;
            margin-top: 8px;
            border: 1px solid #cbd5e1;
            border-top: none;
            background: #f8fafc;
        }
        .qr-left {
            display: table-cell;
            width: 30%;
            text-align: center;
            padding: 12px;
            vertical-align: middle;
            border-right: 0.5px solid #e2e8f0;
        }
        .qr-left img {
            width: 100px;
            height: 100px;
        }
        .qr-right {
            display: table-cell;
            padding: 12px 16px;
            vertical-align: middle;
        }
        .qr-right .codigo-grande {
            font-size: 18px;
            font-weight: 800;
            color: #dc2626;
            letter-spacing: 1px;
            margin-bottom: 4px;
            font-family: 'Courier New', monospace;
        }
        .qr-right .info {
            font-size: 10px;
            color: #475569;
            line-height: 1.6;
        }

        /* ============ TABLA DE CAMPOS ============ */
        .firma-legal {
            font-size: 8px;
            color: #444;
            margin-top: 15px;
            padding: 8px 10px;
            border: 1px dashed #94a3b8;
            background: #fafafa;
            text-align: justify;
            line-height: 1.5;
            border-radius: 3px;
        }

        /* ============ FIRMAS ============ */
        .firmas {
            margin-top: 45px;
            width: 100%;
            border-collapse: collapse;
        }
        .firmas td {
            text-align: center;
            padding-top: 30px;
            font-size: 10px;
            vertical-align: bottom;
            width: 50%;
        }
        .firmas .linea {
            border-top: 1px solid #000;
            margin: 0 25px;
            padding-top: 5px;
            font-weight: bold;
        }
        .firmas .cargo {
            font-weight: normal;
            font-size: 9px;
            color: #475569;
        }

        /* ============ PIE ============ */
        .pie {
            margin-top: 20px;
            padding-top: 8px;
            border-top: 1px solid #cbd5e1;
            text-align: center;
            font-size: 8px;
            color: #94a3b8;
        }
    </style>
</head>
<body>

    {{-- ============================================================ --}}
    {{-- ENCABEZADO --}}
    {{-- ============================================================ --}}
    <div class="header">
        <div class="header-top">
            <div class="header-form">
                FORMULARIO A
            </div>
            <div class="header-center">
                <div class="mini-titulo">Equipos Otorgados por el Ministerio de Educación</div>
            </div>
            <div class="header-gestion">
                GESTIÓN {{ now()->format('Y') }}
            </div>
        </div>

        <h1>Instituto Tecnológico "Puerto de Mejillones"</h1>
        <h2>Dirección Administrativa — Unidad de Activos Fijos</h2>

        <div class="acta-titulo">Acta de Alta de Activo Fijo</div>
    </div>

    {{-- ============================================================ --}}
    {{-- BLOQUE DESTACADO --}}
    {{-- ============================================================ --}}
    <div class="destacado">
        <div class="titulo">✓ Ingreso Formal al Inventario Institucional</div>
        <div class="subtitulo">
            Documento que certifica la incorporación del activo en el registro oficial conforme al
            D.S. 0181 — Normas Básicas del Sistema de Administración de Bienes y Servicios.
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- SECCIÓN 1: DATOS DEL ACTA --}}
    {{-- ============================================================ --}}
    <div class="seccion">
        <div class="seccion-titulo">1. Datos del Acta</div>
        <table class="datos">
            <tr>
                <td class="label">Código Interno:</td>
                <td class="valor">ALTA-{{ now()->format('Y') }}-{{ str_pad($activo->id_activo, 5, '0', STR_PAD_LEFT) }}</td>
                <td class="label">Fecha de Alta:</td>
                <td class="valor">{{ now()->translatedFormat('d \d\e F \d\e Y') }}</td>
            </tr>
            <tr>
                <td class="label">Generado por:</td>
                <td class="valor">{{ Auth::user()->nombre_completo ?? 'Sistema' }}</td>
                <td class="label">Cargo:</td>
                <td class="valor">{{ Auth::user()->cargo ?? 'Dirección Administrativa' }}</td>
            </tr>
        </table>
    </div>

    {{-- ============================================================ --}}
    {{-- SECCIÓN 2: DATOS DEL ACTIVO --}}
    {{-- ============================================================ --}}
    <div class="seccion">
        <div class="seccion-titulo">2. Identificación del Activo</div>
        <table class="datos">
            <tr>
                <td class="label">Código del Activo:</td>
                <td class="valor" style="color: #dc2626; font-weight: 800; font-family: 'Courier New', monospace;">
                    {{ $activo->codigo_activo }}
                </td>
                <td class="label">N° Serie:</td>
                <td class="valor">{{ $activo->numero_serie ?? '—' }}</td>
            </tr>
            <tr>
                <td class="label">Nombre del Activo:</td>
                <td class="valor" colspan="3">{{ $activo->nombre }}</td>
            </tr>
            <tr>
                <td class="label">Descripción:</td>
                <td class="valor" colspan="3" style="font-weight: normal;">
                    {{ $activo->descripcion ?? 'Sin descripción registrada.' }}
                </td>
            </tr>
            <tr>
                <td class="label">Marca:</td>
                <td class="valor">{{ $activo->marca ?? '—' }}</td>
                <td class="label">Modelo:</td>
                <td class="valor">{{ $activo->modelo ?? '—' }}</td>
            </tr>
            <tr>
                <td class="label">Categoría:</td>
                <td class="valor">{{ $activo->categoria->nombre ?? '—' }}</td>
                <td class="label">Estado Físico:</td>
                <td class="valor" style="color: #10b981; font-weight: 800;">
                    {{ $activo->estado_fisico_texto ?? '—' }}
                </td>
            </tr>
        </table>
    </div>

    {{-- ============================================================ --}}
    {{-- SECCIÓN 3: DATOS DE UBICACIÓN Y RESPONSABLE --}}
    {{-- ============================================================ --}}
    <div class="seccion">
        <div class="seccion-titulo">3. Ubicación y Responsable</div>
        <table class="datos">
            <tr>
                <td class="label">Ambiente:</td>
                <td class="valor">{{ $activo->ambiente->nombre ?? 'Sin asignar' }}</td>
                <td class="label">Carrera:</td>
                <td class="valor">{{ $activo->ambiente->carrera->nombre ?? 'Sin asignar' }}</td>
            </tr>
            <tr>
                <td class="label">Bloque / Piso:</td>
                <td class="valor">
                    Bloque {{ $activo->ambiente->bloque ?? '—' }} · Piso {{ $activo->ambiente->piso ?? '—' }}
                </td>
                <td class="label">Custodio Asignado:</td>
                <td class="valor">{{ $activo->custodio->nombre_completo ?? 'Sin asignar' }}</td>
            </tr>
            <tr>
                <td class="label">Fuente Financiamiento:</td>
                <td class="valor">
                    {{ $activo->fuente->codigo ?? '' }} {{ $activo->fuente->nombre ?? '—' }}
                </td>
                <td class="label">C.I. Custodio:</td>
                <td class="valor">{{ $activo->custodio->ci ?? '—' }}</td>
            </tr>
        </table>
    </div>

    {{-- ============================================================ --}}
    {{-- SECCIÓN 4: DATOS ECONÓMICOS --}}
    {{-- ============================================================ --}}
    <div class="seccion">
        <div class="seccion-titulo">4. Datos Económicos</div>
        <table class="datos">
            <tr>
                <td class="label">Fecha de Adquisición:</td>
                <td class="valor">
                    {{ $activo->fecha_adquisicion ? $activo->fecha_adquisicion->translatedFormat('d \d\e F \d\e Y') : '—' }}
                </td>
                <td class="label">Gestión:</td>
                <td class="valor">{{ $activo->gestion ?? now()->format('Y') }}</td>
            </tr>
            <tr>
                <td class="label">Valor de Adquisición:</td>
                <td class="valor" style="font-weight: 800; color: #1d4ed8;">
                    Bs. {{ number_format((float)($activo->valor_adquisicion ?? 0), 2) }}
                </td>
                <td class="label">Estado del Registro:</td>
                <td class="valor" style="color: #10b981; font-weight: 800;">
                    {{ $activo->estado_registro_texto ?? 'ACTIVO' }}
                </td>
            </tr>
        </table>
    </div>

    {{-- ============================================================ --}}
    {{-- SECCIÓN 5: IMÁGENES --}}
    {{-- ============================================================ --}}
    <div class="seccion">
        <div class="seccion-titulo">5. Registro Fotográfico y Código QR</div>
        <div class="fotos-grid">
            {{-- FOTO DEL ACTIVO --}}
            <div class="foto-cell">
                <div class="foto-titulo">📷 Fotografía del Activo</div>
                <div class="foto-container">
                    @if($activo->imagen && file_exists(public_path('storage/' . $activo->imagen)))
                        <img src="{{ public_path('storage/' . $activo->imagen) }}" alt="Foto">
                    @else
                        <span class="foto-sin">Sin imagen registrada</span>
                    @endif
                </div>
            </div>

            {{-- QR DEL ACTIVO --}}
            <div class="foto-cell">
                <div class="foto-titulo">🔲 Código QR</div>
                <div class="foto-container">
                    @if($activo->ruta_qr && file_exists(public_path('storage/' . $activo->ruta_qr)))
                        <img src="{{ public_path('storage/' . $activo->ruta_qr) }}" alt="QR">
                    @else
                        <span class="foto-sin">QR no generado</span>
                    @endif
                </div>
            </div>

            {{-- LOGO INSTITUCIONAL --}}
            <div class="foto-cell">
                <div class="foto-titulo">🏛️ Sello Institucional</div>
                <div class="foto-container">
                    @if(file_exists(public_path('images/logo.png')))
                        <img src="{{ public_path('images/logo.png') }}" alt="Logo">
                    @else
                        <div style="text-align: center; padding: 8px;">
                            <div style="font-size: 22px; margin-bottom: 4px;">🏛️</div>
                            <div style="font-size: 9px; color: #475569; font-weight: bold; line-height: 1.2;">
                                INSTITUTO<br>TECNOLÓGICO<br>PUERTO DE MEJILLONES
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- BLOQUE DE QR DESTACADO --}}
    {{-- ============================================================ --}}
    <div class="seccion">
        <div class="seccion-titulo">6. Verificación Rápida</div>
        <div class="qr-destacado">
            <div class="qr-left">
                @if($activo->ruta_qr && file_exists(public_path('storage/' . $activo->ruta_qr)))
                    <img src="{{ public_path('storage/' . $activo->ruta_qr) }}" alt="QR">
                @else
                    <div style="font-size: 9px; color: #94a3b8;">QR pendiente</div>
                @endif
            </div>
            <div class="qr-right">
                <div class="codigo-grande">{{ $activo->codigo_activo }}</div>
                <div class="info">
                    <strong>Escanee este código QR</strong> para acceder al detalle completo del activo en el sistema SISActivos.<br>
                    Podrá consultar: características técnicas, historial de movimientos, custodio actual, estado físico y más.
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- SECCIÓN 7: OBSERVACIONES --}}
    {{-- ============================================================ --}}
    @if($activo->observaciones)
        <div class="seccion">
            <div class="seccion-titulo">7. Observaciones</div>
            <table class="datos">
                <tr>
                    <td style="padding: 8px 10px; font-size: 10px; line-height: 1.6;">
                        {{ $activo->observaciones }}
                    </td>
                </tr>
            </table>
        </div>
    @endif

    {{-- ============================================================ --}}
    {{-- TEXTO LEGAL --}}
    {{-- ============================================================ --}}
    <div class="firma-legal">
        <strong>NOTA IMPORTANTE:</strong> Como responsable del bien de uso, me comprometo a dar cumplimiento al
        <strong>D.S. 0181 Art. 116</strong> (Responsabilidad por el Manejo de Bienes), Parágrafo III. Todos los Servidores
        Públicos son responsables por el debido uso, custodia, preservación y demanda de servicios de mantenimiento
        de los bienes que les fueran asignados, de acuerdo al régimen de Responsabilidad por la Función Pública,
        establecido en la Ley 1178 y sus reglamentos.
    </div>

    {{-- ============================================================ --}}
    {{-- FIRMAS --}}
    {{-- ============================================================ --}}
    <table class="firmas">
        <tr>
            <td>
                <div class="linea">
                    Responsable de Inventariación<br>
                    <span class="cargo">Unidad de Activos Fijos</span>
                </div>
            </td>
            <td>
                <div class="linea">
                    Lic. Ana Lía Zapana Cortez<br>
                    C.I.: 4756925<br>
                    <span class="cargo">Directora Administrativa</span>
                </div>
            </td>
        </tr>
    </table>

    {{-- ============================================================ --}}
    {{-- PIE DE PÁGINA --}}
    {{-- ============================================================ --}}
    <div class="pie">
        SISActivos — Sistema de Control y Gestión de Activos Fijos · Documento generado el
        {{ now()->format('d/m/Y \a \l\a\s H:i') }} · Página 1 de 1
    </div>

</body>
</html>
