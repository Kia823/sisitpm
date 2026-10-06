@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-4">

    {{-- ============ MENSAJES ============ --}}
    @if (session('success'))
        <div style="background:#dcfce7;border:1px solid #bbf7d0;color:#166534;padding:14px 20px;border-radius:12px;margin-bottom:20px;font-weight:700;">
            ✓ {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div style="background:#fee2e2;border:1px solid #fecaca;color:#991b1b;padding:14px 20px;border-radius:12px;margin-bottom:20px;font-weight:700;">
            ✗ {{ session('error') }}
        </div>
    @endif

    {{-- ============ ENCABEZADO ============ --}}
    <div style="background:linear-gradient(135deg,#2563eb 0%,#1d4ed8 100%);padding:30px;border-radius:16px;color:white;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:20px;margin-bottom:25px;box-shadow:0 10px 15px -3px rgba(37,99,235,.2);">
        <div>
            <span style="background:rgba(255,255,255,.2);padding:5px 12px;border-radius:20px;font-size:11px;font-weight:800;text-transform:uppercase;">
                Categorías
            </span>
            <h1 style="font-size:28px;font-weight:800;margin:8px 0 4px 0;">
                {{ isset($ambiente) ? 'Categorías del Ambiente' : 'Todas las Categorías' }}
            </h1>
            <p style="opacity:.9;font-size:14px;margin:0;">
                {{ isset($ambiente) ? $ambiente->nombre : 'Administra las categorías del sistema' }}
            </p>
        </div>

        <div style="display:flex;gap:12px;">
            <div style="background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.2);padding:14px 20px;border-radius:12px;text-align:center;min-width:110px;">
                <div style="font-size:24px;font-weight:800;">{{ $categorias->total() }}</div>
                <div style="font-size:11px;font-weight:700;opacity:.9;text-transform:uppercase;margin-top:4px;">Categorías</div>
            </div>
            <div style="background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.2);padding:14px 20px;border-radius:12px;text-align:center;min-width:110px;">
                <div style="font-size:24px;font-weight:800;">{{ $categorias->sum('activos_count') }}</div>
                <div style="font-size:11px;font-weight:700;opacity:.9;text-transform:uppercase;margin-top:4px;">Activos</div>
            </div>
        </div>
    </div>

    {{-- ============ FILTROS ============ --}}
    <div style="background:white;border-radius:12px;border:1px solid #e2e8f0;padding:16px 20px;margin-bottom:20px;display:flex;gap:14px;flex-wrap:wrap;align-items:flex-end;">
        <form method="GET" action="{{ route('categorias.index') }}" style="display:flex;gap:14px;flex-wrap:wrap;align-items:flex-end;flex:1;">
            <div style="min-width:250px;">
                <label style="font-size:12px;font-weight:700;display:block;margin-bottom:4px;color:#334155;">Filtrar por Ambiente</label>
                <select name="id_ambiente" onchange="this.form.submit()" style="width:100%;padding:9px 12px;border-radius:8px;border:1px solid #cbd5e1;background:#fff;">
                    <option value="">Todos los ambientes</option>
                    @foreach(\App\Models\Ambiente::with('carrera')->orderBy('nombre')->get() as $amb)
                        <option value="{{ $amb->id_ambiente }}" {{ request('id_ambiente') == $amb->id_ambiente ? 'selected' : '' }}>
                            {{ $amb->nombre }} ({{ $amb->carrera->nombre ?? 'Sin carrera' }})
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" style="background:#2563eb;color:white;border:none;padding:10px 20px;border-radius:8px;font-weight:700;cursor:pointer;">
                🔍 Filtrar
            </button>

            @if(request('id_ambiente'))
                <a href="{{ route('categorias.index') }}" style="background:#e2e8f0;color:#475569;padding:10px 16px;border-radius:8px;font-weight:700;text-decoration:none;font-size:13px;">
                    Limpiar
                </a>
            @endif
        </form>
    </div>

    {{-- ============ TABLA DE CATEGORÍAS ============ --}}
    <div style="background:white;border-radius:16px;border:1px solid #e2e8f0;padding:25px;box-shadow:0 4px 6px -1px rgba(0,0,0,.05);">
        <h3 style="font-size:18px;font-weight:800;color:#0f172a;margin:0 0 20px 0;">Listado de Categorías</h3>

        @if($categorias->count() > 0)
            <div style="overflow-x:auto;">
                <table style="width:100%;border-collapse:collapse;font-size:13px;">
                    <thead>
                        <tr style="background:#f1f5f9;color:#334155;text-transform:uppercase;font-size:11px;">
                            <th style="padding:10px;text-align:left;border-bottom:2px solid #cbd5e1;width:60px;">Nº</th>
                            <th style="padding:10px;text-align:left;border-bottom:2px solid #cbd5e1;width:120px;">Código</th>
                            <th style="padding:10px;text-align:left;border-bottom:2px solid #cbd5e1;">Nombre</th>
                            <th style="padding:10px;text-align:left;border-bottom:2px solid #cbd5e1;">Ambiente</th>
                            <th style="padding:10px;text-align:left;border-bottom:2px solid #cbd5e1;">Descripción</th>
                            <th style="padding:10px;text-align:center;border-bottom:2px solid #cbd5e1;width:90px;">Activos</th>
                            <th style="padding:10px;text-align:center;border-bottom:2px solid #cbd5e1;width:200px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categorias as $i => $cat)
                            <tr style="border-bottom:1px solid #e2e8f0;">
                                <td style="padding:12px;color:#64748b;font-weight:700;">{{ $categorias->firstItem() + $i }}</td>
                                <td style="padding:12px;">
                                    <span style="background:#eff6ff;color:#2563eb;font-weight:700;font-size:11px;padding:3px 8px;border-radius:6px;">
                                        {{ $cat->codigo }}
                                    </span>
                                </td>
                                <td style="padding:12px;font-weight:700;color:#0f172a;">
                                    {{ $cat->nombre }}
                                </td>
                                <td style="padding:12px;font-size:12px;color:#475569;">
                                    {{ $cat->ambiente->nombre ?? 'Sin ambiente' }}
                                </td>
                                <td style="padding:12px;font-size:12px;color:#64748b;max-width:300px;">
                                    {{ \Illuminate\Support\Str::limit($cat->descripcion, 80) ?? '—' }}
                                </td>
                                <td style="padding:12px;text-align:center;">
                                    <span style="background:#dcfce7;color:#166534;font-weight:700;font-size:12px;padding:4px 10px;border-radius:6px;">
                                        {{ $cat->activos_count ?? 0 }}
                                    </span>
                                </td>
                                <td style="padding:12px;text-align:center;">
                                    <div style="display:flex;gap:6px;justify-content:center;flex-wrap:wrap;">
                                        {{-- Ver activos de esta categoría --}}
                                        <a href="{{ route('categorias.show', $cat->id_categoria) }}"
                                           style="background:#2563eb;color:white;padding:6px 12px;border-radius:6px;font-size:11px;font-weight:700;text-decoration:none;">
                                            👁️ Ver
                                        </a>

                                        @if(auth()->check() && auth()->user()->esAdmin())
                                            {{-- Editar: por ahora solo enlace al ambiente --}}
                                            <a href="{{ route('ambientes.detalle', $cat->id_ambiente) }}"
                                               style="background:#fef9c3;color:#ca8a04;padding:6px 12px;border-radius:6px;font-size:11px;font-weight:700;text-decoration:none;">
                                                ✏️ Editar
                                            </a>

                                            {{-- Eliminar --}}
                                            <form method="POST"
                                                  action="{{ route('categorias.destroy', $cat->id_categoria) }}"
                                                  onsubmit="return confirm('¿Eliminar la categoría {{ $cat->nombre }}?');"
                                                  style="display:inline;margin:0;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        style="background:#fee2e2;color:#dc2626;border:none;padding:6px 12px;border-radius:6px;font-size:11px;font-weight:700;cursor:pointer;">
                                                    🗑️ Eliminar
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

            {{-- Paginación --}}
            @if($categorias->hasPages())
                <div style="margin-top:20px;">
                    {{ $categorias->links() }}
                </div>
            @endif
        @else
            <div style="text-align:center;padding:60px 20px;color:#94a3b8;font-weight:600;">
                <div style="font-size:48px;margin-bottom:12px;">📁</div>
                <h3 style="margin:0 0 6px 0;font-size:16px;color:#64748b;">No hay categorías registradas</h3>
                <p style="margin:0;font-size:13px;">Ve a un ambiente y crea categorías desde su panel.</p>
            </div>
        @endif
    </div>
</div>
@endsection
