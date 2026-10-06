@extends('layouts.app')

@section('title', 'Inventario por Ambiente')

@section('content')
<div class="container-fluid px-4 py-6">
    <div style="max-width: 1200px; margin: 0 auto;">

        <a href="{{ route('reportes.index') }}"
           style="display: inline-flex; align-items: center; gap: 6px; color: #64748b; font-size: 13px; font-weight: 700; text-decoration: none; margin-bottom: 16px;">
            ← Volver a Reportes
        </a>

        {{-- ENCABEZADO --}}
        <div style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); padding: 25px 30px; border-radius: 16px; color: white; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px; margin-bottom: 25px; box-shadow: 0 10px 20px -3px rgba(15, 23, 42, 0.2);">
            <div>
                <span style="background: rgba(255, 255, 255, 0.15); padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">Reporte por Ambiente</span>
                <h1 style="font-size: 24px; font-weight: 800; margin: 6px 0 4px 0;">{{ $ambiente->nombre }}</h1>
                <p style="opacity: 0.85; font-size: 13px; margin: 0;">{{ optional($ambiente->carrera)->nombre ?? 'Sin carrera asociada' }} · <strong style="color: #fff;">{{ $activos->count() }}</strong> activos</p>
            </div>
            <div style="display: flex; gap: 10px;">
                <a href="{{ route('reportes.por.ambiente.pdf', $ambiente->id_ambiente) }}" target="_blank"
                   style="background: #dc2626; color: white; padding: 10px 16px; border-radius: 10px; font-size: 13px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 4px rgba(220, 38, 38, 0.2);">
                    📄 PDF
                </a>
                <a href="{{ route('reportes.por.ambiente.excel', $ambiente->id_ambiente) }}"
                   style="background: #059669; color: white; padding: 10px 16px; border-radius: 10px; font-size: 13px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 4px rgba(5, 150, 105, 0.2);">
                    📊 Excel
                </a>
            </div>
        </div>

        {{-- TABLA --}}
        <div style="background: white; border-radius: 16px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);">
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px;">
                    <thead style="background: #f8fafc; color: #475569; text-transform: uppercase; font-size: 10px; letter-spacing: 0.5px; border-bottom: 1px solid #e2e8f0;">
                        <tr>
                            <th style="padding: 14px 16px; width: 50px;">N°</th>
                            <th style="padding: 14px 16px;">Código</th>
                            <th style="padding: 14px 16px;">Descripción</th>
                            <th style="padding: 14px 16px; text-align: center;">Cant.</th>
                            <th style="padding: 14px 16px; text-align: center;">Estado</th>
                            <th style="padding: 14px 16px; text-align: center;">Fuente</th>
                            <th style="padding: 14px 16px; text-align: center;">Gestión</th>
                        </tr>
                    </thead>
                    <tbody style="divide-y: #f1f5f9;">
                        @forelse($agrupados as $i => $g)
                            <tr style="border-bottom: 1px solid #f1f5f9;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='white'">
                                <td style="padding: 14px 16px; color: #94a3b8; font-weight: 600; font-size: 12px;">{{ $i + 1 }}</td>
                                <td style="padding: 14px 16px; font-family: monospace; font-weight: 700; color: #334155; font-size: 12px;">{!! nl2br(e($g->codigos)) !!}</td>
                                <td style="padding: 14px 16px; font-weight: 700; color: #0f172a;">{{ $g->nombre }}</td>
                                <td style="padding: 14px 16px; text-align: center;">
                                    <span style="display: inline-block; padding: 4px 10px; background: #eff6ff; color: #1d4ed8; border-radius: 8px; font-weight: 800; font-size: 12px;">{{ $g->cantidad }}</span>
                                </td>
                                <td style="padding: 14px 16px; text-align: center;">
                                    <span style="display: inline-block; padding: 4px 10px; border-radius: 6px; font-weight: 800; font-size: 10px; background: #f1f5f9; color: #334155;">{{ $g->estado_texto }}</span>
                                </td>
                                <td style="padding: 14px 16px; text-align: center; font-size: 11px; font-weight: 700; color: #475569;">{{ $g->fuente_codigo }}</td>
                                <td style="padding: 14px 16px; text-align: center; font-weight: 700; color: #334155; font-size: 12px;">{{ $g->gestion }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="7" style="text-align: center; padding: 40px; color: #64748b; font-weight: 600;">Sin activos en este ambiente</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
