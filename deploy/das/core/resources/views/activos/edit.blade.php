@extends('layouts.app')

@section('content')
<div style="max-width: 900px; margin: 0 auto; background: white; border-radius: 18px; padding: 28px; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">

    {{-- ENCABEZADO --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div>
            <h2 style="font-size: 24px; font-weight: 800; color: #0f172a; margin: 0;">
                Editar activo: {{ $activo->codigo_activo }}
            </h2>
            <p style="color: #64748b; font-size: 14px; margin: 4px 0 0 0;">
                Modifica los campos necesarios y guarda los cambios.
            </p>
        </div>
        <a href="{{ route('activos.index') }}"
           style="background: #e2e8f0; color: #334155; padding: 8px 16px; border-radius: 10px; font-weight: 700; text-decoration: none; font-size: 14px;">
            ← Volver
        </a>
    </div>

    {{-- ⭐ ERRORES DEL CLIENTE (validación en vivo) --}}
    <div id="cliente-errores" style="display:none;background:#fee2e2;border:1px solid #fecaca;color:#991b1b;padding:14px 20px;border-radius:12px;margin-bottom:20px;font-size:13px;">
        <strong>⚠️ Verifica los siguientes campos:</strong>
        <ul id="cliente-errores-lista" style="margin:8px 0 0 20px;"></ul>
    </div>

    {{-- ⭐ IMAGEN ACTUAL (referencia) --}}
    @if ($activo->imagen)
        <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;padding:14px;margin-bottom:20px;display:flex;align-items:center;gap:16px;">
            <img src="{{ asset('storage/' . $activo->imagen) }}" alt="Foto actual"
                 style="width:70px;height:70px;object-fit:cover;border-radius:8px;border:1px solid #cbd5e1;">
            <div>
                <div style="font-weight:700;color:#0f172a;font-size:13px;">Imagen actual</div>
                <div style="font-size:12px;color:#64748b;">Sube una nueva para reemplazarla</div>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('activos.update', $activo->id_activo) }}" enctype="multipart/form-data" novalidate id="activo-edit-form">
        @csrf
        @method('PUT')

        <style>
            .edit-grid { display:grid; grid-template-columns: 1fr 1fr; gap:16px; }
            .edit-grid label { display:flex; flex-direction:column; font-size:12px; font-weight:700; color:#334155; gap:4px; }
            .edit-grid label.full { grid-column:span 2; }
            .edit-grid input, .edit-grid select, .edit-grid textarea {
                width:100%; padding:10px 12px; border-radius:8px; border:1px solid #cbd5e1; font-size:14px; background:#fff; box-sizing:border-box;
            }
            .edit-grid input:focus, .edit-grid select:focus, .edit-grid textarea:focus {
                outline:none; border-color:#2563eb; box-shadow:0 0 0 3px rgba(37,99,235,.1);
            }
            .section-title {
                grid-column:span 2; font-size:11px; font-weight:800; color:#2563eb; text-transform:uppercase;
                margin:8px 0 -6px 0; padding-bottom:6px; border-bottom:1px solid #e2e8f0;
            }
            .input-error { border-color:#dc2626 !important; background:#fef2f2 !important; }
            .error-msg { color:#dc2626; font-size:11px; font-weight:600; margin-top:2px; display:block; }
            .error-inline { color:#dc2626; font-size:11px; font-weight:600; margin-top:3px; display:none; }
            .error-inline.visible { display:block; }
        </style>

        <div class="edit-grid">

            {{-- ============ IDENTIFICACIÓN ============ --}}
            <div class="section-title">Identificación</div>

            @php $tipoActual = old('tipo_bien', $activo->tipo_bien ?? 'ACTIVO_FIJO'); @endphp

            <div class="full" style="padding:14px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;">
                <div style="font-size:12px;font-weight:800;color:#334155;margin-bottom:8px;">
                    Clasificación del bien *
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                    <label id="opcion-activo-fijo" style="display:flex;gap:9px;align-items:flex-start;cursor:pointer;padding:11px;background:#fff;border:2px solid #cbd5e1;border-radius:10px;">
                        <input type="radio" name="tipo_bien" value="ACTIVO_FIJO" data-radio-tipo
                               @checked($tipoActual === 'ACTIVO_FIJO')
                               style="margin-top:2px;width:16px;height:16px;">
                        <span>
                            <strong style="display:block;font-size:13px;color:#1d4ed8;">Activo fijo</strong>
                            <small style="font-weight:400;color:#64748b;font-size:11px;">
                                Se capitaliza. Equipos, máquinas, endblocklos.
                            </small>
                        </span>
                    </label>

                    <label id="opcion-no-activo" style="display:flex;gap:9px;align-items:flex-start;cursor:pointer;padding:11px;background:#fff;border:2px solid #cbd5e1;border-radius:10px;">
                        <input type="radio" name="tipo_bien" value="NO_ACTIVO" data-radio-tipo
                               @checked($tipoActual === 'NO_ACTIVO')
                               style="margin-top:2px;width:16px;height:16px;">
                        <span>
                            <strong style="display:block;font-size:13px;color:#475569;">No activo</strong>
                            <small style="font-weight:400;color:#64748b;font-size:11px;">
                                Se inventaría pero no se capitaliza. Escobas, papeleras, engrampadoras.
                            </small>
                        </span>
                    </label>
                </div>

                <small id="aviso-serie" style="display:none;margin-top:9px;color:#b45309;font-size:11px;">
                    En los no activos no son obligatorios la marca, el modelo ni el número de serie.
                </small>

                @error('tipo_bien') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <label>Código del activo *
                <input name="codigo_activo" maxlength="50" required
                       data-requerido="true"
                       data-nombre-campo="Código del activo"
                       class="{{ $errors->has('codigo_activo') ? 'input-error' : '' }}"
                       oninput="limpiarErrorInline(this)"
                       value="{{ old('codigo_activo', $activo->codigo_activo) }}">
                <span class="error-inline" data-for="codigo_activo"></span>
                @error('codigo_activo') <span class="error-msg">{{ $message }}</span> @enderror
            </label>

            <label>N° de serie
                <input name="numero_serie" maxlength="80"
                       data-nombre-campo="N° de serie"
                       class="{{ $errors->has('numero_serie') ? 'input-error' : '' }}"
                       oninput="limpiarErrorInline(this)"
                       value="{{ old('numero_serie', $activo->numero_serie) }}">
                <span class="error-inline" data-for="numero_serie"></span>
                @error('numero_serie') <span class="error-msg">{{ $message }}</span> @enderror
            </label>

            <label class="full">Nombre del activo *
                <input name="nombre" maxlength="150" required
                       data-requerido="true"
                       data-nombre-campo="Nombre del activo"
                       class="{{ $errors->has('nombre') ? 'input-error' : '' }}"
                       oninput="limpiarErrorInline(this)"
                       value="{{ old('nombre', $activo->nombre) }}">
                <span class="error-inline" data-for="nombre"></span>
                @error('nombre') <span class="error-msg">{{ $message }}</span> @enderror
            </label>

            {{-- ============ CLASIFICACIÓN ============ --}}
            <div class="section-title">Clasificación</div>

            <label>Categoría *
                <select name="id_categoria" required
                        data-requerido="true"
                        data-nombre-campo="Categoría"
                        onchange="limpiarErrorInline(this)"
                        class="{{ $errors->has('id_categoria') ? 'input-error' : '' }}">
                    <option value="">— Seleccione —</option>
                    @foreach ($categorias as $item)
                        <option value="{{ $item->id_categoria }}"
                            {{ old('id_categoria', $activo->id_categoria) == $item->id_categoria ? 'selected' : '' }}>
                            {{ $item->nombre }}
                        </option>
                    @endforeach
                </select>
                <span class="error-inline" data-for="id_categoria"></span>
                @error('id_categoria') <span class="error-msg">{{ $message }}</span> @enderror
            </label>

            <label>Ambiente *
                <select name="id_ambiente" required
                        data-requerido="true"
                        data-nombre-campo="Ambiente"
                        onchange="limpiarErrorInline(this)"
                        class="{{ $errors->has('id_ambiente') ? 'input-error' : '' }}">
                    <option value="">— Seleccione —</option>
                    @foreach ($ambientes as $item)
                        <option value="{{ $item->id_ambiente }}"
                            {{ old('id_ambiente', $activo->id_ambiente) == $item->id_ambiente ? 'selected' : '' }}>
                            {{ $item->nombre }}
                        </option>
                    @endforeach
                </select>
                <span class="error-inline" data-for="id_ambiente"></span>
                @error('id_ambiente') <span class="error-msg">{{ $message }}</span> @enderror
            </label>

            <label>Fuente de financiamiento
                <select name="id_fuente"
                        onchange="limpiarErrorInline(this)"
                        class="{{ $errors->has('id_fuente') ? 'input-error' : '' }}">
                    <option value="">— Seleccione —</option>
                    @foreach ($fuentes as $item)
                        <option value="{{ $item->id_fuente }}"
                            {{ old('id_fuente', $activo->id_fuente) == $item->id_fuente ? 'selected' : '' }}>
                            {{ $item->codigo ? $item->codigo . ' - ' : '' }}{{ $item->nombre }}
                        </option>
                    @endforeach
                </select>
                <span class="error-inline" data-for="id_fuente"></span>
                @error('id_fuente') <span class="error-msg">{{ $message }}</span> @enderror
            </label>

            <label>Custodio *
                <x-person-picker
                    name="id_custodio"
                    id="custodioActivo"
                    :selected-id="old('id_custodio', $activo->id_custodio)"
                    :selected-texto="$activo->custodio?->nombre_completo"
                    :required="true" />
                <span class="error-inline" data-for="id_custodio"></span>
                @error('id_custodio') <span class="error-msg">{{ $message }}</span> @enderror
            </label>

            {{-- ============ ESPECIFICACIONES ============ --}}
            <div class="section-title">Especificaciones técnicas</div>

            <label>Marca
                <input name="marca" maxlength="80"
                       data-nombre-campo="Marca"
                       oninput="limpiarErrorInline(this)"
                       class="{{ $errors->has('marca') ? 'input-error' : '' }}"
                       value="{{ old('marca', $activo->marca) }}">
                <span class="error-inline" data-for="marca"></span>
                @error('marca') <span class="error-msg">{{ $message }}</span> @enderror
            </label>

            <label>Modelo
                <input name="modelo" maxlength="80"
                       data-nombre-campo="Modelo"
                       oninput="limpiarErrorInline(this)"
                       class="{{ $errors->has('modelo') ? 'input-error' : '' }}"
                       value="{{ old('modelo', $activo->modelo) }}">
                <span class="error-inline" data-for="modelo"></span>
                @error('modelo') <span class="error-msg">{{ $message }}</span> @enderror
            </label>

            <label>Fecha de adquisición
                <input name="fecha_adquisicion" type="date"
                       onchange="limpiarErrorInline(this)"
                       class="{{ $errors->has('fecha_adquisicion') ? 'input-error' : '' }}"
                       value="{{ old('fecha_adquisicion', optional($activo->fecha_adquisicion)->format('Y-m-d')) }}">
                <span class="error-inline" data-for="fecha_adquisicion"></span>
                @error('fecha_adquisicion') <span class="error-msg">{{ $message }}</span> @enderror
            </label>

            <label>Valor de adquisición (Bs)
                <input name="valor_adquisicion" type="number" min="0" step="0.01"
                       oninput="limpiarErrorInline(this)"
                       class="{{ $errors->has('valor_adquisicion') ? 'input-error' : '' }}"
                       value="{{ old('valor_adquisicion', $activo->valor_adquisicion) }}">
                <span class="error-inline" data-for="valor_adquisicion"></span>
                @error('valor_adquisicion') <span class="error-msg">{{ $message }}</span> @enderror
            </label>

            <label>Estado físico
                <select name="estado_fisico"
                        onchange="limpiarErrorInline(this)"
                        class="{{ $errors->has('estado_fisico') ? 'input-error' : '' }}">
                    <option value="B"  {{ old('estado_fisico', $activo->estado_fisico) == 'B'  ? 'selected' : '' }}>Bueno</option>
                    <option value="R"  {{ old('estado_fisico', $activo->estado_fisico) == 'R'  ? 'selected' : '' }}>Regular</option>
                    <option value="M"  {{ old('estado_fisico', $activo->estado_fisico) == 'M'  ? 'selected' : '' }}>Malo</option>
                    <option value="FF" {{ old('estado_fisico', $activo->estado_fisico) == 'FF' ? 'selected' : '' }}>Fuera de funcionamiento</option>
                </select>
                <span class="error-inline" data-for="estado_fisico"></span>
                @error('estado_fisico') <span class="error-msg">{{ $message }}</span> @enderror
            </label>

            <label>Estado de registro
                <select name="estado_registro"
                        onchange="limpiarErrorInline(this)"
                        class="{{ $errors->has('estado_registro') ? 'input-error' : '' }}">
                    <option value="ACTIVO"           {{ old('estado_registro', $activo->estado_registro) == 'ACTIVO'           ? 'selected' : '' }}>Activo</option>
                    <option value="ASIGNADO"         {{ old('estado_registro', $activo->estado_registro) == 'ASIGNADO'         ? 'selected' : '' }}>Asignado</option>
                    <option value="EN_TRANSFERENCIA" {{ old('estado_registro', $activo->estado_registro) == 'EN_TRANSFERENCIA' ? 'selected' : '' }}>En transferencia</option>
                    <option value="BAJA"             {{ old('estado_registro', $activo->estado_registro) == 'BAJA'             ? 'selected' : '' }}>Baja</option>
                </select>
                <span class="error-inline" data-for="estado_registro"></span>
                @error('estado_registro') <span class="error-msg">{{ $message }}</span> @enderror
            </label>

            {{-- ============ DETALLES ============ --}}
            <div class="section-title">Detalles y archivos</div>

            <label class="full">Descripción / Características técnicas *
                <textarea name="descripcion" rows="3" required
                          data-requerido="true"
                          data-nombre-campo="Descripción"
                          oninput="limpiarErrorInline(this)"
                          class="{{ $errors->has('descripcion') ? 'input-error' : '' }}">{{ old('descripcion', $activo->descripcion) }}</textarea>
                <span class="error-inline" data-for="descripcion"></span>
                @error('descripcion') <span class="error-msg">{{ $message }}</span> @enderror
            </label>

            <label class="full">Nueva imagen del activo (opcional)
                <input name="imagen" type="file" accept="image/*"
                       onchange="limpiarErrorInline(this)"
                       class="{{ $errors->has('imagen') ? 'input-error' : '' }}">
                <small style="font-weight:400;color:#64748b;font-size:10px;">JPG, PNG o WEBP. Máx 5 MB. Deja vacío para conservar la actual.</small>
                <span class="error-inline" data-for="imagen"></span>
                @error('imagen') <span class="error-msg">{{ $message }}</span> @enderror
            </label>

        </div>

        {{-- ============ ACCIONES ============ --}}
        <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:24px;border-top:1px solid #e2e8f0;padding-top:18px;">
            <a href="{{ route('activos.index') }}"
               style="background:#e2e8f0;color:#475569;border:none;padding:11px 22px;border-radius:8px;font-weight:700;text-decoration:none;display:inline-block;">
                Cancelar
            </a>
            <button type="submit" id="btn-guardar-edit"
                style="background:#2563eb;color:white;border:none;padding:11px 22px;border-radius:8px;font-weight:700;cursor:pointer;">
                💾 Guardar cambios
            </button>
        </div>
    </form>
</div>

<script>
    // ============================================
    // LIMPIAR ERROR INLINE AL ESCRIBIR
    // ============================================
    function limpiarErrorInline(input) {
        const errorSpan = document.querySelector('.error-inline[data-for="' + input.name + '"]');
        if (errorSpan) {
            errorSpan.classList.remove('visible');
            errorSpan.textContent = '';
        }
        const val = input.value;
        if (val && (typeof val === 'string' ? val.trim() : val) !== '') {
            input.classList.remove('input-error');
        }
    }

    // ============================================
    // VALIDACIÓN ESTRICTA ANTES DE ENVIAR
    // ============================================
    document.getElementById('activo-edit-form')?.addEventListener('submit', function(e) {
        let hayErrores = false;

        document.querySelectorAll('.error-inline').forEach(el => {
            el.classList.remove('visible');
            el.textContent = '';
        });
        document.querySelectorAll('#activo-edit-form .input-error').forEach(el => {
            el.classList.remove('input-error');
        });

        function marcarError(campo, mensaje) {
            const errorSpan = document.querySelector('.error-inline[data-for="' + campo.name + '"]');
            if (errorSpan) {
                errorSpan.textContent = '⚠️ ' + mensaje;
                errorSpan.classList.add('visible');
            }
            campo.classList.add('input-error');
            hayErrores = true;
        }

        // Validar campos obligatorios
        document.querySelectorAll('#activo-edit-form [data-requerido="true"]').forEach(campo => {
            const valor = (campo.value || '').trim();
            const nombreCampo = campo.dataset.nombreCampo || campo.name;
            if (valor === '') {
                marcarError(campo, 'El campo "' + nombreCampo + '" es obligatorio.');
            }
        });

        if (hayErrores) {
            e.preventDefault();
            const contenedor = document.getElementById('cliente-errores');
            const lista = document.getElementById('cliente-errores-lista');
            const totalErrores = document.querySelectorAll('.error-inline.visible').length;
            lista.innerHTML = '<li>Hay ' + totalErrores + ' campo(s) con errores. Revisa los mensajes debajo de cada campo.</li>';
            contenedor.style.display = 'block';

            const primerError = document.querySelector('#activo-edit-form .input-error');
            if (primerError) {
                primerError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                primerError.focus();
            }
            return false;
        }

        document.getElementById('cliente-errores').style.display = 'none';
        const btn = document.getElementById('btn-guardar-edit');
        btn.disabled = true;
        btn.textContent = '⏳ Guardando...';
    });
</script>

<script>
// Tipo de bien: marca, modelo y serie dejan de ser obligatorios en no activos
(function () {
    var radios = Array.from(document.querySelectorAll('[data-radio-tipo]'));
    var fijo = document.getElementById('opcion-activo-fijo');
    var noActivo = document.getElementById('opcion-no-activo');
    var aviso = document.getElementById('aviso-serie');

    function aplicar() {
        var seleccionado = document.querySelector('[data-radio-tipo]:checked');
        var tipo = seleccionado ? seleccionado.value : 'ACTIVO_FIJO';

        if (fijo) {
            fijo.style.borderColor = tipo === 'ACTIVO_FIJO' ? '#2563eb' : '#cbd5e1';
            fijo.style.background = tipo === 'ACTIVO_FIJO' ? '#eff6ff' : '#fff';
        }

        if (noActivo) {
            noActivo.style.borderColor = tipo === 'NO_ACTIVO' ? '#f59e0b' : '#cbd5e1';
            noActivo.style.background = tipo === 'NO_ACTIVO' ? '#fffbeb' : '#fff';
        }

        if (aviso) aviso.style.display = tipo === 'NO_ACTIVO' ? 'block' : 'none';

        ['marca', 'modelo', 'numero_serie'].forEach(function (campo) {
            var input = document.querySelector('[name="' + campo + '"]');
            if (!input) return;
            if (tipo === 'NO_ACTIVO') {
                input.removeAttribute('data-requerido');
                input.required = false;
            } else {
                input.setAttribute('data-requerido', 'true');
                input.required = true;
            }
        });
    }

    radios.forEach(function (r) { r.addEventListener('change', aplicar); });
    aplicar();
})();
</script>
@endsection
