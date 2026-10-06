@extends('layouts.app')

@section('content')
@php use Illuminate\Support\Str; @endphp

    @if (session('success'))
        <div style="background: #dcfce7; border: 1px solid #bbf7d0; color: #166534; padding: 14px 20px; border-radius: 12px; margin-bottom: 20px; font-weight: 700; display: flex; align-items: center; gap: 10px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
            <svg style="width: 20px; height: 20px; color: #16a34a;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <section class="hero-card" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); padding: 30px; border-radius: 16px; color: white; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px; margin-bottom: 25px; box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.2);">
        <div>
            <div style="display:inline-block;padding:6px 10px;border-radius:999px;background:rgba(255,255,255,0.18);font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;">Carrera</div>
            <h1 style="margin:10px 0 8px;font-size:28px;">{{ $nombre }}</h1>
            <p>Administra los ambientes de esta carrera y su mantenimiento.</p>
        </div>
        <div class="stat-grid" style="display: flex; gap: 10px;">
            <div style="background: rgba(15, 23, 42, 0.35); border: 1px solid rgba(255, 255, 255, 0.1); padding: 12px 18px; border-radius: 12px; text-align: center; min-width: 90px;">
                <div style="font-size: 20px; font-weight: 800; color: white;">{{ $ambientes->count() }}</div>
                <span style="font-size: 10px; font-weight: 700; opacity: 0.8; text-transform: uppercase;">Ambientes</span>
            </div>
            <div style="background: rgba(15, 23, 42, 0.35); border: 1px solid rgba(255, 255, 255, 0.1); padding: 12px 18px; border-radius: 12px; text-align: center; min-width: 90px;">
                <div style="font-size: 20px; font-weight: 800; color: white;">{{ $ambientes->sum(fn($amb) => $amb->activos_count ?? 0) }}</div>
                <span style="font-size: 10px; font-weight: 700; opacity: 0.8; text-transform: uppercase;">Activos</span>
            </div>
        </div>
    </section>

    <section class="panel" style="background: white; border-radius: 16px; border: 1px solid #e2e8f0; padding: 25px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
        <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:14px; margin-bottom:18px;">
            <div>
                <h2 style="font-size: 18px; font-weight: 800; color: #0f172a; margin: 0;">Ambientes relacionados</h2>
                <p style="font-size: 13px; color: #64748b; margin: 4px 0 0 0;">Visualiza, edita o elimina cada ambiente de la carrera.</p>
            </div>

            @if (auth()->check() && auth()->user()->rol === 'ADMINISTRADOR')
                <button type="button" onclick="openAmbienteModal()" style="background: #2563eb; color: white; border: none; padding: 10px 18px; border-radius: 10px; font-weight: 700; cursor: pointer; box-shadow: 0 4px 6px -1px rgba(37,99,235,0.2);">+ Nuevo ambiente</button>
            @endif
        </div>

        @if ($ambientes->count())
            <div class="link-list" style="display: flex; flex-direction: column; gap: 12px;">
                @foreach ($ambientes as $amb)
                    <div style="display:flex; align-items:center; gap:12px; padding:16px 20px; border:1px solid #e2e8f0; border-radius:12px; background:#f8fafc;">
                        <div>
                            <a href="{{ route('ambientes.detalle', $amb->id_ambiente) }}" style="font-weight:700; color:#2563eb; text-decoration:none; font-size: 15px;">
                                {{ $amb->codigo ? '[' . $amb->codigo . '] ' : '' }}{{ $amb->nombre }}
                            </a>
                            <div class="tag" style="font-size: 13px; color: #64748b; margin-top: 2px;">
                                {{ $amb->bloque ? 'Bloque ' . $amb->bloque : 'Bloque N/A' }} · {{ $amb->piso ? 'Piso ' . $amb->piso : 'Piso N/D' }}
                            </div>
                        </div>

                        <div style="margin-left:auto; display:flex; gap:8px; align-items:center;">
                            <a href="{{ route('ambientes.detalle', $amb->id_ambiente) }}" title="Ver ambiente"
                                style="background:#f1f5f9; color:#334155; width: 38px; height: 38px; border-radius: 8px; display: flex; align-items: center; justify-content: center; text-decoration: none; border: 1px solid #cbd5e1; font-size: 16px;">
                                👁️
                            </a>

                            @if (auth()->check() && auth()->user()->rol === 'ADMINISTRADOR')
                                <button type="button" onclick='editAmbiente({{ json_encode($amb, JSON_UNESCAPED_UNICODE) }})' title="Editar ambiente"
                                    style="background:#fef9c3; color:#ca8a04; width: 38px; height: 38px; border-radius: 8px; border: 1px solid #fde047; display: flex; align-items: center; justify-content: center; font-size: 16px; cursor:pointer;">
                                    ✏️
                                </button>

                                {{-- Formulario de eliminación conectado al modal de confirmación --}}
                                <form id="delete-form-{{ $amb->id_ambiente }}" method="POST" action="{{ route('ambientes.destroy', ['id_carrera' => $carrera->id_carrera, 'id_ambiente' => $amb->id_ambiente]) }}" style="margin: 0; display: flex;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="openDeleteModal('{{ $amb->id_ambiente }}')" title="Eliminar ambiente"
                                        style="background:#fee2e2; color:#dc2626; width: 38px; height: 38px; border-radius: 8px; border: 1px solid #fca5a5; display: flex; align-items: center; justify-content: center; font-size: 16px; cursor:pointer;">
                                        🗑️
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p style="text-align: center; padding: 40px; color: #94a3b8; font-weight: 600;">No hay ambientes registrados para esta carrera.</p>
        @endif
    </section>

    <!-- Modal flotante para crear/editar ambiente -->
    <div id="ambiente-modal" style="display: none !important; position: fixed; inset: 0; background: rgba(0, 0, 0, 0.5); z-index: 9999; justify-content: center; align-items: center; padding: 20px;">
        <div style="background: white; border-radius: 20px; padding: 30px; width: 100%; max-width: 500px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); position: relative;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #e2e8f0; padding-bottom: 10px;">
                <h3 id="ambiente-modal-title" style="margin: 0; font-size: 18px; font-weight: 800; color: #0f172a;">Nuevo ambiente</h3>
                <button type="button" onclick="closeAmbienteModal()" style="background: #f1f5f9; border: none; border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 18px; cursor: pointer; color: #475569;">×</button>
            </div>

            <form id="ambiente-form" method="POST" action="{{ route('ambientes.store', ['id_carrera' => $carrera->id_carrera]) }}">
                @csrf
                <input id="ambiente-method" type="hidden" name="_method" value="POST">

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 15px;">
                    <div>
                        <label style="font-size: 12px; font-weight: 700; display: block; margin-bottom: 4px; color: #334155;">Código *</label>
                        <input id="amb-codigo" name="codigo" value="{{ old('codigo') }}" maxlength="20" style="width: 100%; padding: 9px 12px; border-radius: 8px; border: 1px solid {{ $errors->has('codigo') ? '#dc2626' : '#cbd5e1' }};">
                        @error('codigo')
                            <span style="color: #dc2626; font-size: 11px; font-weight: 600; display: block; margin-top: 3px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label style="font-size: 12px; font-weight: 700; display: block; margin-bottom: 4px; color: #334155;">Nombre *</label>
                        <input id="amb-nombre" name="nombre" value="{{ old('nombre') }}" maxlength="100" style="width: 100%; padding: 9px 12px; border-radius: 8px; border: 1px solid {{ $errors->has('nombre') ? '#dc2626' : '#cbd5e1' }};">
                        @error('nombre')
                            <span style="color: #dc2626; font-size: 11px; font-weight: 600; display: block; margin-top: 3px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label style="font-size: 12px; font-weight: 700; display: block; margin-bottom: 4px; color: #334155;">Bloque *</label>
                        <input id="amb-bloque" name="bloque" value="{{ old('bloque') }}" maxlength="10" style="width: 100%; padding: 9px 12px; border-radius: 8px; border: 1px solid {{ $errors->has('bloque') ? '#dc2626' : '#cbd5e1' }};">
                        @error('bloque')
                            <span style="color: #dc2626; font-size: 11px; font-weight: 600; display: block; margin-top: 3px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label style="font-size: 12px; font-weight: 700; display: block; margin-bottom: 4px; color: #334155;">Piso *</label>
                        <input id="amb-piso" name="piso" type="number" value="{{ old('piso') }}" style="width: 100%; padding: 9px 12px; border-radius: 8px; border: 1px solid {{ $errors->has('piso') ? '#dc2626' : '#cbd5e1' }};">
                        @error('piso')
                            <span style="color: #dc2626; font-size: 11px; font-weight: 600; display: block; margin-top: 3px;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 10px; border-top: 1px solid #e2e8f0; padding-top: 15px; margin-top: 15px;">
                    <button type="button" onclick="closeAmbienteModal()" style="background: #e2e8f0; color: #475569; border: none; padding: 10px 18px; border-radius: 8px; font-weight: 700; cursor: pointer;">Cancelar</button>
                    <button type="submit" style="background: #2563eb; color: white; border: none; padding: 10px 18px; border-radius: 8px; font-weight: 700; cursor: pointer;">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal pequeño de confirmación para eliminar -->
    <div id="delete-confirm-modal" style="display: none !important; position: fixed; inset: 0; background: rgba(0, 0, 0, 0.5); z-index: 10000; justify-content: center; align-items: center; padding: 20px;">
        <div style="background: white; border-radius: 16px; padding: 25px; width: 100%; max-width: 380px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); text-align: center;">
            <div style="font-size: 32px; margin-bottom: 10px;">⚠️</div>
            <h3 style="margin: 0 0 8px; font-size: 18px; font-weight: 800; color: #0f172a;">¿Eliminar ambiente?</h3>
            <p style="font-size: 13px; color: #64748b; margin: 0 0 20px;">Esta acción no se puede deshacer y borrará los datos asociados.</p>
            <div style="display: flex; justify-content: center; gap: 10px;">
                <button type="button" onclick="closeDeleteModal()" style="background: #e2e8f0; color: #475569; border: none; padding: 9px 16px; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 13px;">Cancelar</button>
                <button type="button" id="confirm-delete-btn" style="background: #dc2626; color: white; border: none; padding: 9px 16px; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 13px;">Sí, eliminar</button>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let currentAmbienteIdToDelete = null;

        function openAmbienteModal() {
            const form = document.getElementById('ambiente-form');
            form.reset();
            form.action = '{{ route('ambientes.store', ['id_carrera' => $carrera->id_carrera]) }}';
            document.getElementById('ambiente-method').value = 'POST';
            document.getElementById('ambiente-modal-title').textContent = 'Nuevo ambiente';
            document.getElementById('ambiente-modal').style.setProperty('display', 'flex', 'important');
        }

        function closeAmbienteModal() {
            document.getElementById('ambiente-modal').style.setProperty('display', 'none', 'important');
        }

        function editAmbiente(serialized) {
            const amb = typeof serialized === 'string' ? JSON.parse(serialized) : serialized;
            const form = document.getElementById('ambiente-form');
            const carreraId = '{{ $carrera->id_carrera }}';
            const ambienteId = amb.id_ambiente;

            form.action = '{{ url('/carreras') }}/' + carreraId + '/ambientes/' + ambienteId;
            document.getElementById('ambiente-method').value = 'PUT';
            document.getElementById('ambiente-modal-title').textContent = 'Editar ambiente';
            document.getElementById('amb-codigo').value = amb.codigo || '';
            document.getElementById('amb-nombre').value = amb.nombre || '';
            document.getElementById('amb-bloque').value = amb.bloque || '';
            document.getElementById('amb-piso').value = amb.piso || '';
            document.getElementById('ambiente-modal').style.setProperty('display', 'flex', 'important');
        }

        // Funciones para el modal pequeño de confirmación de eliminación
        function openDeleteModal(ambienteId) {
            currentAmbienteIdToDelete = ambienteId;
            document.getElementById('delete-confirm-modal').style.setProperty('display', 'flex', 'important');
        }

        function closeDeleteModal() {
            currentAmbienteIdToDelete = null;
            document.getElementById('delete-confirm-modal').style.setProperty('display', 'none', 'important');
        }

        document.getElementById('confirm-delete-btn').addEventListener('click', function() {
            if (currentAmbienteIdToDelete) {
                document.getElementById('delete-form-' + currentAmbienteIdToDelete).submit();
            }
        });
    </script>

    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('ambiente-modal').style.setProperty('display', 'flex', 'important');
            });
        </script>
    @endif
@endsection
