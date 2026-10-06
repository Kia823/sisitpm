@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-4">

    {{-- ⭐ MENSAJES --}}
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

    {{-- ============ ENCABEZADO ÚNICO DEL AMBIENTE ============ --}}
    <div style="background:linear-gradient(135deg,#2563eb 0%,#1d4ed8 100%);padding:30px;border-radius:16px;color:white;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:20px;margin-bottom:25px;box-shadow:0 10px 15px -3px rgba(37,99,235,.2);">

        <div style="flex:1;min-width:280px;">
            <span style="background:rgba(255,255,255,.2);padding:5px 12px;border-radius:20px;font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:.08em;">
                Ambiente
            </span>
            <h1 style="font-size:28px;font-weight:800;margin:10px 0 6px 0;">
                {{ $ambiente->nombre }}
                <span style="font-weight:400;opacity:.8;">({{ $ambiente->codigo }})</span>
            </h1>
            <p style="opacity:.9;font-size:14px;margin:0 0 18px 0;">
                Administra las categorías y activos de este espacio.
            </p>


        </div>

        {{-- MÉTRICAS --}}
        <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:12px;width:380px;flex-shrink:0;">
            <div style="background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.2);padding:18px 12px;border-radius:12px;text-align:center;">
                <div style="font-size:24px;font-weight:800;">{{ $categorias->count() ?? 0 }}</div>
                <div style="font-size:11px;font-weight:700;opacity:.9;text-transform:uppercase;margin-top:4px;">Categorías</div>
            </div>
            <div style="background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.2);padding:18px 12px;border-radius:12px;text-align:center;">
                <div style="font-size:24px;font-weight:800;">{{ $categorias->sum(fn($c) => $c->activos_count ?? 0) }}</div>
                <div style="font-size:11px;font-weight:700;opacity:.9;text-transform:uppercase;margin-top:4px;">Activos</div>
            </div>
            <div style="background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.2);padding:18px 12px;border-radius:12px;text-align:center;">
                <div style="font-size:24px;font-weight:800;">{{ $ambiente->bloque ?? '—' }}</div>
                <div style="font-size:11px;font-weight:700;opacity:.9;text-transform:uppercase;margin-top:4px;">Bloque</div>
            </div>
            <div style="background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.2);padding:18px 12px;border-radius:12px;text-align:center;">
                <div style="font-size:24px;font-weight:800;">{{ $ambiente->piso ?? '—' }}</div>
                <div style="font-size:11px;font-weight:700;opacity:.9;text-transform:uppercase;margin-top:4px;">Piso</div>
            </div>
        </div>
    </div>

    {{-- ============ ACTIVOS VS NO ACTIVOS ============ --}}
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px;">

        {{-- ACTIVOS FIJOS --}}
        <div style="background:#eff6ff;border:2px solid #bfdbfe;border-radius:16px;padding:20px;">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:12px;margin-bottom:12px;">
                <div>
                    <h3 style="font-size:16px;font-weight:800;color:#1d4ed8;margin:0;">📦 Activos fijos</h3>
                    <p style="font-size:12px;color:#475569;margin:3px 0 0;">
                        Se capitalizan: equipos, máquinas, endblocklos.
                    </p>
                </div>
                <span style="background:#2563eb;color:#fff;padding:6px 14px;border-radius:12px;font-size:18px;font-weight:800;flex-shrink:0;">
                    {{ $totales['ACTIVO_FIJO'] }}
                </span>
            </div>

            @forelse($activosFijos as $a)
                <div style="display:flex;justify-content:space-between;gap:10px;padding:8px 10px;background:#fff;border-radius:9px;margin-bottom:6px;font-size:12px;">
                    <span style="color:#0f172a;font-weight:600;">{{ $a->nombre }}</span>
                    <span style="color:#64748b;font-family:ui-monospace,monospace;font-size:11px;">{{ $a->codigo_activo }}</span>
                </div>
            @empty
                <p style="font-size:12px;color:#64748b;font-style:italic;margin:8px 0 0;">
                    Este ambiente no tiene activos fijos registrados.
                </p>
            @endforelse

            <a href="{{ route('activos.index', ['id_ambiente' => $ambiente->id_ambiente, 'tipo_bien' => 'ACTIVO_FIJO']) }}"
               style="display:block;text-align:center;margin-top:12px;background:#2563eb;color:#fff;padding:9px;border-radius:9px;font-weight:800;font-size:13px;text-decoration:none;">
                Ver solo activos fijos
            </a>
        </div>

        {{-- NO ACTIVOS --}}
        <div style="background:#fffbeb;border:2px solid #fde68a;border-radius:16px;padding:20px;">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:12px;margin-bottom:12px;">
                <div>
                    <h3 style="font-size:16px;font-weight:800;color:#b45309;margin:0;">🧹 No activos</h3>
                    <p style="font-size:12px;color:#475569;margin:3px 0 0;">
                        Se inventarían pero no se capitalizan: escobas, papeleras, engrampadoras.
                    </p>
                </div>
                <span style="background:#f59e0b;color:#fff;padding:6px 14px;border-radius:12px;font-size:18px;font-weight:800;flex-shrink:0;">
                    {{ $totales['NO_ACTIVO'] }}
                </span>
            </div>

            @forelse($noActivos as $a)
                <div style="display:flex;justify-content:space-between;gap:10px;padding:8px 10px;background:#fff;border-radius:9px;margin-bottom:6px;font-size:12px;">
                    <span style="color:#0f172a;font-weight:600;">{{ $a->nombre }}</span>
                    <span style="color:#64748b;font-family:ui-monospace,monospace;font-size:11px;">{{ $a->codigo_activo }}</span>
                </div>
            @empty
                <p style="font-size:12px;color:#64748b;font-style:italic;margin:8px 0 0;">
                    Este ambiente todavía no tiene no activos registrados.
                </p>
            @endforelse

            @if(auth()->check() && auth()->user()->esAdmin())
                <a href="{{ route('activos.create', ['id_ambiente' => $ambiente->id_ambiente]) }}"
                   style="display:block;text-align:center;margin-top:12px;background:#f59e0b;color:#fff;padding:9px;border-radius:9px;font-weight:800;font-size:13px;text-decoration:none;">
                    + Registrar un no activo
                </a>
            @else
                <a href="{{ route('activos.index', ['id_ambiente' => $ambiente->id_ambiente, 'tipo_bien' => 'NO_ACTIVO']) }}"
                   style="display:block;text-align:center;margin-top:12px;background:#f59e0b;color:#fff;padding:9px;border-radius:9px;font-weight:800;font-size:13px;text-decoration:none;">
                    Ver solo no activos
                </a>
            @endif
        </div>
    </div>

    {{-- ============ LISTADO DE CATEGORÍAS ============ --}}
    <div style="background:white;border-radius:16px;border:1px solid #e2e8f0;padding:25px;box-shadow:0 4px 6px -1px rgba(0,0,0,.05);">

        {{-- Encabezado de la sección --}}
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;flex-wrap:wrap;gap:12px;">
            <div>
                <h3 style="font-size:18px;font-weight:800;color:#0f172a;margin:0;display:flex;align-items:center;gap:8px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                    </svg>
                    Categorías en este Ambiente
                </h3>
                <p style="font-size:13px;color:#64748b;margin:4px 0 0 0;">
                    Visualiza, edita o elimina las categorías de este espacio.
                </p>
            </div>

            {{-- ❌ Sin botón duplicado aquí --}}
        </div>

        @if(isset($categorias) && $categorias->count() > 0)
            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:16px;">

                @foreach($categorias as $cat)
                    <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:14px;padding:20px;display:flex;flex-direction:column;justify-content:space-between;box-shadow:0 2px 4px rgba(0,0,0,.02);transition:all .2s ease;"
                         onmouseover="this.style.borderColor='#2563eb'; this.style.boxShadow='0 8px 16px rgba(37,99,235,.1)';"
                         onmouseout="this.style.borderColor='#e2e8f0'; this.style.boxShadow='0 2px 4px rgba(0,0,0,.02)';">

                        {{-- Header de la tarjeta --}}
                        <div>
                            <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:10px;gap:10px;">
                                <div style="flex:1;min-width:0;">
                                    <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
                                        <h4 style="font-size:16px;font-weight:800;color:#0f172a;margin:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                            {{ $cat->nombre }}
                                        </h4>
                                        <span style="background:#eff6ff;color:#2563eb;font-size:10px;font-weight:800;padding:2px 8px;border-radius:6px;text-transform:uppercase;">
                                            {{ $cat->codigo }}
                                        </span>
                                    </div>

                                    <p style="font-size:12px;color:#64748b;margin:6px 0 0 0;line-height:1.4;">
                                        {{ $cat->descripcion ?? 'Sin descripción registrada.' }}
                                    </p>
                                </div>

                                {{-- ⭐ Badge de cantidad: activos fijos y no activos --}}
                                <div style="display:flex;flex-direction:column;gap:5px;flex-shrink:0;min-width:66px;">
                                    <div style="background:#eff6ff;color:#1d4ed8;padding:6px 10px;border-radius:10px;text-align:center;">
                                        <div style="font-size:18px;font-weight:800;line-height:1;">{{ $cat->activos_fijos_count ?? 0 }}</div>
                                        <div style="font-size:9px;font-weight:700;text-transform:uppercase;margin-top:2px;">activos</div>
                                    </div>
                                    @if(($cat->no_activos_count ?? 0) > 0)
                                        <div style="background:#fef3c7;color:#b45309;padding:5px 10px;border-radius:10px;text-align:center;">
                                            <div style="font-size:15px;font-weight:800;line-height:1;">{{ $cat->no_activos_count }}</div>
                                            <div style="font-size:9px;font-weight:700;text-transform:uppercase;margin-top:2px;">no act.</div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- ⭐ Botón VER ACTIVOS --}}
                            <a href="{{ route('categorias.show', $cat->id_categoria) }}"
                               style="display:inline-flex;align-items:center;gap:6px;color:#2563eb;font-weight:700;font-size:13px;text-decoration:none;padding:8px 12px;background:#eff6ff;border-radius:8px;transition:all .15s ease;width:100%;justify-content:center;margin-top:12px;"
                               onmouseover="this.style.background='#2563eb'; this.style.color='white';"
                               onmouseout="this.style.background='#eff6ff'; this.style.color='#2563eb';">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                                Ver activos de esta categoría
                            </a>
                        </div>

                        {{-- Footer con acciones --}}
                        @if(auth()->check() && auth()->user()->esAdmin())
                            <div style="display:flex;gap:8px;border-top:1px solid #e2e8f0;padding-top:12px;margin-top:12px;">

                                {{-- Editar --}}
                                <button type="button"
                                        onclick='openCategoriaModal("edit", {{ json_encode($cat, JSON_UNESCAPED_UNICODE) }})'
                                        style="flex:1;background:#fef9c3;color:#ca8a04;border:1px solid #fde047;padding:8px;border-radius:8px;font-weight:700;font-size:12px;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;gap:5px;transition:all .15s ease;"
                                        onmouseover="this.style.background='#ca8a04'; this.style.color='white';"
                                        onmouseout="this.style.background='#fef9c3'; this.style.color='#ca8a04';">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                    </svg>
                                    Editar
                                </button>

                                {{-- Eliminar --}}
                                <button type="button"
                                        onclick="openDeleteModal('{{ route('categorias.destroy', $cat->id_categoria) }}', '{{ $cat->nombre }}')"
                                        style="flex:1;background:#fee2e2;color:#dc2626;border:1px solid #fecaca;padding:8px;border-radius:8px;font-weight:700;font-size:12px;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;gap:5px;transition:all .15s ease;"
                                        onmouseover="this.style.background='#dc2626'; this.style.color='white';"
                                        onmouseout="this.style.background='#fee2e2'; this.style.color='#dc2626';">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    </svg>
                                    Eliminar
                                </button>
                            </div>
                        @endif
                    </div>
                @endforeach

            </div>
        @else
            <div style="text-align:center;padding:60px 20px;color:#94a3b8;">
                <div style="font-size:56px;margin-bottom:12px;">📁</div>
                <h3 style="margin:0 0 6px 0;font-size:16px;color:#64748b;font-weight:700;">
                    No hay categorías registradas
                </h3>
                <p style="margin:0 0 16px 0;font-size:13px;">
                    Crea la primera categoría para empezar a agregar activos.
                </p>
                @if(auth()->check() && auth()->user()->esAdmin())
                    <button type="button" onclick="openCategoriaModal('create')"
                            style="background:#10b981;color:white;border:none;padding:10px 20px;border-radius:10px;font-weight:700;cursor:pointer;font-size:14px;display:inline-flex;align-items:center;gap:6px;">
                        ➕ Nueva Categoría
                    </button>
                @endif
            </div>
        @endif
    </div>
