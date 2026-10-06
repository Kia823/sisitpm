@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-4">

    {{-- ⭐ BREADCRUMB CON PROTECCIÓN DE VARIABLES --}}
    <div style="background:white;padding:12px 20px;border-radius:12px;margin-bottom:20px;display:flex;align-items:center;gap:8px;font-size:13px;box-shadow:0 2px 4px rgba(0,0,0,.04);border:1px solid #e2e8f0;flex-wrap:wrap;">
        <a href="{{ isset($carrera) ? route('carreras.show', $carrera->id_carrera) : '#' }}" style="color:#2563eb;text-decoration:none;font-weight:700;">
            🎓 {{ $carrera->nombre ?? 'Carrera' }}
        </a>
        <span style="color:#94a3b8;">/</span>
        <a href="{{ isset($ambiente) ? route('ambientes.detalle', $ambiente->id_ambiente) : '#' }}" style="color:#2563eb;text-decoration:none;font-weight:700;">
            🏢 {{ $ambiente->nombre ?? 'Ambiente' }}
        </a>
        <span style="color:#94a3b8;">/</span>
        <a href="{{ isset($categoria) ? route('categorias.show', $categoria->id_categoria) : '#' }}" style="color:#2563eb;text-decoration:none;font-weight:700;">
            📁 {{ $categoria->nombre ?? 'Categoría' }}
        </a>
        <span style="color:#94a3b8;">/</span>
        <span style="color:#0f172a;font-weight:700;">📦 {{ $nombreDecoded ?? 'Grupo' }}</span>
    </div>

    {{-- ============ ENCABEZADO ============ --}}
    <div style="background:linear-gradient(135deg,#0f766e 0%,#0d9488 100%);padding:28px;border-radius:16px;color:white;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:20px;margin-bottom:24px;box-shadow:0 10px 15px -3px rgba(15,118,110,.2);">
        <div style="flex:1;min-width:280px;">
            <span style="background:rgba(255,255,255,.2);padding:5px 12px;border-radius:20px;font-size:11px;font-weight:800;text-transform:uppercase;">
                Grupo de activos
            </span>
            <h1 style="font-size:28px;font-weight:800;margin:8px 0 4px 0;">{{ $nombreDecoded ?? 'Grupo' }}</h1>
            <p style="opacity:.9;font-size:14px;margin:0;">
                Activos individuales de este grupo dentro de <strong>{{ $categoria->nombre ?? '' }}</strong>
            </p>

            <div style="display:flex;gap:10px;flex-wrap:wrap;margin-top:16px;">
                @if(isset($categoria))
                    <a href="{{ route('categorias.show', $categoria->id_categoria) }}"
                       style="background:rgba(255,255,255,.2);color:white;padding:10px 18px;border-radius:10px;font-weight:700;text-decoration:none;font-size:14px;display:inline-flex;align-items:center;gap:6px;">
                        ← Volver a la categoría
                    </a>
                @endif

                @if(auth()->check() && auth()->user()->esAdmin() && isset($ambiente))
                    <a href="{{ route('activos.create', ['id_ambiente' => $ambiente->id_ambiente]) }}"
                       style="background:#10b981;color:white;padding:10px 18px;border-radius:10px;font-weight:700;text-decoration:none;font-size:14px;display:inline-flex;align-items:center;gap:6px;">
                        ➕ Nuevo Activo
                    </a>
                @endif
            </div>
        </div>

        <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:12px;width:380px;flex-shrink:0;">
            <div style="background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.2);padding:18px 12px;border-radius:12px;text-align:center;">
                <div style="font-size:24px;font-weight:800;">{{ $totalActivos ?? 0 }}</div>
                <div style="font-size:11px;font-weight:700;opacity:.9;text-transform:uppercase;margin-top:4px;">Total</div>
            </div>
            <div style="background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.2);padding:18px 12px;border-radius:12px;text-align:center;">
                <div style="font-size:24px;font-weight:800;color:#86efac;">{{ $totalBuenos ?? 0 }}</div>
                <div style="font-size:11px;font-weight:700;opacity:.9;text-transform:uppercase;margin-top:4px;">Buenos</div>
            </div>
            <div style="background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.2);padding:18px 12px;border-radius:12px;text-align:center;">
                <div style="font-size:24px;font-weight:800;color:#fde047;">{{ $totalRegulares ?? 0 }}</div>
                <div style="font-size:11px;font-weight:700;opacity:.9;text-transform:uppercase;margin-top:4px;">Regulares</div>
            </div>
            <div style="background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.2);padding:18px 12px;border-radius:12px;text-align:center;">
                <div style="font-size:24px;font-weight:800;color:#fca5a5;">{{ $totalMalos ?? 0 }}</div>
                <div style="font-size:11px;font-weight:700;opacity:.9;text-transform:uppercase;margin-top:4px;">Malos/F.F.</div>
            </div>
        </div>
    </div>

    {{-- ============ LISTADO DE ACTIVOS INDIVIDUALES ============ --}}
    <div style="background:white;border-radius:16px;border:1px solid #e2e8f0;padding:25px;box-shadow:0 4px 6px -1px rgba(0,0,0,.05);">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;flex-wrap:wrap;gap:12px;">
            <h3 style="font-size:18px;font-weight:800;color:#0f172a;margin:0;">
                📦 Activos individuales ({{ $totalActivos ?? 0 }})
            </h3>
        </div>

        @if(isset($activos) && $activos->count() > 0)
            <div style="overflow-x:auto;">
                <table style="width:100%;border-collapse:collapse;font-size:13px;table-layout:fixed;">
                    <thead>
                        <tr style="background:#f1f5f9;color:#334155;text-transform:uppercase;font-size:11px;">
                            <th style="padding:12px 6px;text-align:center;width:38px;">Nº</th>
                            <th style="padding:12px 6px;text-align:center;width:55px;">QR</th>
                            <th style="padding:12px 6px;text-align:center;width:55px;">IMAGEN</th>
                            <th style="padding:12px 6px;text-align:left;width:110px;">CÓDIGO</th>
                            <th style="padding:12px 6px;text-align:left;">CARACTERÍSTICAS</th>
                            <th style="padding:12px 6px;text-align:left;width:130px;">CUSTODIO</th>
                            <th style="padding:12px 6px;text-align:center;width:80px;">ESTADO</th>
                            <th style="padding:12px 6px;text-align:center;width:240px;">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($activos as $i => $a)
                            <tr style="border-bottom:1px solid #e2e8f0;">
                                <td style="padding:12px 6px;text-align:center;color:#64748b;font-weight:700;vertical-align:middle;">{{ $i + 1 }}</td>

                                {{-- QR --}}
                                <td style="padding:12px 6px;text-align:center;vertical-align:middle;">
                                    @if($a->ruta_qr)
                                        <img src="{{ asset('storage/' . $a->ruta_qr) }}" alt="QR"
                                             style="width:38px;height:38px;object-fit:contain;display:block;margin:0 auto;">
                                    @else
                                        <span style="font-size:10px;color:#94a3b8;">Sin QR</span>
                                    @endif
                                </td>

                                {{-- IMAGEN --}}
                                <td style="padding:12px 6px;text-align:center;vertical-align:middle;">
                                    @if($a->imagen)
                                        <img src="{{ asset('storage/' . $a->imagen) }}" alt="Foto"
                                             style="width:38px;height:38px;object-fit:cover;border-radius:6px;border:1px solid #e2e8f0;display:block;margin:0 auto;">
                                    @else
                                        <span style="font-size:10px;color:#94a3b8;font-style:italic;">Sin foto</span>
                                    @endif
                                </td>

                                {{-- CÓDIGO --}}
                                <td style="padding:12px 6px;vertical-align:middle;word-break:break-word;">
                                    <div style="font-weight:800;color:#0f172a;font-size:12px;">{{ $a->codigo_activo }}</div>
                                    <div style="font-size:10px;color:#64748b;">Serie: {{ $a->numero_serie ?? 'S/N' }}</div>
                                </td>

                                {{-- CARACTERÍSTICAS --}}
                                <td style="padding:12px 6px;vertical-align:middle;word-break:break-word;">
                                    <div style="font-weight:700;color:#0f172a;font-size:12px;">{{ $a->nombre }}</div>
                                    <div style="font-size:10px;color:#64748b;">
                                        {{ $a->marca }} {{ $a->modelo }}
                                        @if($a->descripcion)
                                            · {{ \Illuminate\Support\Str::limit($a->descripcion, 30) }}
                                        @endif
                                    </div>
                                </td>

                                {{-- CUSTODIO --}}
                                <td style="padding:12px 6px;vertical-align:middle;word-break:break-word;">
                                    <div style="font-size:11px;color:#0f172a;font-weight:700;">
                                        {{ $a->custodio->nombre_completo ?? 'Sin asignar' }}
                                    </div>
                                    <div style="font-size:10px;color:#64748b;">
                                        {{ $a->fuente->codigo ?? '' }}
                                    </div>
                                </td>

                                {{-- ESTADO --}}
                                <td style="padding:12px 6px;text-align:center;vertical-align:middle;">
                                    @php
                                        $badge = match($a->estado_fisico) {
                                            'B'  => ['bg' => '#dcfce7', 'color' => '#166534', 'texto' => 'BUENO'],
                                            'R'  => ['bg' => '#fef3c7', 'color' => '#92400e', 'texto' => 'REGULAR'],
                                            'M'  => ['bg' => '#fee2e2', 'color' => '#991b1b', 'texto' => 'MALO'],
                                            'FF' => ['bg' => '#6b7280', 'color' => 'white',   'texto' => 'F.F.'],
                                            default => ['bg' => '#f1f5f9', 'color' => '#475569', 'texto' => '—'],
                                        };
                                    @endphp
                                    <span style="background:{{ $badge['bg'] }};color:{{ $badge['color'] }};padding:2px 6px;border-radius:6px;font-weight:700;font-size:10px;display:inline-block;">
                                        {{ $badge['texto'] }}
                                    </span>
                                    <div style="font-size:9px;color:#64748b;margin-top:3px;">
                                        {{ $a->fecha_adquisicion ? $a->fecha_adquisicion->format('d/m/Y') : '' }}
                                    </div>
                                </td>

                                {{-- ACCIONES --}}
                                <td style="padding:12px 6px;text-align:center;vertical-align:middle;">
                                    <div style="display:flex;gap:3px;justify-content:center;align-items:center;flex-wrap:nowrap;">
                                        {{-- Ver tarjeta --}}
                                        <a href="{{ route('activos.tarjeta', $a->id_activo) }}" target="_blank"
                                           title="Ver tarjeta"
                                           style="width:26px;height:26px;background:#eff6ff;color:#2563eb;border:1px solid #bfdbfe;border-radius:6px;display:inline-flex;align-items:center;justify-content:center;text-decoration:none;font-size:11px;">
                                            👁️
                                        </a>

                                        {{-- Editar --}}
                                        @if(auth()->check() && auth()->user()->esAdmin())
                                            <a href="{{ route('activos.edit', $a->id_activo) }}"
                                               title="Editar"
                                               style="width:26px;height:26px;background:#fef9c3;color:#ca8a04;border:1px solid #fde047;border-radius:6px;display:inline-flex;align-items:center;justify-content:center;text-decoration:none;font-size:11px;">
                                                ✏️
                                            </a>
                                        @endif

                                        {{-- Descargar QR --}}
                                        <a href="{{ route('activos.descargar_qr', $a->id_activo) }}"
                                           title="Descargar QR"
                                           style="width:26px;height:26px;background:#f3e8ff;color:#7c3aed;border:1px solid #ddd6fe;border-radius:6px;display:inline-flex;align-items:center;justify-content:center;text-decoration:none;font-size:11px;">
                                            ⬇️
                                        </a>

                                        {{-- Etiqueta --}}
                                        <a href="{{ route('activos.etiqueta', $a->id_activo) }}" target="_blank"
                                           title="Ver etiqueta imprimible"
                                           style="width:26px;height:26px;background:#fef3c7;color:#f59e0b;border:1px solid #fde68a;border-radius:6px;display:inline-flex;align-items:center;justify-content:center;text-decoration:none;font-size:11px;">
                                            🏷️
                                        </a>

                                        {{-- 📋 Acta de Alta (PDF) --}}
                                        <a href="{{ route('actas.alta.pdf', $a->id_activo) }}" target="_blank"
                                           title="Ver Acta de Alta en PDF"
                                           style="width:26px;height:26px;background:#d1fae5;color:#059669;border:1px solid #a7f3d0;border-radius:6px;display:inline-flex;align-items:center;justify-content:center;text-decoration:none;font-size:11px;">
                                            📋
                                        </a>

                                        {{-- Ficha PDF --}}
                                        <a href="{{ route('activos.tarjeta.pdf', $a->id_activo) }}" target="_blank"
                                           title="Ficha en PDF"
                                           style="width:26px;height:26px;background:#fee2e2;color:#dc2626;border:1px solid #fecaca;border-radius:6px;display:inline-flex;align-items:center;justify-content:center;text-decoration:none;font-size:11px;">
                                            📄
                                        </a>

                                        {{-- Eliminar --}}
                                        @if(auth()->check() && auth()->user()->esAdmin())
                                            <form method="POST" action="{{ route('activos.destroy', $a->id_activo) }}"
                                                  onsubmit="return confirm('¿Eliminar el activo {{ $a->codigo_activo }}?')"
                                                  style="display:inline;margin:0;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" title="Eliminar"
                                                        style="width:26px;height:26px;background:#dc2626;color:white;border:1px solid #b91c1c;border-radius:6px;display:inline-flex;align-items:center;justify-content:center;cursor:pointer;font-size:11px;">
                                                    🗑️
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div style="text-align:center;padding:60px 20px;color:#94a3b8;font-weight:600;">
                <div style="font-size:48px;margin-bottom:12px;">📦</div>
                <h3 style="margin:0 0 6px 0;font-size:16px;color:#64748b;">No hay activos en este grupo</h3>
                <p style="margin:0;font-size:13px;">Registra un activo nuevo para comenzar.</p>
            </div>
        @endif
    </div>
</div>
@endsection
