<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
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
    </style>
</head>
<body>

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
            @endforelse
        </tbody>
    </table>

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
                </div>
            </td>
        </tr>
    </table>

    <div class="legal">
        <strong>IMPORTANTE:</strong> Como responsable del bien de uso, me comprometo a dar cumplimiento al D.S. 0181 Art. 116.
    </div>

</body>
</html>