</div>

{{-- ============ MODAL: NUEVA/EDITAR CATEGORÍA ============ --}}
<div id="categoria-modal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:9999;justify-content:center;align-items:center;padding:20px;">
    <div style="background:white;border-radius:20px;padding:30px;width:100%;max-width:500px;box-shadow:0 25px 50px -12px rgba(0,0,0,.25);">

        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;border-bottom:1px solid #e2e8f0;padding-bottom:10px;">
            <h3 id="modal-title" style="margin:0;font-size:18px;font-weight:800;color:#0f172a;">Nueva Categoría</h3>
            <button type="button" onclick="closeCategoriaModal()" style="background:#f1f5f9;border:none;border-radius:50%;width:32px;height:32px;display:flex;align-items:center;justify-content:center;font-size:18px;cursor:pointer;color:#475569;">×</button>
        </div>

        <form id="categoria-form" method="POST" action="{{ route('categorias.store') }}">
            @csrf
            <input type="hidden" id="form-method" name="_method" value="POST">
            <input type="hidden" name="id_ambiente" value="{{ $ambiente->id_ambiente }}">

            <div style="margin-bottom:14px;">
                <label style="font-size:12px;font-weight:700;display:block;margin-bottom:4px;color:#334155;">Código de Categoría *</label>
                <input type="text" id="input-codigo" name="codigo" value="{{ old('codigo') }}" placeholder="Ej: CAT-01" maxlength="20"
                       style="width:100%;padding:10px 12px;border-radius:8px;border:1px solid {{ $errors->has('codigo') ? '#dc2626' : '#cbd5e1' }};">
                @error('codigo')
                    <span style="color:#dc2626;font-size:11px;font-weight:600;display:block;margin-top:3px;">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-bottom:14px;">
                <label style="font-size:12px;font-weight:700;display:block;margin-bottom:4px;color:#334155;">Nombre de la Categoría *</label>
                <input type="text" id="input-nombre" name="nombre_categoria" value="{{ old('nombre_categoria') }}" placeholder="Ej: Equipos Informáticos" maxlength="100"
                       style="width:100%;padding:10px 12px;border-radius:8px;border:1px solid {{ $errors->has('nombre_categoria') ? '#dc2626' : '#cbd5e1' }};">
                @error('nombre_categoria')
                    <span style="color:#dc2626;font-size:11px;font-weight:600;display:block;margin-top:3px;">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-bottom:20px;">
                <label style="font-size:12px;font-weight:700;display:block;margin-bottom:4px;color:#334155;">Descripción</label>
                <textarea id="input-descripcion" name="descripcion" rows="3" maxlength="255" placeholder="Detalle opcional de la categoría"
                          style="width:100%;padding:10px 12px;border-radius:8px;border:1px solid {{ $errors->has('descripcion') ? '#dc2626' : '#cbd5e1' }};">{{ old('descripcion') }}</textarea>
                @error('descripcion')
                    <span style="color:#dc2626;font-size:11px;font-weight:600;display:block;margin-top:3px;">{{ $message }}</span>
                @enderror
            </div>

            <div style="display:flex;justify-content:flex-end;gap:10px;border-top:1px solid #e2e8f0;padding-top:15px;">
                <button type="button" onclick="closeCategoriaModal()" style="background:#e2e8f0;color:#475569;border:none;padding:10px 18px;border-radius:8px;font-weight:700;cursor:pointer;">Cancelar</button>
                <button type="submit" style="background:#2563eb;color:white;border:none;padding:10px 18px;border-radius:8px;font-weight:700;cursor:pointer;">Guardar Categoría</button>
            </div>
        </form>
    </div>
