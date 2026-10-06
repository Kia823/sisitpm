@extends('layouts.app')

@section('title', 'Actas de Baja')

@section('content')
<div class="container-fluid px-4 py-6">

    {{-- ENCABEZADO CORPORATIVO --}}
    <div style="background: linear-gradient(135deg, #7c2d12 0%, #9a3412 100%); padding: 30px; border-radius: 18px; color: white; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px; margin-bottom: 25px; box-shadow: 0 10px 20px -3px rgba(124, 45, 18, 0.25);">
        <div>
            <span style="background: rgba(255, 255, 255, 0.2); padding: 5px 12px; border-radius: 20px; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">Módulo Legal</span>
            <h1 style="font-size: 26px; font-weight: 800; margin: 8px 0 4px 0;">Actas de Baja de Activos</h1>
            <p style="opacity: 0.9; font-size: 14px; margin: 0;">Gestiona, revisa y exporta el historial de actas de baja institucional.</p>
        </div>
        <div>
            <a href="{{ route('actas.baja.create') }}"
               style="background: white; color: #7c2d12; padding: 12px 20px; border-radius: 12px; font-weight: 800; font-size: 13px; text-decoration: none; box-shadow: 0 4px 6px rgba(0,0,0,0.1); display: inline-flex; align-items: center; gap: 8px;">
                <span>➖</span> Nueva Baja
            </a>
        </div>
    </div>

    {{-- FILTROS Y BÚSQUEDA --}}
    <div style="background: white; border-radius: 16px; border: 1px solid #e2e8f0; padding: 20px; margin-bottom: 25px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);">
        <form method="GET" action="{{ route('actas.baja.index') }}" style="display: flex; gap: 15px; align-items: flex-end; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 220px;">
                <label style="display: block; font-size: 11px; font-weight: 800; color: #334155; margin-bottom: 6px; text-transform: uppercase;">Filtrar por Estado</label>
                <select name="estado" onchange="this.form.submit()" style="width: 100%; padding: 10px 14px; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 13px; color: #1e293b; outline: none; cursor: pointer;">
                    <option value="">Todos los estados</option>
                    <option value="PENDIENTE" {{ request('estado')=='PENDIENTE'?'selected':'' }}>Pendiente de aprobación</option>
                    <option value="APROBADA" {{ request('estado')=='APROBADA'?'selected':'' }}>Aprobada</option>
                    <option value="RECHAZADA" {{ request('estado')=='RECHAZADA'?'selected':'' }}>Rechazada</option>
                </select>
            </div>
        </form>
    </div>

    {{-- TABLA INSTITUCIONAL --}}
    <div style="background: white; border-radius: 16px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px;">
                <thead style="background: #f8fafc; color: #475569; text-transform: uppercase; font-size: 10px; letter-spacing: 0.5px; border-bottom: 1px solid #e2e8f0;">
                    <tr>
                        <th style="padding: 14px 16px;">Número</th>
                        <th style="padding: 14px 16px;">Fecha</th>
                        <th style="padding: 14px 16px;">Ambiente</th>
                        <th style="padding: 14px 16px; text-align: center;">Activos</th>
                        <th style="padding: 14px 16px;">Motivo</th>
                        <th style="padding: 14px 16px; text-align: center;">Estado</th>
                        <th style="padding: 14px 16px; text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tbody style="divide-y: #f1f5f9;">
                    @forelse($actas as $a)
                        <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='white'">
                            <td style="padding: 14px 16px; font-family: monospace; font-weight: 800; color: #7c2d12;">
                                <a href="{{ route('actas.baja.show', $a->id_acta_baja ?? $a->id) }}" style="color: #7c2d12; text-decoration: none;">{{ $a->numero_acta }}</a>
                            </td>
                            <td style="padding: 14px 16px; color: #334155; font-weight: 600;">
                                {{ optional($a->fecha_baja ?? $a->fecha_acta)->format('d/m/Y') ?? ($a->created_at?->format('d/m/Y') ?? '—') }}
                            </td>
                            <td style="padding: 14px 16px; color: #475569;">
                                {{ optional($a->ambiente)->nombre ?? '—' }}
                            </td>
                            <td style="padding: 14px 16px; text-align: center; font-weight: 700; color: #0f172a;">
                                {{ optional($a->activos)->count() ?? 0 }}
                            </td>
                            <td style="padding: 14px 16px; color: #475569; max-width: 280px;">
                                {{ \Illuminate\Support\Str::limit($a->motivo_baja ?? $a->motivo, 50) }}
                            </td>
                            <td style="padding: 14px 16px; text-align: center;">
                                @php
                                    $estiloEstado = match($a->estado ?? 'PENDIENTE') {
                                        'APROBADA' => 'background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0;',
                                        'RECHAZADA' => 'background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5;',
                                        default => 'background: #fef9c3; color: #854d0e; border: 1px solid #fde047;'
                                    };
                                @endphp
                                <span style="display: inline-block; padding: 4px 10px; border-radius: 6px; font-weight: 800; font-size: 10px; {{ $estiloEstado }}">
                                    {{ $a->estado_texto }}
                                </span>
                            </td>
                            <td style="padding: 14px 16px; text-align: center;">
                                <div style="display: flex; gap: 6px; justify-content: center; flex-wrap: wrap;">
                                    <a href="{{ route('actas.baja.show', $a->id_acta_baja ?? $a->id) }}"
                                       style="padding: 6px 12px; background: #eff6ff; color: #1d4ed8; border-radius: 8px; font-size: 11px; font-weight: 700; text-decoration: none;">
                                        👁️ Ver
                                    </a>
                                    @if($a->esAprobada())
                                        <a href="{{ route('actas.baja.pdf', $a->id_acta_baja ?? $a->id) }}" target="_blank"
                                           style="padding: 6px 12px; background: #fee2e2; color: #991b1b; border-radius: 8px; font-size: 11px; font-weight: 700; text-decoration: none;">
                                            📄 PDF
                                        </a>
                                    @endif
                                    @if($a->esPendiente() && auth()->user()->puedeAprobar())
                                        <form method="POST" action="{{ route('actas.baja.aprobar', $a->id_acta_baja ?? $a->id) }}" style="display:inline;">
                                            @csrf
                                            <button type="submit" style="padding: 6px 12px; background: #10b981; color: white; border: none; border-radius: 8px; font-size: 11px; font-weight: 700; cursor: pointer;">
                                                ✅ Aprobar
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('actas.baja.rechazar', $a->id_acta_baja ?? $a->id) }}" style="display:inline;">
                                            @csrf
                                            <button type="submit" style="padding: 6px 12px; background: #ef4444; color: white; border: none; border-radius: 8px; font-size: 11px; font-weight: 700; cursor: pointer;">
                                                ❌ Rechazar
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 50px 20px; color: #64748b; font-weight: 600;">
                                No hay actas de baja registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if(method_exists($actas, 'hasPages') && $actas->hasPages())
        <div style="margin-top: 20px;">{{ $actas->links() }}</div>
    @endif
</div>
@endsection
