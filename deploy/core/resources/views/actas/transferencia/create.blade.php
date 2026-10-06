@extends('layouts.app')

@section('title', 'Registrar Nueva Transferencia')

@section('content')
<div class="container-fluid px-4 py-6">
    <div style="max-width: 800px; margin: 0 auto;">

        <a href="{{ route('actas.transferencia.index') }}"
           style="display: inline-flex; align-items: center; gap: 6px; color: #c2410c; font-weight: 700; font-size: 13px; text-decoration: none; background: #fff7ed; padding: 8px 14px; border-radius: 10px; border: 1px solid #ffedd5; margin-bottom: 16px;">
            ← Volver a Transferencias
        </a>

        <div style="background: white; border-radius: 16px; border: 1px solid #e2e8f0; padding: 30px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);">
            <h1 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0 0 6px 0;">Registrar Nueva Transferencia</h1>
            <p style="font-size: 13px; color: #64748b; margin: 0 0 24px 0;">Selecciona el activo, el ambiente de destino y el nuevo custodio responsable.</p>

            <form id="formTransferencia" method="POST" action="{{ route('actas.transferencia.store') }}" style="display: flex; flex-direction: column; gap: 20px;" novalidate>
                @csrf

                {{-- ACTIVO A TRANSFERIR --}}
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 800; color: #334155; margin-bottom: 6px; text-transform: uppercase;">Activo a Transferir *</label>
                    <select id="selectActivo" name="id_activo"
                            style="width: 100%; padding: 11px 14px; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 13px; color: #1e293b; outline: none;">
                        <option value="">— Seleccionar activo —</option>
                        @foreach($activos as $act)
                            <option value="{{ $act->id_activo ?? $act->id }}" {{ old('id_activo') == ($act->id_activo ?? $act->id) ? 'selected' : '' }}>
                                [{{ $act->codigo_activo }}] {{ $act->nombre }} — {{ optional($act->ambiente)->nombre ?? 'Sin ambiente' }}
                            </option>
                        @endforeach
                    </select>
                    <span id="errorActivo" style="font-size: 11px; color: #dc2626; font-weight: 700; margin-top: 4px; display: none;">⚠️ Debe seleccionar un activo a transferir.</span>
                </div>

                {{-- AMBIENTE DESTINO --}}
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 800; color: #334155; margin-bottom: 6px; text-transform: uppercase;">Ambiente Destino *</label>
                    <select id="selectAmbiente" name="id_destino_ambiente"
                            style="width: 100%; padding: 11px 14px; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 13px; color: #1e293b; outline: none;">
                        <option value="">— Seleccionar ambiente —</option>
                        @foreach($ambientes as $amb)
                            <option value="{{ $amb->id_ambiente }}" {{ old('id_destino_ambiente') == $amb->id_ambiente ? 'selected' : '' }}>
                                {{ $amb->nombre }} — {{ optional($amb->carrera)->nombre ?? '' }}
                            </option>
                        @endforeach
                    </select>
                    <span id="errorAmbiente" style="font-size: 11px; color: #dc2626; font-weight: 700; margin-top: 4px; display: none;">⚠️ Debe seleccionar el ambiente de destino.</span>
                </div>

                {{-- NUEVO CUSTODIO --}}
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 800; color: #334155; margin-bottom: 6px; text-transform: uppercase;">Nuevo Custodio *</label>
                    <x-person-picker
                        name="id_custodio_nuevo"
                        id="selectCustodio"
                        :selected-id="old('id_custodio_nuevo')"
                        :required="true" />
                    <span id="errorCustodio" style="font-size: 11px; color: #dc2626; font-weight: 700; margin-top: 4px; display: none;">⚠️ Debe seleccionar un nuevo custodio responsable.</span>
                </div>

                {{-- FECHA DE TRANSFERENCIA (Por defecto fecha actual) --}}
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 800; color: #334155; margin-bottom: 6px; text-transform: uppercase;">Fecha de Transferencia *</label>
                    <input type="date" id="inputFecha" name="fecha_transferencia" value="{{ old('fecha_transferencia', date('Y-m-d')) }}"
                        style="width: 100%; padding: 10px 14px; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 13px; outline: none;">
                    <span id="errorFecha" style="font-size: 11px; color: #dc2626; font-weight: 700; margin-top: 4px; display: none;">⚠️ La fecha de transferencia es obligatoria.</span>
                </div>

                {{-- OBSERVACIONES --}}
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 800; color: #334155; margin-bottom: 6px; text-transform: uppercase;">Observaciones</label>
                    <textarea name="observaciones" rows="3"
                        placeholder="Motivo o detalles de la transferencia..."
                        style="width: 100%; padding: 10px 14px; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 13px; outline: none; resize: none;">{{ old('observaciones') }}</textarea>
                </div>

                {{-- BOTONES DE ACCIÓN --}}
                <div style="display: flex; justify-content: flex-end; gap: 10px; padding-top: 16px; border-top: 1px solid #f1f5f9;">
                    <a href="{{ route('actas.transferencia.index') }}"
                       style="padding: 10px 18px; background: #e2e8f0; color: #334155; border-radius: 10px; font-size: 13px; font-weight: 700; text-decoration: none;">
                        Cancelar
                    </a>
                    <button type="button" onclick="validarTransferencia()"
                            style="padding: 10px 20px; background: #ea580c; color: white; border: none; border-radius: 10px; font-size: 13px; font-weight: 700; cursor: pointer; box-shadow: 0 2px 4px rgba(234, 88, 12, 0.2);">
                        Registrar Transferencia
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

<script>
    function validarTransferencia() {
        let isValid = true;

        // Validar Activo
        const activo = document.getElementById('selectActivo');
        const errActivo = document.getElementById('errorActivo');
        if (!activo.value) {
            errActivo.style.display = 'block';
            activo.style.borderColor = '#dc2626';
            isValid = false;
        } else {
            errActivo.style.display = 'none';
            activo.style.borderColor = '#cbd5e1';
        }

        // Validar Ambiente
        const ambiente = document.getElementById('selectAmbiente');
        const errAmbiente = document.getElementById('errorAmbiente');
        if (!ambiente.value) {
            errAmbiente.style.display = 'block';
            ambiente.style.borderColor = '#dc2626';
            isValid = false;
        } else {
            errAmbiente.style.display = 'none';
            ambiente.style.borderColor = '#cbd5e1';
        }

        // Validar Custodio
        const custodio = window.PersonPicker?.valor('selectCustodio');
        const errCustodio = document.getElementById('errorCustodio');
        if (!custodio || !custodio.value) {
            errCustodio.style.display = 'block';
            window.PersonPicker?.marcarError('selectCustodio', true);
            isValid = false;
        } else {
            errCustodio.style.display = 'none';
            window.PersonPicker?.marcarError('selectCustodio', false);
        }

        // Validar Fecha
        const fecha = document.getElementById('inputFecha');
        const errFecha = document.getElementById('errorFecha');
        if (!fecha.value) {
            errFecha.style.display = 'block';
            fecha.style.borderColor = '#dc2626';
            isValid = false;
        } else {
            errFecha.style.display = 'none';
            fecha.style.borderColor = '#cbd5e1';
        }

        if (isValid) {
            document.getElementById('formTransferencia').submit();
        }
    }
</script>
@endsection