</div>

{{-- ============ MODAL: CONFIRMAR ELIMINACIÓN ============ --}}
<div id="delete-modal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:9999;justify-content:center;align-items:center;padding:20px;">
    <div style="background:white;border-radius:16px;padding:25px;width:100%;max-width:420px;">

        <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px;">
            <div style="background:#fee2e2;color:#dc2626;padding:10px;border-radius:50%;display:flex;">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <h3 style="font-size:18px;font-weight:800;color:#0f172a;margin:0;">¿Eliminar esta categoría?</h3>
        </div>

        <p style="color:#64748b;font-size:14px;margin-bottom:20px;">
            Esta acción borrará permanentemente la categoría <strong id="delete-nombre" style="color:#dc2626;"></strong> y todos sus activos asociados.
        </p>

        <form id="delete-form-action" method="POST" style="display:flex;justify-content:flex-end;gap:10px;">
            @csrf
            @method('DELETE')
            <button type="button" onclick="closeDeleteModal()" style="background:#e2e8f0;color:#475569;border:none;padding:10px 18px;border-radius:8px;font-weight:700;cursor:pointer;">Cancelar</button>
            <button type="submit" style="background:#dc2626;color:white;border:none;padding:10px 18px;border-radius:8px;font-weight:700;cursor:pointer;">Sí, eliminar</button>
        </form>
    </div>
