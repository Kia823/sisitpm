@extends('layouts.app')

@section('content')
<div style="max-width:900px;margin:0 auto;background:white;padding:28px;border-radius:18px;box-shadow:0 4px 12px rgba(0,0,0,.05);">

    {{-- Encabezado --}}
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
        <div>
            <h2 style="font-size:24px;font-weight:800;color:#0f172a;margin:0;">Nuevo Activo</h2>
            <p style="font-size:13px;color:#64748b;margin:4px 0 0 0;">Completa los datos del activo. Si registras varios, usa el campo "Cantidad".</p>
        </div>
        <a href="{{ url()->previous() }}" style="background:#e2e8f0;color:#334155;padding:8px 16px;border-radius:10px;font-weight:700;text-decoration:none;font-size:14px;">← Volver</a>
    </div>

    {{-- ⭐ Errores generales (del servidor) --}}
    @if ($errors->any())
        <div style="background:#fee2e2;border:1px solid #fecaca;color:#991b1b;padding:14px 20px;border-radius:12px;margin-bottom:20px;font-size:13px;">
            <strong>⚠️ Corrige los siguientes errores:</strong>
            <ul style="margin:8px 0 0 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ⭐ Errores del cliente (validación en vivo) --}}
    <div id="cliente-errores" style="display:none;background:#fee2e2;border:1px solid #fecaca;color:#991b1b;padding:14px 20px;border-radius:12px;margin-bottom:20px;font-size:13px;">
        <strong>⚠️ Verifica los siguientes campos:</strong>
        <ul id="cliente-errores-lista" style="margin:8px 0 0 20px;"></ul>
    </div>

    <form method="POST" action="{{ route('activos.store') }}" enctype="multipart/form-data" novalidate id="activo-form">
        @csrf

        <style>
            .form-grid { display:grid;grid-template-columns:1fr 1fr;gap:16px; }
            .form-grid label { display:flex;flex-direction:column;font-size:12px;font-weight:700;color:#334155;gap:4px; }
            .form-grid label.full { grid-column:span 2; }
            .form-grid input, .form-grid select, .form-grid textarea {
                width:100%;padding:9px 12px;border-radius:8px;border:1px solid #cbd5e1;font-size:14px;background:#fff;box-sizing:border-box;
            }
            .form-grid input:focus, .form-grid select:focus, .form-grid textarea:focus {
                outline:none;border-color:#2563eb;box-shadow:0 0 0 3px rgba(37,99,235,.1);
            }
            .input-error { border-color:#dc2626 !important; background:#fef2f2 !important; }
            .error-msg { color:#dc2626;font-size:11px;font-weight:600;margin-top:2px;display:block; }
            .error-inline { color:#dc2626;font-size:11px;font-weight:600;margin-top:3px;display:none; }
            .error-inline.visible { display:block; }
            .section-title {
                grid-column:span 2;font-size:11px;font-weight:800;color:#2563eb;text-transform:uppercase;
                margin:8px 0 -6px 0;padding-bottom:6px;border-bottom:1px solid #e2e8f0;
            }
            .codigo-ok { border-color:#10b981 !important; background:#f0fdf4 !important; }
        </style>

        <div class="form-grid">

            {{-- ============ IDENTIFICACIÓN ============ --}}
            <div class="section-title">Identificación</div>

            {{-- ⭐ Código --}}
            <label>Código del activo *
                <input name="codigo_activo" id="codigo_activo" maxlength="50" required
                       data-requerido="true"
                       data-nombre-campo="Código del activo"
                       class="{{ $errors->has('codigo_activo') ? 'input-error' : '' }}"
                       placeholder="Ej: TPM2504031-12"
                       style="text-transform:uppercase;"
                       oninput="this.value=this.value.toUpperCase(); verificarCodigo(); limpiarErrorInline(this)"
                       value="{{ old('codigo_activo',$codigoSugerido ??  'TPM-01'. date('Y') . '-' . rand(1000,9999)) }}">
                <span id="codigo-feedback" style="font-size:11px;margin-top:2px;display:block;"></span>
                <span class="error-inline" data-for="codigo_activo"></span>
                @error('codigo_activo') <span class="error-msg">{{ $message }}</span> @enderror
            </label>

            {{-- ⭐ Tipo de bien: activo fijo o no activo --}}
            <div class="full" id="bloque-tipo-bien" style="padding:14px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;">
                <div style="font-size:12px;font-weight:800;color:#334155;margin-bottom:8px;">
                    Clasificación del bien *
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                    <label style="display:flex;gap:9px;align-items:flex-start;cursor:pointer;padding:11px;background:#fff;border:2px solid #2563eb;border-radius:10px;">
                        <input type="radio" name="tipo_bien" value="ACTIVO_FIJO" data-radio-tipo
                               @checked(old('tipo_bien', 'ACTIVO_FIJO') === 'ACTIVO_FIJO')
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
                               @checked(old('tipo_bien') === 'NO_ACTIVO')
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

            {{-- ⭐ Cantidad --}}
            <label>Cantidad *
                <input name="cantidad" id="cantidad" type="number" min="1" max="100" required
                       data-requerido="true"
                       data-nombre-campo="Cantidad"
                       class="{{ $errors->has('cantidad') ? 'input-error' : '' }}"
                       oninput="limpiarErrorInline(this)"
                       value="{{ old('cantidad', 1) }}">
                <small style="font-weight:400;color:#64748b;font-size:10px;">Si es &gt; 1, se generan códigos correlativos.</small>
                <span class="error-inline" data-for="cantidad"></span>
                @error('cantidad') <span class="error-msg">{{ $message }}</span> @enderror
            </label>

            {{-- ⭐ Nombre --}}
            <label class="full">Nombre del activo *
                <input name="nombre" id="nombre" maxlength="150" required
                       data-requerido="true"
                       data-nombre-campo="Nombre del activo"
                       class="{{ $errors->has('nombre') ? 'input-error' : '' }}"
                       placeholder="Ej: CPU con CASE color negro Intel i5"
                       oninput="limpiarErrorInline(this)"
                       value="{{ old('nombre') }}">
                <span class="error-inline" data-for="nombre"></span>
                @error('nombre') <span class="error-msg">{{ $message }}</span> @enderror
            </label>

            {{-- ============ CLASIFICACIÓN ============ --}}
            <div class="section-title">Clasificación</div>

            {{-- ⭐ Categoría --}}
            <label>Categoría *
                <select name="id_categoria" required
                        data-requerido="true"
                        data-nombre-campo="Categoría"
                        onchange="limpiarErrorInline(this)"
                        class="{{ $errors->has('id_categoria') ? 'input-error' : '' }}">
                    <option value="">— Seleccione categoría —</option>
                    @foreach ($categorias as $item)
                        <option value="{{ $item->id_categoria }}"
                            {{ old('id_categoria') == $item->id_categoria ? 'selected' : '' }}>
                            {{ $item->nombre }}
                        </option>
                    @endforeach
                </select>
                <span class="error-inline" data-for="id_categoria"></span>
                @error('id_categoria') <span class="error-msg">{{ $message }}</span> @enderror
            </label>

            {{-- ⭐ Ambiente --}}
            <label>Ambiente *
                <select name="id_ambiente" required
                        data-requerido="true"
                        data-nombre-campo="Ambiente"
                        onchange="limpiarErrorInline(this)"
                        class="{{ $errors->has('id_ambiente') ? 'input-error' : '' }}">
                    <option value="">— Seleccione ambiente —</option>
                    @foreach ($ambientes as $item)
                        <option value="{{ $item->id_ambiente }}"
                            {{ old('id_ambiente', $id_ambiente_preseleccionado ?? '') == $item->id_ambiente ? 'selected' : '' }}>
                            {{ $item->nombre }}
                        </option>
                    @endforeach
                </select>
                <span class="error-inline" data-for="id_ambiente"></span>
                @error('id_ambiente') <span class="error-msg">{{ $message }}</span> @enderror
            </label>

            {{-- ⭐ Fuente de financiamiento --}}
            <label>Fuente de financiamiento
                <select name="id_fuente"
                        data-nombre-campo="Fuente de financiamiento"
                        onchange="limpiarErrorInline(this)"
                        class="{{ $errors->has('id_fuente') ? 'input-error' : '' }}">
                    <option value="">— Seleccione fuente —</option>
                    @foreach ($fuentes as $item)
                        <option value="{{ $item->id_fuente }}"
                            {{ old('id_fuente') == $item->id_fuente ? 'selected' : '' }}>
                            {{ $item->codigo ? $item->codigo . ' - ' : '' }}{{ $item->nombre }}
                        </option>
                    @endforeach
                </select>
                <span class="error-inline" data-for="id_fuente"></span>
                @error('id_fuente') <span class="error-msg">{{ $message }}</span> @enderror
            </label>

            {{-- ⭐ Estado físico --}}
            <label>Estado físico
                <select name="estado_fisico"
                        onchange="limpiarErrorInline(this)"
                        class="{{ $errors->has('estado_fisico') ? 'input-error' : '' }}">
                    <option value="B"  {{ old('estado_fisico') == 'B'  ? 'selected' : '' }}>Bueno</option>
                    <option value="R"  {{ old('estado_fisico') == 'R'  ? 'selected' : '' }}>Regular</option>
                    <option value="M"  {{ old('estado_fisico') == 'M'  ? 'selected' : '' }}>Malo</option>
                    <option value="FF" {{ old('estado_fisico') == 'FF' ? 'selected' : '' }}>Fuera de funcionamiento</option>
                </select>
                <span class="error-inline" data-for="estado_fisico"></span>
                @error('estado_fisico') <span class="error-msg">{{ $message }}</span> @enderror
            </label>

            {{-- ============ ESPECIFICACIONES ============ --}}
            <div class="section-title">Especificaciones técnicas</div>

            {{-- ⭐ Marca --}}
            <label>Marca
                <input name="marca" maxlength="80"
                       data-nombre-campo="Marca"
                       oninput="limpiarErrorInline(this)"
                       class="{{ $errors->has('marca') ? 'input-error' : '' }}"
                       value="{{ old('marca') }}" placeholder="Ej: DELUX, HP, Samsung...">
                <span class="error-inline" data-for="marca"></span>
                @error('marca') <span class="error-msg">{{ $message }}</span> @enderror
            </label>

            {{-- ⭐ Modelo --}}
            <label>Modelo
                <input name="modelo" maxlength="80"
                       data-nombre-campo="Modelo"
                       oninput="limpiarErrorInline(this)"
                       class="{{ $errors->has('modelo') ? 'input-error' : '' }}"
                       value="{{ old('modelo') }}" placeholder="Ej: S22F350FHL">
                <span class="error-inline" data-for="modelo"></span>
                @error('modelo') <span class="error-msg">{{ $message }}</span> @enderror
            </label>

            {{-- ⭐ N° de serie --}}
            <label>N° de serie
                <input name="numero_serie" maxlength="80"
                       data-nombre-campo="N° de serie"
                       oninput="limpiarErrorInline(this)"
                       class="{{ $errors->has('numero_serie') ? 'input-error' : '' }}"
                       value="{{ old('numero_serie') }}" placeholder="Ej: 0ABZHCNT601459">
                <span class="error-inline" data-for="numero_serie"></span>
                @error('numero_serie') <span class="error-msg">{{ $message }}</span> @enderror
            </label>

            {{-- ⭐ Fecha de adquisición --}}
            <label>Fecha de adquisición
                <input name="fecha_adquisicion" type="date"
                       data-nombre-campo="Fecha de adquisición"
                       onchange="limpiarErrorInline(this)"
                       class="{{ $errors->has('fecha_adquisicion') ? 'input-error' : '' }}"
                       value="{{ old('fecha_adquisicion', date('Y-m-d')) }}">
                <span class="error-inline" data-for="fecha_adquisicion"></span>
                @error('fecha_adquisicion') <span class="error-msg">{{ $message }}</span> @enderror
            </label>

            {{-- ⭐ Valor de adquisición --}}
            <label>Valor de adquisición (Bs)
                <input name="valor_adquisicion" type="number" step="0.01" min="0"
                       data-nombre-campo="Valor de adquisición"
                       oninput="limpiarErrorInline(this)"
                       class="{{ $errors->has('valor_adquisicion') ? 'input-error' : '' }}"
                       value="{{ old('valor_adquisicion', 0) }}" placeholder="0.00">
                <span class="error-inline" data-for="valor_adquisicion"></span>
                @error('valor_adquisicion') <span class="error-msg">{{ $message }}</span> @enderror
            </label>

            {{-- ⭐ Custodio — el ítem es de la persona, se busca por nombre, C.I. o ítem --}}
            <label class="full">Custodio *
                <x-person-picker
                    name="id_custodio"
                    id="custodioActivo"
                    :required="true" />
                @error('id_custodio') <span class="error-msg">{{ $message }}</span> @enderror
            </label>

            {{-- ============ DETALLES ============ --}}
            <div class="section-title">Detalles y archivos</div>

            {{-- ⭐ Descripción --}}
            <label class="full">Descripción / Características técnicas
                <textarea name="descripcion" rows="3"
                          data-nombre-campo="Descripción"
                          oninput="limpiarErrorInline(this)"
                          class="{{ $errors->has('descripcion') ? 'input-error' : '' }}"
                          placeholder="Ej: Procesador Intel i5 44-4460, 3.20 GHz, RAM 4GB...">{{ old('descripcion') }}</textarea>
                <span class="error-inline" data-for="descripcion"></span>
                @error('descripcion') <span class="error-msg">{{ $message }}</span> @enderror
            </label>

            {{-- ⭐ Imagen --}}
            <label class="full">Imagen del activo
                <input name="imagen" type="file" accept="image/*"
                       onchange="limpiarErrorInline(this)"
                       class="{{ $errors->has('imagen') ? 'input-error' : '' }}">
                <small style="font-weight:400;color:#64748b;font-size:10px;">JPG, PNG o WEBP. Máx 5 MB.</small>
                <span class="error-inline" data-for="imagen"></span>
                @error('imagen') <span class="error-msg">{{ $message }}</span> @enderror
            </label>
        </div>

        <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:24px;border-top:1px solid #e2e8f0;padding-top:18px;">
            <button type="button" onclick="history.back()"
                style="background:#e2e8f0;color:#475569;border:none;padding:11px 22px;border-radius:8px;font-weight:700;cursor:pointer;">
                Cancelar
            </button>
            <button type="submit" id="btn-guardar"
                style="background:#2563eb;color:white;border:none;padding:11px 22px;border-radius:8px;font-weight:700;cursor:pointer;">
                💾 Guardar Activo
            </button>
        </div>
    </form>
</div>

<script>
    // ============================================
    // ⭐ LIMPIAR ERROR INLINE AL ESCRIBIR
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
        if (input.type === 'file' && input.files && input.files.length > 0) {
            input.classList.remove('input-error');
        }
    }

    // ============================================
    // ⭐ VERIFICAR CÓDIGO DUPLICADO (AJAX)
    // ============================================
    let timeoutCodigo = null;
    function verificarCodigo() {
        clearTimeout(timeoutCodigo);
        timeoutCodigo = setTimeout(async () => {
            const input = document.getElementById('codigo_activo');
            const feedback = document.getElementById('codigo-feedback');
            const valor = input.value.trim();

            if (!valor || valor.length < 3) {
                feedback.textContent = '';
                input.classList.remove('codigo-ok', 'input-error');
                return;
            }

            try {
                const res = await fetch('{{ route("activos.buscarPorCodigo") }}?codigo=' + encodeURIComponent(valor), {
                    headers: { 'Accept': 'application/json' }
                });
                const json = await res.json();

                if (json.success) {
                    input.classList.remove('codigo-ok');
                    input.classList.add('input-error');
                    feedback.style.color = '#dc2626';
                    feedback.textContent = '⚠️ Este código ya está registrado.';
                } else {
                    input.classList.remove('input-error');
                    input.classList.add('codigo-ok');
                    feedback.style.color = '#10b981';
                    feedback.textContent = '✓ Código disponible';
                }
            } catch (err) {
                feedback.textContent = '';
            }
        }, 500);
    }

    // ============================================
    // ⭐ VALIDACIÓN COMPLETA ANTES DE ENVIAR
    // ============================================
    document.getElementById('activo-form')?.addEventListener('submit', function(e) {
        let hayErrores = false;

        // Limpiar errores previos
        document.querySelectorAll('.error-inline').forEach(el => {
            el.classList.remove('visible');
            el.textContent = '';
        });
        document.querySelectorAll('#activo-form .input-error').forEach(el => {
            el.classList.remove('input-error');
        });

        // Función auxiliar
        function marcarError(campo, mensaje) {
            const errorSpan = document.querySelector('.error-inline[data-for="' + campo.name + '"]');
            if (errorSpan) {
                errorSpan.textContent = '⚠️ ' + mensaje;
                errorSpan.classList.add('visible');
            }
            campo.classList.add('input-error');
            hayErrores = true;
        }

        // =============================================
        // 1. CAMPOS OBLIGATORIOS
        // =============================================
        document.querySelectorAll('#activo-form [data-requerido="true"]').forEach(campo => {
            const valor = (campo.value || '').trim();
            const nombreCampo = campo.dataset.nombreCampo || campo.name;

            if (valor === '') {
                marcarError(campo, 'El campo "' + nombreCampo + '" es obligatorio.');
                return;
            }

            if (campo.name === 'codigo_activo' && valor.length < 3) {
                marcarError(campo, 'El código debe tener al menos 3 caracteres.');
                return;
            }
        });

        // =============================================
        // 2. CANTIDAD (1-100)
        // =============================================
        const cantidad = document.querySelector('[name="cantidad"]');
        if (cantidad) {
            const v = parseInt(cantidad.value);
            if (!v || v < 1) {
                marcarError(cantidad, 'La cantidad debe ser al menos 1.');
            } else if (v > 100) {
                marcarError(cantidad, 'La cantidad no puede superar 100.');
            }
        }

        // =============================================
        // 3. FUENTE DE FINANCIAMIENTO (obligatorio)
        // =============================================
        const fuente = document.querySelector('[name="id_fuente"]');
        if (fuente && !fuente.value) {
            marcarError(fuente, 'Debe seleccionar una fuente de financiamiento.');
        }

        // =============================================
        // 4. ESTADO FÍSICO (obligatorio)
        // =============================================
        const estado = document.querySelector('[name="estado_fisico"]');
        if (estado && !estado.value) {
            marcarError(estado, 'Debe seleccionar un estado físico.');
        }

        // =============================================
        // 5. MARCA (obligatorio, mín 2)
        // =============================================
        const marca = document.querySelector('[name="marca"]');
        if (marca) {
            const v = marca.value.trim();
            if (v === '') {
                marcarError(marca, 'La marca es obligatoria.');
            } else if (v.length < 2) {
                marcarError(marca, 'La marca debe tener al menos 2 caracteres.');
            }
        }

        // =============================================
        // 6. MODELO (obligatorio, mín 2)
        // =============================================
        const modelo = document.querySelector('[name="modelo"]');
        if (modelo) {
            const v = modelo.value.trim();
            if (v === '') {
                marcarError(modelo, 'El modelo es obligatorio.');
            } else if (v.length < 2) {
                marcarError(modelo, 'El modelo debe tener al menos 2 caracteres.');
            }
        }

        // =============================================
        // 7. N° DE SERIE (obligatorio)
        // =============================================
        const serie = document.querySelector('[name="numero_serie"]');
        if (serie && !serie.value.trim()) {
            marcarError(serie, 'El N° de serie es obligatorio.');
        }

        // =============================================
        // 8. FECHA DE ADQUISICIÓN (obligatorio)
        // =============================================
        const fecha = document.querySelector('[name="fecha_adquisicion"]');
        if (fecha && !fecha.value) {
            marcarError(fecha, 'La fecha de adquisición es obligatoria.');
        }

        // =============================================
        // 9. VALOR DE ADQUISICIÓN (obligatorio, ≥0)
        // =============================================
        const valor = document.querySelector('[name="valor_adquisicion"]');
        if (valor) {
            const v = parseFloat(valor.value);
            if (valor.value === '' || isNaN(v)) {
                marcarError(valor, 'El valor de adquisición es obligatorio.');
            } else if (v < 0) {
                marcarError(valor, 'El valor no puede ser negativo.');
            }
        }

        // =============================================
        // 10. CUSTODIO (obligatorio)
        // =============================================
        const custodio = window.PersonPicker?.valor('custodioActivo');
        if (custodio && !custodio.value) {
            window.PersonPicker?.marcarError('custodioActivo', true);
        }

        // =============================================
        // 11. DESCRIPCIÓN (obligatorio, mín 5)
        // =============================================
        const descripcion = document.querySelector('[name="descripcion"]');
        if (descripcion) {
            const v = descripcion.value.trim();
            if (v === '') {
                marcarError(descripcion, 'La descripción es obligatoria.');
            } else if (v.length < 5) {
                marcarError(descripcion, 'La descripción debe tener al menos 5 caracteres.');
            }
        }

        // =============================================
        // 12. IMAGEN (opcional, validar si sube)
        // =============================================
        const imagen = document.querySelector('[name="imagen"]');
        if (imagen && imagen.files && imagen.files.length > 0) {
            const file = imagen.files[0];
            const tipos = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
            const maxSize = 5 * 1024 * 1024;

            if (!tipos.includes(file.type)) {
                marcarError(imagen, 'La imagen debe ser JPG, PNG o WEBP.');
            } else if (file.size > maxSize) {
                marcarError(imagen, 'La imagen no debe pesar más de 5 MB.');
            }
        }

        // =============================================
        // RESULTADO
        // =============================================
        if (hayErrores) {
            e.preventDefault();

            const contenedor = document.getElementById('cliente-errores');
            const lista = document.getElementById('cliente-errores-lista');
            const totalErrores = document.querySelectorAll('.error-inline.visible').length;
            lista.innerHTML = '<li>Hay ' + totalErrores + ' campo(s) con errores. Revisa los mensajes debajo de cada campo.</li>';
            contenedor.style.display = 'block';

            const primerError = document.querySelector('#activo-form .input-error');
            if (primerError) {
                primerError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                primerError.focus();
            }

            return false;
        }

        // Todo OK
        document.getElementById('cliente-errores').style.display = 'none';
        const btn = document.getElementById('btn-guardar');
        btn.disabled = true;
        btn.textContent = '⏳ Guardando...';
    });
    document.addEventListener('DOMContentLoaded', function() {
        const inputCodigo = document.querySelector('input[name="codigo_activo"]');
        if (inputCodigo && !inputCodigo.value) {
            const prefijoGuardado = localStorage.getItem('sisactivos_prefijo') || 'TPM-';
            const randomNum = Math.floor(100000 + Math.random() * 900000);
            inputCodigo.value = prefijoGuardado + randomNum;
        }
    });
</script>
<script>
// Tipo de bien: marca, modelo y serie dejan de ser obligatorios en no activos
(function () {
    var radios = Array.from(document.querySelectorAll('[data-radio-tipo]'));
    var opcionNoActivo = document.getElementById('opcion-no-activo');
    var avisoSerie = document.getElementById('aviso-serie');

    function aplicar() {
        var esNoActivo = document.querySelector('[data-radio-tipo]:checked')?.value === 'NO_ACTIVO';

        if (opcionNoActivo) {
            opcionNoActivo.style.borderColor = esNoActivo ? '#f59e0b' : '#cbd5e1';
            opcionNoActivo.style.background = esNoActivo ? '#fffbeb' : '#fff';
        }

        if (avisoSerie) avisoSerie.style.display = esNoActivo ? 'block' : 'none';

        ['marca', 'modelo', 'numero_serie'].forEach(function (campo) {
            const input = document.querySelector('[name="' + campo + '"]');
            if (!input) return;
            if (esNoActivo) {
                input.dataset.requeridoPrevio = 'true';
                input.removeAttribute('data-requerido');
                input.required = false;
            } else if (input.dataset.requeridoPrevio === 'true') {
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
