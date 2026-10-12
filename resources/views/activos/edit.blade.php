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

<<<<<<< HEAD
    {{-- ERRORES DEL SERVIDOR --}}
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

    {{-- ⭐ GALERÍA DE IMÁGENES ACTUALES --}}
    <div id="galeria-imagenes" style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;padding:16px;margin-bottom:20px;">
        <div style="font-size:12px;font-weight:800;color:#2563eb;text-transform:uppercase;margin-bottom:12px;">
            📷 Fotografías actuales
        </div>

        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px;">
            {{-- Frontal --}}
            <div>
                <div style="font-size:11px;font-weight:700;color:#475569;margin-bottom:6px;">Frontal</div>
                @if($activo->imagen)
                    <img src="{{ asset('storage/' . $activo->imagen) }}" alt="Frontal"
                         style="width:100%;height:120px;object-fit:cover;border-radius:8px;border:1px solid #cbd5e1;">
                @else
                    <div style="width:100%;height:120px;border:2px dashed #cbd5e1;border-radius:8px;display:flex;align-items:center;justify-content:center;color:#94a3b8;font-size:11px;">
                        Sin imagen
                    </div>
                @endif
            </div>

            {{-- Lateral --}}
            <div id="galeria-lateral">
                <div style="font-size:11px;font-weight:700;color:#475569;margin-bottom:6px;">Lateral</div>
                @if($activo->imagen_lateral)
                    <img src="{{ asset('storage/' . $activo->imagen_lateral) }}" alt="Lateral"
                         style="width:100%;height:120px;object-fit:cover;border-radius:8px;border:1px solid #cbd5e1;">
                @else
                    <div style="width:100%;height:120px;border:2px dashed #cbd5e1;border-radius:8px;display:flex;align-items:center;justify-content:center;color:#94a3b8;font-size:11px;">
                        Sin imagen
                    </div>
                @endif
            </div>

            {{-- Detalle --}}
            <div id="galeria-detalle">
                <div style="font-size:11px;font-weight:700;color:#475569;margin-bottom:6px;">Detalle</div>
                @if($activo->imagen_detalle)
                    <img src="{{ asset('storage/' . $activo->imagen_detalle) }}" alt="Detalle"
                         style="width:100%;height:120px;object-fit:cover;border-radius:8px;border:1px solid #cbd5e1;">
                @else
                    <div style="width:100%;height:120px;border:2px dashed #cbd5e1;border-radius:8px;display:flex;align-items:center;justify-content:center;color:#94a3b8;font-size:11px;">
                        Sin imagen
                    </div>
                @endif
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('activos.update', $activo->id_activo) }}" enctype="multipart/form-data" id="activo-edit-form">
=======
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
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
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
<<<<<<< HEAD
            .error-msg { color:#dc2626; font-size:11px; font-weight:600; margin-top:2px; display:none; }
            .error-msg.visible { display:block; }
            .asterisco { color:#dc2626; margin-left:2px; display:none; }
            .asterisco.visible { display:inline; }

            /* Preview de imágenes */
            .img-preview {
                width: 100%; height: 130px; border: 2px dashed #cbd5e1; border-radius: 10px;
                display: flex; align-items: center; justify-content: center; background: #f8fafc;
                margin-bottom: 8px; overflow: hidden; transition: all 0.2s;
            }
            .img-preview.has-image {
                border-style: solid; border-color: #10b981;
            }
            .img-preview img {
                width: 100%; height: 100%; object-fit: cover; border-radius: 8px;
            }
            .img-preview .placeholder {
                text-align: center; color: #94a3b8;
            }
=======
            .error-msg { color:#dc2626; font-size:11px; font-weight:600; margin-top:2px; display:block; }
            .error-inline { color:#dc2626; font-size:11px; font-weight:600; margin-top:3px; display:none; }
            .error-inline.visible { display:block; }
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
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
<<<<<<< HEAD
                                Se capitaliza. Marca, modelo, serie y 3 fotos obligatorias.
=======
                                Se capitaliza. Equipos, máquinas, endblocklos.
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
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
<<<<<<< HEAD
                                No se capitaliza. Solo 1 foto, marca/modelo/serie opcionales.
=======
                                Se inventaría pero no se capitaliza. Escobas, papeleras, engrampadoras.
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
                            </small>
                        </span>
                    </label>
                </div>

                <small id="aviso-serie" style="display:none;margin-top:9px;color:#b45309;font-size:11px;">
<<<<<<< HEAD
                    En los no activos, la marca, el modelo y el número de serie no son obligatorios.
                </small>
            </div>

            <label>Código del activo *
                <input name="codigo_activo" id="codigo_activo" maxlength="50"
                       value="{{ old('codigo_activo', $activo->codigo_activo) }}">
                <span class="error-msg" data-for="codigo_activo"></span>
            </label>

            <label>N° de serie <span class="asterisco" id="req-serie">*</span>
                <input name="numero_serie" id="numero_serie" maxlength="80"
                       value="{{ old('numero_serie', $activo->numero_serie) }}">
                <span class="error-msg" data-for="numero_serie"></span>
            </label>

            <label class="full">Nombre del activo *
                <input name="nombre" id="nombre" maxlength="150"
                       value="{{ old('nombre', $activo->nombre) }}">
                <span class="error-msg" data-for="nombre"></span>
=======
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
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
            </label>

            {{-- ============ CLASIFICACIÓN ============ --}}
            <div class="section-title">Clasificación</div>

            <label>Categoría *
<<<<<<< HEAD
                <select name="id_categoria" id="id_categoria">
=======
                <select name="id_categoria" required
                        data-requerido="true"
                        data-nombre-campo="Categoría"
                        onchange="limpiarErrorInline(this)"
                        class="{{ $errors->has('id_categoria') ? 'input-error' : '' }}">
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
                    <option value="">— Seleccione —</option>
                    @foreach ($categorias as $item)
                        <option value="{{ $item->id_categoria }}"
                            {{ old('id_categoria', $activo->id_categoria) == $item->id_categoria ? 'selected' : '' }}>
                            {{ $item->nombre }}
                        </option>
                    @endforeach
                </select>
<<<<<<< HEAD
                <span class="error-msg" data-for="id_categoria"></span>
            </label>

            <label>Ambiente *
                <select name="id_ambiente" id="id_ambiente">
=======
                <span class="error-inline" data-for="id_categoria"></span>
                @error('id_categoria') <span class="error-msg">{{ $message }}</span> @enderror
            </label>

            <label>Ambiente *
                <select name="id_ambiente" required
                        data-requerido="true"
                        data-nombre-campo="Ambiente"
                        onchange="limpiarErrorInline(this)"
                        class="{{ $errors->has('id_ambiente') ? 'input-error' : '' }}">
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
                    <option value="">— Seleccione —</option>
                    @foreach ($ambientes as $item)
                        <option value="{{ $item->id_ambiente }}"
                            {{ old('id_ambiente', $activo->id_ambiente) == $item->id_ambiente ? 'selected' : '' }}>
                            {{ $item->nombre }}
                        </option>
                    @endforeach
                </select>
<<<<<<< HEAD
                <span class="error-msg" data-for="id_ambiente"></span>
            </label>

            <label>Fuente de financiamiento *
                <select name="id_fuente" id="id_fuente">
=======
                <span class="error-inline" data-for="id_ambiente"></span>
                @error('id_ambiente') <span class="error-msg">{{ $message }}</span> @enderror
            </label>

            <label>Fuente de financiamiento
                <select name="id_fuente"
                        onchange="limpiarErrorInline(this)"
                        class="{{ $errors->has('id_fuente') ? 'input-error' : '' }}">
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
                    <option value="">— Seleccione —</option>
                    @foreach ($fuentes as $item)
                        <option value="{{ $item->id_fuente }}"
                            {{ old('id_fuente', $activo->id_fuente) == $item->id_fuente ? 'selected' : '' }}>
                            {{ $item->codigo ? $item->codigo . ' - ' : '' }}{{ $item->nombre }}
                        </option>
                    @endforeach
                </select>
<<<<<<< HEAD
                <span class="error-msg" data-for="id_fuente"></span>
=======
                <span class="error-inline" data-for="id_fuente"></span>
                @error('id_fuente') <span class="error-msg">{{ $message }}</span> @enderror
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
            </label>

            <label>Custodio *
                <x-person-picker
                    name="id_custodio"
                    id="custodioActivo"
                    :selected-id="old('id_custodio', $activo->id_custodio)"
                    :selected-texto="$activo->custodio?->nombre_completo"
                    :required="true" />
<<<<<<< HEAD
                <span class="error-msg" data-for="id_custodio"></span>
=======
                <span class="error-inline" data-for="id_custodio"></span>
                @error('id_custodio') <span class="error-msg">{{ $message }}</span> @enderror
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
            </label>

            {{-- ============ ESPECIFICACIONES ============ --}}
            <div class="section-title">Especificaciones técnicas</div>

<<<<<<< HEAD
            <label>Marca <span class="asterisco" id="req-marca">*</span>
                <input name="marca" id="marca" maxlength="80"
                       value="{{ old('marca', $activo->marca) }}">
                <span class="error-msg" data-for="marca"></span>
            </label>

            <label>Modelo <span class="asterisco" id="req-modelo">*</span>
                <input name="modelo" id="modelo" maxlength="80"
                       value="{{ old('modelo', $activo->modelo) }}">
                <span class="error-msg" data-for="modelo"></span>
            </label>

            <label>Fecha de adquisición *
                <input name="fecha_adquisicion" id="fecha_adquisicion" type="date"
                       value="{{ old('fecha_adquisicion', optional($activo->fecha_adquisicion)->format('Y-m-d')) }}">
                <span class="error-msg" data-for="fecha_adquisicion"></span>
            </label>

            <label>Valor de adquisición (Bs) *
                <input name="valor_adquisicion" id="valor_adquisicion" type="number" min="0" step="0.01"
                       value="{{ old('valor_adquisicion', $activo->valor_adquisicion) }}">
                <span class="error-msg" data-for="valor_adquisicion"></span>
            </label>

            <label>Estado físico *
                <select name="estado_fisico" id="estado_fisico">
=======
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
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
                    <option value="B"  {{ old('estado_fisico', $activo->estado_fisico) == 'B'  ? 'selected' : '' }}>Bueno</option>
                    <option value="R"  {{ old('estado_fisico', $activo->estado_fisico) == 'R'  ? 'selected' : '' }}>Regular</option>
                    <option value="M"  {{ old('estado_fisico', $activo->estado_fisico) == 'M'  ? 'selected' : '' }}>Malo</option>
                    <option value="FF" {{ old('estado_fisico', $activo->estado_fisico) == 'FF' ? 'selected' : '' }}>Fuera de funcionamiento</option>
                </select>
<<<<<<< HEAD
                <span class="error-msg" data-for="estado_fisico"></span>
            </label>

            <label>Estado de registro *
                <select name="estado_registro" id="estado_registro">
=======
                <span class="error-inline" data-for="estado_fisico"></span>
                @error('estado_fisico') <span class="error-msg">{{ $message }}</span> @enderror
            </label>

            <label>Estado de registro
                <select name="estado_registro"
                        onchange="limpiarErrorInline(this)"
                        class="{{ $errors->has('estado_registro') ? 'input-error' : '' }}">
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
                    <option value="ACTIVO"           {{ old('estado_registro', $activo->estado_registro) == 'ACTIVO'           ? 'selected' : '' }}>Activo</option>
                    <option value="ASIGNADO"         {{ old('estado_registro', $activo->estado_registro) == 'ASIGNADO'         ? 'selected' : '' }}>Asignado</option>
                    <option value="EN_TRANSFERENCIA" {{ old('estado_registro', $activo->estado_registro) == 'EN_TRANSFERENCIA' ? 'selected' : '' }}>En transferencia</option>
                    <option value="BAJA"             {{ old('estado_registro', $activo->estado_registro) == 'BAJA'             ? 'selected' : '' }}>Baja</option>
                </select>
<<<<<<< HEAD
                <span class="error-msg" data-for="estado_registro"></span>
            </label>

            {{-- ============ FOTOGRAFÍAS ============ --}}
            <div class="section-title">📷 Reemplazar fotografías (opcional)</div>

            <label id="bloque-frontal">Foto Frontal <span class="asterisco" id="req-frontal">*</span>
                <div id="preview-frontal" class="img-preview">
                    <div class="placeholder">
                        <div style="font-size: 28px; margin-bottom: 4px;">📷</div>
                        <div style="font-size: 11px;">Dejar vacío para mantener la actual</div>
                    </div>
                </div>
                <input type="file" name="imagen" id="imagen" accept="image/*"
                       onchange="previewImage(this, 'preview-frontal')">
                <small style="font-weight:400;color:#64748b;font-size:10px;">JPG, PNG o WEBP. Máx 5 MB.</small>
                <span class="error-msg" data-for="imagen"></span>
            </label>

            <label id="bloque-lateral">Foto Lateral <span class="asterisco" id="req-lateral">*</span>
                <div id="preview-lateral" class="img-preview">
                    <div class="placeholder">
                        <div style="font-size: 28px; margin-bottom: 4px;">📷</div>
                        <div style="font-size: 11px;">Dejar vacío para mantener la actual</div>
                    </div>
                </div>
                <input type="file" name="imagen_lateral" id="imagen_lateral" accept="image/*"
                       onchange="previewImage(this, 'preview-lateral')">
                <small style="font-weight:400;color:#64748b;font-size:10px;">JPG, PNG o WEBP. Máx 5 MB.</small>
                <span class="error-msg" data-for="imagen_lateral"></span>
            </label>

            <label id="bloque-detalle" class="full">Foto de Detalle <span class="asterisco" id="req-detalle">*</span>
                <div id="preview-detalle" class="img-preview">
                    <div class="placeholder">
                        <div style="font-size: 28px; margin-bottom: 4px;">📷</div>
                        <div style="font-size: 11px;">Dejar vacío para mantener la actual</div>
                    </div>
                </div>
                <input type="file" name="imagen_detalle" id="imagen_detalle" accept="image/*"
                       onchange="previewImage(this, 'preview-detalle')">
                <small style="font-weight:400;color:#64748b;font-size:10px;">JPG, PNG o WEBP. Máx 5 MB.</small>
                <span class="error-msg" data-for="imagen_detalle"></span>
            </label>

            {{-- ============ DETALLES ============ --}}
            <div class="section-title">Detalles y descripción</div>

            <label class="full">Descripción / Características técnicas *
                <textarea name="descripcion" id="descripcion" rows="3">{{ old('descripcion', $activo->descripcion) }}</textarea>
                <span class="error-msg" data-for="descripcion"></span>
=======
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
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
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
<<<<<<< HEAD
    // PREVIEW DE IMÁGENES
    // ============================================
    function previewImage(input, previewId) {
        const preview = document.getElementById(previewId);
        if (!preview) return;

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
                preview.classList.add('has-image');
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.innerHTML = `
                <div class="placeholder">
                    <div style="font-size: 28px; margin-bottom: 4px;">📷</div>
                    <div style="font-size: 11px;">Dejar vacío para mantener la actual</div>
                </div>
            `;
            preview.classList.remove('has-image');
=======
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
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
        }
    }

    // ============================================
<<<<<<< HEAD
    // LIMPIAR ERROR INLINE
    // ============================================
    function limpiarError(campo) {
        const span = document.querySelector('.error-msg[data-for="' + campo.id + '"]');
        if (span) {
            span.classList.remove('visible');
            span.textContent = '';
        }
        campo.classList.remove('input-error');
    }

    // Al escribir/cambiar cualquier campo, limpiar su error
    document.querySelectorAll('#activo-edit-form input, #activo-edit-form select, #activo-edit-form textarea').forEach(el => {
        if (!el.id) return;
        el.addEventListener('input', () => limpiarError(el));
        el.addEventListener('change', () => limpiarError(el));
    });

    // ============================================
    // TIPO DE BIEN — Dinámico
    // ============================================
    function aplicarTipoBien(tipo) {
        const esFijo = tipo === 'ACTIVO_FIJO';

        // Tarjetas visuales
        const cardFijo = document.getElementById('opcion-activo-fijo');
        const cardNoActivo = document.getElementById('opcion-no-activo');
        if (cardFijo) {
            cardFijo.style.borderColor = esFijo ? '#2563eb' : '#cbd5e1';
            cardFijo.style.background = esFijo ? '#eff6ff' : '#fff';
        }
        if (cardNoActivo) {
            cardNoActivo.style.borderColor = !esFijo ? '#f59e0b' : '#cbd5e1';
            cardNoActivo.style.background = !esFijo ? '#fffbeb' : '#fff';
        }

        // Aviso
        const aviso = document.getElementById('aviso-serie');
        if (aviso) aviso.style.display = esFijo ? 'none' : 'block';

        // Asteriscos marca/modelo/serie/frontal
        ['req-marca','req-modelo','req-serie'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.classList.toggle('visible', esFijo);
        });
        const reqFrontal = document.getElementById('req-frontal');
        if (reqFrontal) reqFrontal.classList.toggle('visible', esFijo);

        // Bloques lateral y detalle (solo ACTIVO_FIJO)
        const bloqueLateral = document.getElementById('bloque-lateral');
        const bloqueDetalle = document.getElementById('bloque-detalle');
        if (bloqueLateral) bloqueLateral.style.display = esFijo ? 'flex' : 'none';
        if (bloqueDetalle) bloqueDetalle.style.display = esFijo ? 'flex' : 'none';

        // Asteriscos lateral y detalle
        ['req-lateral','req-detalle'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.classList.toggle('visible', esFijo);
        });

        // Ocultar bloques de galería lateral y detalle
        const galeriaLateral = document.getElementById('galeria-lateral');
        const galeriaDetalle = document.getElementById('galeria-detalle');
        if (galeriaLateral) galeriaLateral.style.display = esFijo ? 'block' : 'none';
        if (galeriaDetalle) galeriaDetalle.style.display = esFijo ? 'block' : 'none';

        // Ajustar la grilla de la galería según tipo
        const galeria = document.getElementById('galeria-imagenes');
        if (galeria) {
            const grilla = galeria.querySelector('div[style*="grid-template-columns"]');
            if (grilla) {
                grilla.style.gridTemplateColumns = esFijo ? 'repeat(3, 1fr)' : '1fr';
            }
        }

        // Si pasa a NO_ACTIVO, limpiar errores de marca/modelo/serie
        if (!esFijo) {
            ['marca','modelo','numero_serie'].forEach(id => {
                const campo = document.getElementById(id);
                if (campo) limpiarError(campo);
            });
        }
    }

    document.querySelectorAll('[data-radio-tipo]').forEach(r => {
        r.addEventListener('change', () => aplicarTipoBien(r.value));
    });

    // Aplicar al cargar
    (function() {
        const checked = document.querySelector('[data-radio-tipo]:checked');
        aplicarTipoBien(checked ? checked.value : 'ACTIVO_FIJO');
    })();

    // ============================================
    // VALIDACIÓN AL ENVIAR
=======
    // VALIDACIÓN ESTRICTA ANTES DE ENVIAR
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
    // ============================================
    document.getElementById('activo-edit-form')?.addEventListener('submit', function(e) {
        let hayErrores = false;

<<<<<<< HEAD
        // Limpiar errores previos
        document.querySelectorAll('#activo-edit-form .error-msg').forEach(el => {
=======
        document.querySelectorAll('.error-inline').forEach(el => {
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
            el.classList.remove('visible');
            el.textContent = '';
        });
        document.querySelectorAll('#activo-edit-form .input-error').forEach(el => {
            el.classList.remove('input-error');
        });

<<<<<<< HEAD
        function marcar(campoId, mensaje) {
            const campo = document.getElementById(campoId);
            const span = document.querySelector('.error-msg[data-for="' + campoId + '"]');
            if (span) {
                span.textContent = '⚠️ ' + mensaje;
                span.classList.add('visible');
            }
            if (campo) campo.classList.add('input-error');
            hayErrores = true;
        }

        const tipo = document.querySelector('[data-radio-tipo]:checked')?.value || 'ACTIVO_FIJO';
        const esFijo = tipo === 'ACTIVO_FIJO';

        // Campos base obligatorios
        const requeridosBase = [
            { id: 'codigo_activo', msg: 'El código es obligatorio.' },
            { id: 'nombre', msg: 'El nombre es obligatorio.' },
            { id: 'id_categoria', msg: 'Selecciona una categoría.' },
            { id: 'id_ambiente', msg: 'Selecciona un ambiente.' },
            { id: 'id_fuente', msg: 'Selecciona una fuente de financiamiento.' },
            { id: 'estado_fisico', msg: 'Selecciona un estado físico.' },
            { id: 'estado_registro', msg: 'Selecciona un estado de registro.' },
            { id: 'fecha_adquisicion', msg: 'La fecha de adquisición es obligatoria.' },
            { id: 'valor_adquisicion', msg: 'El valor es obligatorio.' },
            { id: 'descripcion', msg: 'La descripción es obligatoria.' },
        ];

        requeridosBase.forEach(({ id, msg }) => {
            const campo = document.getElementById(id);
            if (!campo) return;
            if ((campo.value || '').trim() === '') marcar(id, msg);
        });

        // Custodio (componente x-person-picker)
        const custodio = document.querySelector('[name="id_custodio"]');
        if (custodio && (custodio.value || '').trim() === '') {
            marcar('custodioActivo', 'Selecciona un custodio responsable.');
        }

        // Si es ACTIVO_FIJO
        if (esFijo) {
            ['marca','modelo','numero_serie'].forEach(id => {
                const campo = document.getElementById(id);
                if (!campo) return;
                if ((campo.value || '').trim() === '') {
                    const nombre = id === 'numero_serie' ? 'N° de serie' : id.charAt(0).toUpperCase() + id.slice(1);
                    marcar(id, 'La ' + nombre + ' es obligatoria para Activo Fijo.');
                }
            });
        }

        if (hayErrores) {
            e.preventDefault();
=======
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

>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
            const primerError = document.querySelector('#activo-edit-form .input-error');
            if (primerError) {
                primerError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                primerError.focus();
            }
            return false;
        }

<<<<<<< HEAD
        // Deshabilitar botón para evitar doble envío
=======
        document.getElementById('cliente-errores').style.display = 'none';
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
        const btn = document.getElementById('btn-guardar-edit');
        btn.disabled = true;
        btn.textContent = '⏳ Guardando...';
    });
</script>
<<<<<<< HEAD
=======

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
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
@endsection