</div>

{{-- ============ SCRIPT ============ --}}
<script>
    // ============================================
    // MODAL: NUEVA/EDITAR CATEGORÍA
    // ============================================
    function openCategoriaModal(mode, categoria = null) {
        const form = document.getElementById('categoria-form');
        const methodField = document.getElementById('form-method');
        const title = document.getElementById('modal-title');

        if (mode === 'create') {
            form.reset();
            form.action = "{{ route('categorias.store') }}";
            methodField.value = "POST";
            title.textContent = "🆕 Nueva Categoría";
        } else if (mode === 'edit' && categoria) {
            form.action = "{{ url('/categorias') }}/" + categoria.id_categoria;
            methodField.value = "PUT";
            title.textContent = "✏️ Editar Categoría";

            document.getElementById('input-codigo').value = categoria.codigo || '';
            document.getElementById('input-nombre').value = categoria.nombre || '';
            document.getElementById('input-descripcion').value = categoria.descripcion || '';
        }

        document.getElementById('categoria-modal').style.setProperty('display', 'flex', 'important');
    }

    function closeCategoriaModal() {
        document.getElementById('categoria-modal').style.setProperty('display', 'none', 'important');
    }

    // ============================================
    // MODAL: ELIMINAR
    // ============================================
    function openDeleteModal(actionUrl, nombre) {
        document.getElementById('delete-form-action').action = actionUrl;
        document.getElementById('delete-nombre').textContent = nombre;
        document.getElementById('delete-modal').style.setProperty('display', 'flex', 'important');
    }

    function closeDeleteModal() {
        document.getElementById('delete-modal').style.setProperty('display', 'none', 'important');
    }

    // ============================================
    // Reabrir modal si hay errores
    // ============================================
    @if ($errors->any())
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('categoria-modal').style.setProperty('display', 'flex', 'important');
        });
    @endif
</script>
@endsection
