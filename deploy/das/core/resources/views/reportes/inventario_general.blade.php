@extends('layouts.app')

@section('title', 'Inventario General')

@section('content')
<div class="container-fluid px-4 py-6">
    <div style="max-width: 1200px; margin: 0 auto;">

        {{-- ENCABEZADO CORPORATIVO --}}
        <div style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); padding: 25px 30px; border-radius: 16px; color: white; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px; margin-bottom: 25px; box-shadow: 0 10px 20px -3px rgba(15, 23, 42, 0.2);">
            <div>
                <span style="background: rgba(255, 255, 255, 0.15); padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">Módulo de Reportes</span>
                <h1 style="font-size: 24px; font-weight: 800; margin: 6px 0 4px 0;">Inventario General</h1>
                <p style="opacity: 0.85; font-size: 13px; margin: 0;">
                    <strong style="color: #fff;">{{ isset($agrupados) ? $agrupados->count() : 0 }}</strong> grupos ·
                    <strong style="color: #fff;">{{ isset($activos) ? $activos->count() : 0 }}</strong> activos totales
                </p>
            </div>
            <div style="display: flex; gap: 10px;">
                <a href="{{ route('reportes.inventario.general.pdf', ['tipo_bien' => $tipoBien ?? 'TODOS']) }}" target="_blank"
                   style="background: #dc2626; color: white; padding: 10px 16px; border-radius: 10px; font-size: 13px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 4px rgba(220, 38, 38, 0.2);">
                    📄 PDF
                </a>
                <a href="{{ route('reportes.inventario.general.excel', ['tipo_bien' => $tipoBien ?? 'TODOS']) }}"
                   style="background: #059669; color: white; padding: 10px 16px; border-radius: 10px; font-size: 13px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 4px rgba(5, 150, 105, 0.2);">
                    📊 Excel
                </a>
            </div>
        </div>

        {{-- FILTRO POR TIPO DE BIEN --}}
        @php
            $tipoActual = $tipoBien ?? 'TODOS';
            $opcionesTipo = [
                'TODOS'       => 'Todos',
                'ACTIVO_FIJO' => 'Solo activos fijos',
                'NO_ACTIVO'   => 'Solo no activos',
            ];
        @endphp
        <div style="display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 20px;">
            @foreach ($opcionesTipo as $valor => $etiqueta)
                <a href="{{ route('reportes.inventario.general', ['tipo_bien' => $valor]) }}"
                   style="padding:8px 14px;border-radius:9px;font-size:13px;font-weight:800;text-decoration:none;border:1.5px solid {{ $tipoActual === $valor ? '#2563eb' : '#cbd5e1' }};background:{{ $tipoActual === $valor ? '#2563eb' : '#fff' }};color:{{ $tipoActual === $valor ? '#fff' : '#475569' }};">
                    {{ $etiqueta }}
                </a>
            @endforeach
        </div>

        {{-- MINI ESTADÍSTICAS --}}
        @php
            $stats = [
                'B'  => isset($activos) ? $activos->where('estado_fisico', 'B')->count() : 0,
                'R'  => isset($activos) ? $activos->where('estado_fisico', 'R')->count() : 0,
                'M'  => isset($activos) ? $activos->where('estado_fisico', 'M')->count() : 0,
                'FF' => isset($activos) ? $activos->where('estado_fisico', 'FF')->count() : 0,
            ];
        @endphp

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 20px;">
            <div style="background: #ecfdf5; border: 1px solid #a7f3d0; padding: 14px 18px; border-radius: 12px; display: flex; align-items: center; gap: 12px;">
                <span style="background: #d1fae5; color: #065f46; padding: 6px 10px; border-radius: 8px; font-weight: 800; font-size: 13px;">{{ $stats['B'] }}</span>
                <span style="font-size: 12px; font-weight: 800; color: #065f46; text-transform: uppercase;">Buenos</span>
            </div>
            <div style="background: #fefce8; border: 1px solid #fde047; padding: 14px 18px; border-radius: 12px; display: flex; align-items: center; gap: 12px;">
                <span style="background: #fef08a; color: #854d0e; padding: 6px 10px; border-radius: 8px; font-weight: 800; font-size: 13px;">{{ $stats['R'] }}</span>
                <span style="font-size: 12px; font-weight: 800; color: #854d0e; text-transform: uppercase;">Regulares</span>
            </div>
            <div style="background: #fff7ed; border: 1px solid #fed7aa; padding: 14px 18px; border-radius: 12px; display: flex; align-items: center; gap: 12px;">
                <span style="background: #ffedd5; color: #9a3412; padding: 6px 10px; border-radius: 8px; font-weight: 800; font-size: 13px;">{{ $stats['M'] }}</span>
                <span style="font-size: 12px; font-weight: 800; color: #9a3412; text-transform: uppercase;">Malos</span>
            </div>
            <div style="background: #fef2f2; border: 1px solid #fecaca; padding: 14px 18px; border-radius: 12px; display: flex; align-items: center; gap: 12px;">
                <span style="background: #fee2e2; color: #991b1b; padding: 6px 10px; border-radius: 8px; font-weight: 800; font-size: 13px;">{{ $stats['FF'] }}</span>
                <span style="font-size: 12px; font-weight: 800; color: #991b1b; text-transform: uppercase;">Fuera de Serv.</span>
            </div>
        </div>

        {{-- BARRA DE BÚSQUEDA --}}
        <div style="background: white; border-radius: 14px; border: 1px solid #e2e8f0; padding: 15px 20px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.01);">
            <div style="display: flex; align-items: center; gap: 15px;">
                <input type="text" id="buscarInput" placeholder="🔍  Buscar por código, descripción, marca o modelo..."
                       style="width: 100%; padding: 10px 14px; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 13px; outline: none;">
                <span style="font-size: 12px; font-weight: 700; color: #64748b; white-space: nowrap;">
                    Mostrando <span id="contadorVisibles">{{ isset($agrupados) ? $agrupados->count() : 0 }}</span> registros
                </span>
            </div>
        </div>

        {{-- TABLA PRINCIPAL --}}
        <div style="background: white; border-radius: 16px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02); margin-bottom: 25px;">
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px;">
                    <thead style="background: #f8fafc; color: #475569; text-transform: uppercase; font-size: 10px; letter-spacing: 0.5px; border-bottom: 1px solid #e2e8f0;">
                        <tr>
                            <th style="padding: 14px 16px; width: 50px;">N°</th>
                            <th style="padding: 14px 16px;">Código</th>
                            <th style="padding: 14px 16px; text-align: center;">Tipo</th>
                            <th style="padding: 14px 16px;">Descripción</th>
                            <th style="padding: 14px 16px;">Características</th>
                            <th style="padding: 14px 16px; text-align: center;">Cant.</th>
                            <th style="padding: 14px 16px; text-align: center;">Estado</th>
                            <th style="padding: 14px 16px; text-align: center;">Fuente</th>
                            <th style="padding: 14px 16px; text-align: center;">Gestión</th>
                        </tr>
                    </thead>
                    <tbody style="divide-y: #f1f5f9;" id="tbodyInventario">
                        @forelse($agrupados ?? [] as $i => $g)
                            <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s;" class="fila-activo"
                                data-search="{{ strtolower(($g->codigos ?? '') . ' ' . ($g->nombre ?? '') . ' ' . ($g->marca ?? '') . ' ' . ($g->modelo ?? '')) }}"
                                onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='white'">
                                <td style="padding: 14px 16px; color: #94a3b8; font-weight: 600; font-size: 12px;">{{ $i + 1 }}</td>
                                <td style="padding: 14px 16px; font-family: monospace; font-weight: 700; color: #334155; font-size: 12px;">
                                    {{ $g->codigos ?? '—' }}
                                </td>
                                <td style="padding: 14px 16px; text-align: center;">
                                    @php $esNoActivo = ($g->tipo_bien ?? 'ACTIVO_FIJO') === 'NO_ACTIVO'; @endphp
                                    <span style="padding: 4px 8px; border-radius: 6px; font-size: 10px; font-weight: 800; {{ $esNoActivo ? 'background:#fef3c7;color:#92400e;border:1px solid #fde68a;' : 'background:#dbeafe;color:#1e40af;border:1px solid #bfdbfe;' }}">
                                        {{ $g->tipo_bien_texto ?? 'Activo fijo' }}
                                    </span>
                                </td>
                                <td style="padding: 14px 16px;">
                                    <div style="font-weight: 700; color: #0f172a;">{{ $g->nombre ?? '—' }}</div>
                                    @if(($g->marca ?? null) || ($g->modelo ?? null))
                                        <div style="font-size: 11px; color: #64748b; margin-top: 2px;">
                                            {{ $g->marca ?? '' }} {{ $g->modelo ?? '' }}
                                        </div>
                                    @endif
                                </td>
                                <td style="padding: 14px 16px; color: #64748b; font-size: 12px;">
                                    {{ $g->marca ?? 'Especificación estándar' }}
                                </td>
                                <td style="padding: 14px 16px; text-align: center;">
                                    <span style="display: inline-block; padding: 4px 10px; background: #eff6ff; color: #1d4ed8; border-radius: 8px; font-weight: 800; font-size: 12px;">
                                        {{ $g->cantidad ?? 0 }}
                                    </span>
                                </td>
                                <td style="padding: 14px 16px; text-align: center;">
                                    @php
                                        $colorEstado = match($g->estado_fisico ?? 'B') {
                                            'B'  => 'background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0;',
                                            'R'  => 'background: #fef9c3; color: #854d0e; border: 1px solid #fde047;',
                                            'M'  => 'background: #ffedd5; color: #9a3412; border: 1px solid #fed7aa;',
                                            'FF' => 'background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5;',
                                            default => 'background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1;',
                                        };
                                    @endphp
                                    <span style="display: inline-block; padding: 4px 10px; border-radius: 6px; font-weight: 800; font-size: 10px; {{ $colorEstado }}">
                                        {{ $g->estado_texto ?? 'BUENO' }}
                                    </span>
                                </td>
                                <td style="padding: 14px 16px; text-align: center;">
                                    <span style="background: #f1f5f9; color: #475569; padding: 4px 8px; border-radius: 6px; font-size: 11px; font-weight: 700;">
                                        {{ $g->fuente_codigo ?? 'ADQ' }}
                                    </span>
                                </td>
                                <td style="padding: 14px 16px; text-align: center; color: #334155; font-weight: 700; font-size: 12px;">
                                    {{ $g->gestion ?? date('Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" style="text-align: center; padding: 40px; color: #64748b; font-weight: 600;">
                                    No hay activos registrados en el inventario general.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- LEYENDA --}}
        <div style="background: white; border-radius: 14px; border: 1px solid #e2e8f0; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.01);">
            <h4 style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase; margin-bottom: 10px; letter-spacing: 0.5px;">Leyenda del Sistema</h4>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 10px; font-size: 12px; color: #334155;">
                <div><strong>B</strong> = Bueno</div>
                <div><strong>R</strong> = Regular</div>
                <div><strong>M</strong> = Malo</div>
                <div><strong>FF</strong> = Fuera de Funcionamiento</div>
                <div><strong>P</strong> = Propio</div>
                <div><strong>GD</strong> = Gob. Departamental</div>
                <div><strong>ADQ</strong> = Adquisición</div>
                <div><strong>OTR</strong> = Otros</div>
            </div>
        </div>

    </div>
</div>

{{-- SCRIPT DE BÚSQUEDA EN TIEMPO REAL --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('buscarInput');
    const filas = document.querySelectorAll('.fila-activo');
    const contador = document.getElementById('contadorVisibles');

    if (!input) return;

    input.addEventListener('input', function(e) {
        const q = e.target.value.toLowerCase().trim();
        let visibles = 0;

        filas.forEach(fila => {
            const texto = fila.dataset.search || '';
            const coincide = !q || texto.includes(q);

            fila.style.display = coincide ? '' : 'none';
            if (coincide) visibles++;
        });

        if (contador) contador.textContent = visibles;
    });
});
</script>
@endsection
