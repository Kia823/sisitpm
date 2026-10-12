<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credencial — {{ $usuario->nombre_completo }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Plus Jakarta Sans', Arial, sans-serif; }

        html, body {
            background: #e2e8f0;
            min-height: 100vh;
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 30px;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
<<<<<<< HEAD
=======
            color-adjust: exact !important;
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
        }

        .credencial-wrapper {
            position: relative;
<<<<<<< HEAD
            width: 340px;
            height: 520px;
            box-shadow: 0 15px 30px rgba(0,0,0,.15);
            border-radius: 20px;
            overflow: hidden;
            background: white;
            border: 1px solid #cbd5e1;
            display: flex;
            flex-direction: column;
        }

        /* ============================================
           FRENTE (Vertical idéntico a la credencial física)
           ============================================ */
        .frente-header {
            background: #0f172a;
            padding: 14px 14px 10px;
            text-align: center;
            border-bottom: 3px solid #dc2626;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
        }

        .frente-logo-img {
            max-width: 140px;
            height: 38px;
            object-fit: contain;
        }

        .frente-sub-text {
            font-size: 12px;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            line-height: 1.2;
        }

        .frente-body {
            flex: 1;
            background: #dc2626;
            padding: 16px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            text-align: center;
        }

        .frente-qr-box {
            width: 170px;
            height: 205px;
            background: white;
            border-radius: 12px;
            padding: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 4px;
        }

        .frente-qr-box svg,
        .frente-qr-box img {
            width: 135px;
            height: 135px;
            display: block;
        }

        .frente-qr-label {
            font-size: 8px;
            font-weight: 800;
            color: #1e3a8a;
            letter-spacing: 1px;
            margin-top: 2px;
        }

        .frente-datos {
            width: 100%;
            color: white;
        }

        .frente-nombre {
            font-size: 14px;
            font-weight: 800;
            text-transform: uppercase;
            line-height: 1.2;
            margin-bottom: 6px;
            text-shadow: 0 1px 2px rgba(0,0,0,0.3);
        }

        .frente-ci {
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.5px;
            opacity: 0.95;
        }

        .frente-footer {
            background: #b91c1c;
            padding: 12px;
            text-align: center;
            border-top: 1px solid rgba(255,255,255,0.2);
        }

        .frente-cargo {
            font-size: 12px;
            font-weight: 800;
            color: #ffffff;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 3px;
        }

        .frente-gestion {
            font-size: 10px;
            font-weight: 700;
            color: #fef08a;
            letter-spacing: 0.5px;
        }

        /* ============================================
           REVERSO (Vertical idéntico a la credencial física)
           ============================================ */
        .reverso {
=======
            width: 520px;
            height: 320px;
            box-shadow: 0 15px 30px rgba(0,0,0,.15);
            border-radius: 18px;
            overflow: hidden;
            background: white;
        }

        /* ⭐ Fondo SVG del frente */
        .credencial-svg-bg {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
        }

        .credencial {
            position: relative;
            z-index: 1;
            width: 100%;
            height: 100%;
            color: white;
            display: flex;
            flex-direction: column;
            padding: 20px 24px;
        }

        /* ============================================
           FRENTE
           ============================================ */
        .credencial-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(255,255,255,0.25);
        }

        .credencial-institucion {
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            line-height: 1.3;
        }

        .credencial-institucion span {
            display: block;
            font-size: 9px;
            font-weight: 600;
            opacity: 0.75;
            letter-spacing: 0.6px;
            margin-top: 2px;
        }

        .credencial-rol {
            background: rgba(255,255,255,0.2);
            padding: 5px 14px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .credencial-body {
            flex: 1;
            display: flex;
            gap: 18px;
            align-items: center;
        }

        .credencial-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: rgba(255,255,255,0.15);
            border: 3px solid rgba(255,255,255,0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .credencial-avatar-iniciales {
            font-size: 36px;
            font-weight: 800;
            letter-spacing: 2px;
            color: white;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .credencial-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .credencial-nombre {
            font-size: 20px;
            font-weight: 800;
            line-height: 1.15;
            margin-bottom: 2px;
            text-shadow: 0 1px 3px rgba(0,0,0,0.2);
        }

        .credencial-campo {
            font-size: 11px;
            line-height: 1.3;
        }

        .credencial-campo strong {
            font-weight: 700;
            opacity: 0.75;
            text-transform: uppercase;
            font-size: 9px;
            letter-spacing: 0.5px;
            margin-right: 4px;
        }

        .credencial-qr {
            background: white;
            padding: 6px;
            border-radius: 8px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .credencial-qr svg,
        .credencial-qr img {
            width: 90px;
            height: 90px;
            display: block;
        }

        .credencial-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 8px;
            padding-top: 8px;
            border-top: 1px solid rgba(255,255,255,0.25);
            font-size: 10px;
            font-weight: 600;
            opacity: 0.85;
        }

        /* ============================================
           REVERSO
           ============================================ */
        .reverso {
            position: relative;
            z-index: 1;
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
            width: 100%;
            height: 100%;
            background: white;
            display: flex;
            flex-direction: column;
<<<<<<< HEAD
            padding: 16px;
            justify-content: space-between;
        }

        .reverso-header {
            text-align: center;
            border-bottom: 2px solid #dc2626;
            padding-bottom: 10px;
        }

        .reverso-institucion {
            font-size: 10.5px;
            font-weight: 800;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .reverso-lema {
            font-size: 9px;
            font-weight: 800;
            color: #dc2626;
=======
            padding: 0;
        }

        /* Encabezado del reverso */
        .reverso-header {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 18px 24px 12px;
            border-bottom: 2px solid #e11d48;
        }

        .reverso-logo {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #2563eb, #7c3aed, #e11d48);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 800;
            font-size: 20px;
            flex-shrink: 0;
            box-shadow: 0 4px 8px rgba(124,58,237,.3);
        }

        .reverso-institucion {
            flex: 1;
        }

        .reverso-institucion h3 {
            font-size: 13px;
            font-weight: 800;
            color: #1e293b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            line-height: 1.2;
        }

        .reverso-institucion .lema {
            font-size: 10px;
            color: #e11d48;
            font-weight: 700;
            letter-spacing: 0.5px;
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
            text-transform: uppercase;
            margin-top: 2px;
        }

<<<<<<< HEAD
        .reverso-sub {
            font-size: 7.5px;
=======
        .reverso-institucion .sub {
            font-size: 9px;
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
            color: #64748b;
            font-weight: 600;
            margin-top: 2px;
        }

<<<<<<< HEAD
        .reverso-texto {
            font-size: 9px;
            color: #1e293b;
            line-height: 1.45;
            text-align: justify;
            text-transform: uppercase;
            font-weight: 600;
            padding: 0 4px;
        }

=======
        /* Texto legal del reverso */
        .reverso-texto {
            flex: 1;
            padding: 14px 24px;
            font-size: 10.5px;
            color: #1e293b;
            line-height: 1.5;
            text-align: justify;
            text-transform: uppercase;
            font-weight: 600;
        }

        /* Firmas */
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
        .reverso-firmas {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
<<<<<<< HEAD
            gap: 10px;
            padding: 0 4px;
=======
            gap: 20px;
            padding: 0 24px 12px;
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
        }

        .firma-box {
            flex: 1;
            text-align: center;
<<<<<<< HEAD
            font-size: 8px;
            color: #0f172a;
        }

        .firma-box .linea {
            border-top: 1px solid #dc2626;
            margin: 20px 4px 4px;
=======
            font-size: 9px;
            color: #1e293b;
        }

        .firma-box .linea {
            border-top: 1.5px solid #e11d48;
            margin: 30px 8px 6px;
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
        }

        .firma-box .nombre {
            font-weight: 800;
<<<<<<< HEAD
            font-size: 8px;
            text-transform: uppercase;
            line-height: 1.1;
        }

        .firma-box .cargo {
            font-size: 7.5px;
            color: #475569;
            font-weight: 600;
            margin-top: 1px;
            text-transform: uppercase;
        }

        .sello-central {
            width: 42px;
            height: 42px;
            border: 1.5px dashed #94a3b8;
=======
            font-size: 10px;
            text-transform: uppercase;
            line-height: 1.2;
        }

        .firma-box .cargo {
            font-size: 9px;
            color: #475569;
            font-weight: 600;
            margin-top: 2px;
            text-transform: uppercase;
        }

        /* Sello central (opcional) */
        .sello-central {
            width: 60px;
            height: 60px;
            border: 2px dashed #94a3b8;
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
<<<<<<< HEAD
            font-size: 6px;
            color: #94a3b8;
            font-weight: 700;
            text-align: center;
            flex-shrink: 0;
        }

        .reverso-footer {
            background: #dc2626;
            color: white;
            padding: 8px 10px;
            font-size: 7.5px;
=======
            font-size: 7px;
            color: #94a3b8;
            font-weight: 700;
            text-align: center;
            padding: 6px;
            flex-shrink: 0;
        }

        /* Pie del reverso */
        .reverso-footer {
            background: #e11d48;
            color: white;
            padding: 8px 20px;
            font-size: 9px;
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
            font-weight: 700;
            display: flex;
            justify-content: space-between;
            align-items: center;
<<<<<<< HEAD
            border-radius: 6px;
        }

        /* ============================================
           IMPRESIÓN
=======
            letter-spacing: 0.3px;
        }

        /* ============================================
           IMPRESIÓN — VERTICAL A4
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
           ============================================ */
        @media print {
            @page {
                size: A4 portrait;
<<<<<<< HEAD
                margin: 10mm;
=======
                margin: 15mm;
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
            }

            html, body {
                background: white !important;
                display: block !important;
                padding: 0 !important;
                margin: 0 !important;
<<<<<<< HEAD
            }

            .btn-imprimir, .etiqueta { display: none !important; }

            .credencial-wrapper {
                width: 54mm !important;
                height: 85.5mm !important;
                margin: 0 auto 10mm !important;
                box-shadow: none !important;
                border-radius: 4mm !important;
                page-break-inside: avoid;
            }
        }

=======
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                color-adjust: exact !important;
            }

            .btn-imprimir { display: none !important; }

            .credencial-wrapper {
                width: 130mm !important;
                height: 80mm !important;
                margin: 0 auto 15mm !important;
                box-shadow: none !important;
                border-radius: 8mm !important;
                page-break-inside: avoid;
                page-break-after: avoid;
            }

            /* Escala las fuentes proporcionalmente */
            .credencial,
            .reverso {
                padding: 5mm 6mm !important;
            }

            .credencial-nombre { font-size: 5.5mm !important; }
            .credencial-institucion { font-size: 3mm !important; }
            .credencial-rol { font-size: 3mm !important; }
            .credencial-campo { font-size: 3mm !important; }
            .reverso-texto { font-size: 2.7mm !important; }

            .credencial-avatar {
                width: 25mm !important;
                height: 25mm !important;
            }

            .credencial-avatar-iniciales {
                font-size: 9mm !important;
            }

            .credencial-qr svg,
            .credencial-qr img {
                width: 22mm !important;
                height: 22mm !important;
            }

            .reverso-logo {
                width: 15mm !important;
                height: 15mm !important;
                font-size: 5mm !important;
            }

            .sello-central {
                width: 15mm !important;
                height: 15mm !important;
                font-size: 1.8mm !important;
            }

            .firma-box .linea {
                margin-top: 8mm !important;
            }

            .firma-box .nombre { font-size: 2.6mm !important; }
            .firma-box .cargo { font-size: 2.2mm !important; }
            .reverso-footer { font-size: 2.3mm !important; padding: 2mm 5mm !important; }
        }

        /* Botón imprimir */
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
        .btn-imprimir {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #2563eb;
            color: white;
            border: none;
            padding: 12px 22px;
            border-radius: 10px;
            font-weight: 700;
            cursor: pointer;
            font-size: 14px;
            box-shadow: 0 8px 16px rgba(37,99,235,0.3);
            z-index: 100;
        }
        .btn-imprimir:hover { background: #1d4ed8; }

<<<<<<< HEAD
=======
        /* Etiquetas "Frente" y "Reverso" (solo pantalla) */
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
        .etiqueta {
            position: absolute;
            top: -22px;
            left: 0;
            background: #1e293b;
            color: white;
            font-size: 10px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 4px;
            text-transform: uppercase;
<<<<<<< HEAD
=======
            letter-spacing: 0.5px;
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
        }
    </style>
</head>
<body>

<<<<<<< HEAD
    {{-- ⭐ FRENTE VERTICAL CON LOGOTIPO Y QR --}}
    <div style="position: relative;">
        <span class="etiqueta">Frente</span>
        <div class="credencial-wrapper">
            <div class="frente-header">
                <img src="{{ asset('images/logo.png') }}" alt="Logo ITPM" class="frente-logo-img">
                <div class="frente-sub-text">INSTITUTO TECNOLÓGICO<br>"PUERTO DE MEJILLONES"</div>
            </div>

            <div class="frente-body">
                <div class="frente-qr-box">
                    {!! $qrImage !!}
                    <span class="frente-qr-label">VERIFICADO</span>
                </div>

                <div class="frente-datos">
                    <div class="frente-nombre">{{ $usuario->nombre_completo }}</div>
                    <div class="frente-ci">C.I. {{ $usuario->ci }}</div>
                </div>
            </div>

            <div class="frente-footer">
                <div class="frente-cargo">{{ $usuario->cargo ?? $usuario->rol }}</div>
                <div class="frente-gestion">Gestión 2026</div>
=======
    {{-- ⭐ FRENTE --}}
    <div style="position: relative;">
        <span class="etiqueta">Frente</span>
        <div class="credencial-wrapper">

            {{-- Fondo SVG inline --}}
            <svg class="credencial-svg-bg" viewBox="0 0 520 320" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="grad-main" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%"   stop-color="#1e3a8a"/>
                        <stop offset="55%"  stop-color="#2563eb"/>
                        <stop offset="100%" stop-color="#7c3aed"/>
                    </linearGradient>

                    <linearGradient id="grad-rainbow" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%"   stop-color="#facc15"/>
                        <stop offset="25%"  stop-color="#ef4444"/>
                        <stop offset="50%"  stop-color="#10b981"/>
                        <stop offset="75%"  stop-color="#3b82f6"/>
                        <stop offset="100%" stop-color="#8b5cf6"/>
                    </linearGradient>
                </defs>

                <rect x="0" y="0" width="520" height="320" rx="18" ry="18" fill="url(#grad-main)"/>
                <rect x="0" y="0" width="520" height="8" fill="url(#grad-rainbow)"/>
                <rect x="0" y="314" width="520" height="6" fill="url(#grad-rainbow)" transform="scale(-1, 1) translate(-520, 0)"/>
            </svg>

            <div class="credencial">

                {{-- Encabezado --}}
                <div class="credencial-header">
                    <div class="credencial-institucion">
                        INSTITUTO TECNOLÓGICO
                        <span>"PUERTO DE MEJILLONES"</span>
                    </div>
                    <div class="credencial-rol">
                        {{ $usuario->rol }}
                    </div>
                </div>

                {{-- Cuerpo --}}
                <div class="credencial-body">
                    @php
                        $partes = explode(' ', trim($usuario->nombre_completo));
                        $iniciales = count($partes) >= 2
                            ? strtoupper(substr($partes[0], 0, 1) . substr($partes[1], 0, 1))
                            : strtoupper(substr($partes[0] ?? 'U', 0, 2));
                    @endphp

                    <div class="credencial-avatar">
                        <div class="credencial-avatar-iniciales">{{ $iniciales }}</div>
                    </div>

                    <div class="credencial-info">
                        <div class="credencial-nombre">{{ $usuario->nombre_completo }}</div>
                        <div class="credencial-campo">
                            <strong>C.I.:</strong> {{ $usuario->ci }}
                        </div>
                        <div class="credencial-campo">
                            <strong>CARGO:</strong> {{ $usuario->cargo ?? 'N/A' }}
                        </div>
                        <div class="credencial-campo">
                            <strong>UNIDAD:</strong> {{ $usuario->unidad ?? 'N/A' }}
                        </div>
                        @if($usuario->email)
                            <div class="credencial-campo">
                                <strong>EMAIL:</strong> {{ $usuario->email }}
                            </div>
                        @endif
                    </div>

                    <div class="credencial-qr">
                        {!! $qrImage !!}
                    </div>
                </div>

                <div class="credencial-footer">
                    <span>Gestión Académica {{ date('Y') }}</span>
                    <span>ITPM</span>
                </div>
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
            </div>
        </div>
    </div>

<<<<<<< HEAD
    {{-- ⭐ REVERSO VERTICAL --}}
    <div style="position: relative;">
        <span class="etiqueta">Reverso</span>
        <div class="credencial-wrapper">
            <div class="reverso">
                <div class="reverso-header">
                    <div class="reverso-institucion">INSTITUTO TECNOLÓGICO</div>
                    <div class="reverso-lema">PUERTO DE MEJILLONES</div>
                    <div class="reverso-sub">ORGANIZACIÓN AL SERVICIO DE LA HUMANIDAD</div>
                </div>

                <div class="reverso-texto">
                    El titular de esta credencial es <strong>{{ strtolower($usuario->cargo ?? 'usuario') }}</strong> del Instituto Tecnológico Puerto de Mejillones. Agradecemos a todas las autoridades gubernamentales, judiciales, policiales y otros, prestar la colaboración requerida en caso necesario.
                </div>

=======
    {{-- ⭐ REVERSO --}}
    <div style="position: relative;">
        <span class="etiqueta">Reverso</span>
        <div class="credencial-wrapper" style="background: white;">
            <div class="reverso">

                {{-- Encabezado del reverso --}}
                <div class="reverso-header">
                    <div class="reverso-logo">
                        ITPM
                    </div>
                    <div class="reverso-institucion">
                        <h3>INSTITUTO TECNOLÓGICO<br>PUERTO DE MEJILLONES</h3>
                        <div class="lema">Organización al servicio de la humanidad</div>
                        <div class="sub">Fundado el 30 de abril de 1992 · Resolución Ministerial N° 296/92</div>
                    </div>
                </div>

                {{-- Texto legal --}}
                <div class="reverso-texto">
                    El titular de esta credencial es <strong>usuario registrado</strong> del Instituto Tecnológico Puerto de Mejillones. Agradecemos a todas las autoridades gubernamentales, judiciales, policiales y otros, prestar la colaboración requerida en caso necesario.
                </div>

                {{-- Firmas --}}
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
                <div class="reverso-firmas">
                    <div class="firma-box">
                        <div class="linea"></div>
                        <div class="nombre">Lic. Jimmy Ovidio Sirpa Choque</div>
                        <div class="cargo">Rector</div>
                    </div>

                    <div class="sello-central">
                        SELLO<br>OFICIAL
                    </div>

                    <div class="firma-box">
                        <div class="linea"></div>
                        <div class="nombre">Ing. Ana María Alvarez Tellez</div>
                        <div class="cargo">Directora Académica</div>
                    </div>
                </div>

<<<<<<< HEAD
                <div class="reverso-footer">
                    <span>📞 22810641 - 22816390</span>
                    <span>📍 Ciudad Satélite Plan 405</span>
=======
                {{-- Pie con contacto --}}
                <div class="reverso-footer">
                    <span>📞 Tel: 22810641 - 22816390</span>
                    <span>📍 Ciudad Satélite Plan 405, Av. Arturo Ballivian</span>
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
                </div>
            </div>
        </div>
    </div>

    {{-- Botón imprimir --}}
    <button class="btn-imprimir" onclick="window.print()">
        🖨️ Imprimir Credencial
    </button>

</body>
</html>
