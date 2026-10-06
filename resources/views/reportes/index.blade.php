@extends('layouts.app')

@section('title', 'Centro de Reportes')

@section('content')
<div class="container-fluid px-4 py-4">

    {{-- ============================================================ --}}
    {{-- ENCABEZADO CORPORATIVO --}}
    {{-- ============================================================ --}}
    <div style="background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%); padding: 30px; border-radius: 18px; color: white; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px; margin-bottom: 25px; box-shadow: 0 10px 20px -3px rgba(37, 99, 235, 0.25);">
        <div>
            <span style="background: rgba(255, 255, 255, 0.2); padding: 5px 12px; border-radius: 20px; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">Módulo Institucional</span>
            <h1 style="font-size: 26px; font-weight: 800; margin: 8px 0 4px 0;">Centro de Reportes e Inventarios</h1>
            <p style="opacity: 0.9; font-size: 14px; margin: 0;">Genera, visualiza y exporta inventarios generales, por ambiente, aula, carrera y actas oficiales.</p>
        </div>

        <div>
            <a href="{{ route('reportes.inventario.general') }}"
               style="background: white; color: #1e3a8a; padding: 12px 20px; border-radius: 12px; font-weight: 800; font-size: 13px; text-decoration: none; box-shadow: 0 4px 6px rgba(0,0,0,0.1); display: inline-flex; align-items: center; gap: 8px;">
                <span>📊</span> Inventario General
            </a>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- TARJETAS DE ESTADÍSTICAS (STATS) --}}
    {{-- ============================================================ --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; margin-bottom: 30px;">

        {{-- BUENOS --}}
        <div style="background: white; padding: 18px 20px; border-radius: 14px; border: 1px solid #e2e8f0; border-left: 5px solid #10b981; box-shadow: 0 2px 4px rgba(0,0,0,0.02); display: flex; align-items: center; justify-content: space-between;">
            <div>
                <div style="font-size: 24px; font-weight: 800; color: #0f172a;">{{ $activosPorEstado['B'] ?? 0 }}</div>
                <div style="font-size: 11px; font-weight: 700; color: #10b981; text-transform: uppercase; margin-top: 2px;">Buenos</div>
            </div>
            <span style="font-size: 20px; background: #dcfce7; padding: 10px; border-radius: 10px;">✅</span>
        </div>

        {{-- REGULARES --}}
        <div style="background: white; padding: 18px 20px; border-radius: 14px; border: 1px solid #e2e8f0; border-left: 5px solid #f59e0b; box-shadow: 0 2px 4px rgba(0,0,0,0.02); display: flex; align-items: center; justify-content: space-between;">
            <div>
                <div style="font-size: 24px; font-weight: 800; color: #0f172a;">{{ $activosPorEstado['R'] ?? 0 }}</div>
                <div style="font-size: 11px; font-weight: 700; color: #f59e0b; text-transform: uppercase; margin-top: 2px;">Regulares</div>
            </div>
            <span style="font-size: 20px; background: #fef9c3; padding: 10px; border-radius: 10px;">⚠️</span>
        </div>

        {{-- MALOS --}}
        <div style="background: white; padding: 18px 20px; border-radius: 14px; border: 1px solid #e2e8f0; border-left: 5px solid #f97316; box-shadow: 0 2px 4px rgba(0,0,0,0.02); display: flex; align-items: center; justify-content: space-between;">
            <div>
                <div style="font-size: 24px; font-weight: 800; color: #0f172a;">{{ $activosPorEstado['M'] ?? 0 }}</div>
                <div style="font-size: 11px; font-weight: 700; color: #f97316; text-transform: uppercase; margin-top: 2px;">Malos</div>
            </div>
            <span style="font-size: 20px; background: #ffedd5; padding: 10px; border-radius: 10px;">⚠</span>
        </div>

        {{-- FUERA DE SERVICIO --}}
        <div style="background: white; padding: 18px 20px; border-radius: 14px; border: 1px solid #e2e8f0; border-left: 5px solid #ef4444; box-shadow: 0 2px 4px rgba(0,0,0,0.02); display: flex; align-items: center; justify-content: space-between;">
            <div>
                <div style="font-size: 24px; font-weight: 800; color: #0f172a;">{{ $activosPorEstado['FF'] ?? 0 }}</div>
                <div style="font-size: 11px; font-weight: 700; color: #ef4444; text-transform: uppercase; margin-top: 2px;">Fuera de servicio</div>
            </div>
            <span style="font-size: 20px; background: #fee2e2; padding: 10px; border-radius: 10px;">❌</span>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- CUADRÍCULA DE REPORTES --}}
    {{-- ============================================================ --}}
    <h3 style="font-size: 18px; font-weight: 800; color: #0f172a; margin-bottom: 16px;">Inventarios y Reportes Específicos</h3>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 20px;">

        {{-- 1. INVENTARIO GENERAL --}}
        <div style="background: white; border-radius: 16px; border: 1px solid #e2e8f0; padding: 22px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                    <span style="background: #eff6ff; color: #2563eb; padding: 8px; border-radius: 10px; font-size: 18px;">📋</span>
                    <span style="font-size: 10px; font-weight: 800; color: #64748b; background: #f1f5f9; padding: 3px 8px; border-radius: 6px; text-transform: uppercase;">Principal</span>
                </div>
                <h4 style="font-size: 16px; font-weight: 800; color: #1e293b; margin: 0 0 4px 0;">Inventario General</h4>
                <p style="font-size: 13px; color: #64748b; margin: 0 0 16px 0;">Todos los activos registrados en el sistema institucional.</p>
            </div>
            <div style="display: flex; gap: 8px; border-top: 1px solid #f1f5f9; padding-top: 14px;">
                <a href="{{ route('reportes.inventario.general') }}" style="flex: 1; padding: 8px; background: #eff6ff; color: #1d4ed8; border-radius: 8px; font-size: 12px; font-weight: 700; text-align: center; text-decoration: none;">👁️ Ver</a>
                <a href="{{ route('reportes.inventario.general.pdf') }}" target="_blank" style="flex: 1; padding: 8px; background: #fee2e2; color: #991b1b; border-radius: 8px; font-size: 12px; font-weight: 700; text-align: center; text-decoration: none;">📄 PDF</a>
                <a href="{{ route('reportes.inventario.general.excel') }}" target="_blank" style="flex: 1; padding: 8px; background: #ecfdf5; color: #065f46; border-radius: 8px; font-size: 12px; font-weight: 700; text-align: center; text-decoration: none;">📊 Excel</a>
            </div>
        </div>

        {{-- 2. POR AMBIENTE --}}
        <div style="background: white; border-radius: 16px; border: 1px solid #e2e8f0; padding: 22px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                    <span style="background: #e0e7ff; color: #4f46e5; padding: 8px; border-radius: 10px; font-size: 18px;">🏢</span>
                    <span style="font-size: 10px; font-weight: 800; color: #64748b; background: #f1f5f9; padding: 3px 8px; border-radius: 6px; text-transform: uppercase;">Ubicación</span>
                </div>
                <h4 style="font-size: 16px; font-weight: 800; color: #1e293b; margin: 0 0 4px 0;">Inventario por Ambiente</h4>
                <p style="font-size: 13px; color: #64748b; margin: 0 0 16px 0;">Selecciona un ambiente específico para filtrar.</p>
            </div>
            <div style="border-top: 1px solid #f1f5f9; padding-top: 14px;">
                <select onchange="if(this.value) window.location.href='{{ url('reportes/por-ambiente') }}/'+this.value"
                        style="width: 100%; padding: 9px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 12px; background: #f8fafc; outline: none;">
                    <option value="">— Seleccionar ambiente —</option>
                    @foreach($ambientes as $a)
                        <option value="{{ $a->id_ambiente }}">{{ $a->nombre }} — {{ $a->carrera->nombre ?? 'Sin carrera' }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- 3. POR AULA --}}
        <div style="background: white; border-radius: 16px; border: 1px solid #e2e8f0; padding: 22px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                    <span style="background: #cffafe; color: #0891b2; padding: 8px; border-radius: 10px; font-size: 18px;">📖</span>
                    <span style="font-size: 10px; font-weight: 800; color: #64748b; background: #f1f5f9; padding: 3px 8px; border-radius: 6px; text-transform: uppercase;">Filtros</span>
                </div>
                <h4 style="font-size: 16px; font-weight: 800; color: #1e293b; margin: 0 0 4px 0;">Inventario por Aula</h4>
                <p style="font-size: 13px; color: #64748b; margin: 0 0 16px 0;">Filtra por equipos, sillas, mesas, etc.</p>
            </div>
            <div style="border-top: 1px solid #f1f5f9; padding-top: 14px;">
                <select onchange="if(this.value) window.location.href='{{ url('reportes/aula') }}/'+this.value"
                        style="width: 100%; padding: 9px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 12px; background: #f8fafc; outline: none;">
                    <option value="">— Seleccionar aula —</option>
                    @foreach($ambientes as $a)
                        <option value="{{ $a->id_ambiente }}">{{ $a->nombre }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- 4. POR CARRERA --}}
        <div style="background: white; border-radius: 16px; border: 1px solid #e2e8f0; padding: 22px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                    <span style="background: #ede9fe; color: #7c3aed; padding: 8px; border-radius: 10px; font-size: 18px;">🎓</span>
                    <span style="font-size: 10px; font-weight: 800; color: #64748b; background: #f1f5f9; padding: 3px 8px; border-radius: 6px; text-transform: uppercase;">Académico</span>
                </div>
                <h4 style="font-size: 16px; font-weight: 800; color: #1e293b; margin: 0 0 4px 0;">Inventario por Carrera</h4>
                <p style="font-size: 13px; color: #64748b; margin: 0 0 16px 0;">Resumen consolidado por cada carrera.</p>
            </div>
            <div style="border-top: 1px solid #f1f5f9; padding-top: 14px;">
                <select onchange="if(this.value) window.location.href='{{ url('reportes/carrera') }}/'+this.value"
                        style="width: 100%; padding: 9px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 12px; background: #f8fafc; outline: none;">
                    <option value="">— Seleccionar carrera —</option>
                    @foreach($carreras as $c)
                        <option value="{{ $c->id_carrera }}">{{ $c->nombre }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- 5. POR CATEGORÍA --}}
        <div style="background: white; border-radius: 16px; border: 1px solid #e2e8f0; padding: 22px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                    <span style="background: #fce7f3; color: #db2777; padding: 8px; border-radius: 10px; font-size: 18px;">📁</span>
                    <span style="font-size: 10px; font-weight: 800; color: #64748b; background: #f1f5f9; padding: 3px 8px; border-radius: 6px; text-transform: uppercase;">Clasificación</span>
                </div>
                <h4 style="font-size: 16px; font-weight: 800; color: #1e293b; margin: 0 0 4px 0;">Inventario por Categoría</h4>
                <p style="font-size: 13px; color: #64748b; margin: 0 0 16px 0;">Equipos, sillas, mesas, herramientas, etc.</p>
            </div>
            <div style="border-top: 1px solid #f1f5f9; padding-top: 14px;">
                <select onchange="if(this.value) window.location.href='{{ url('reportes/categoria') }}/'+this.value"
                        style="width: 100%; padding: 9px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 12px; background: #f8fafc; outline: none;">
                    <option value="">— Seleccionar categoría —</option>
                    @foreach($categorias as $cat)
                        <option value="{{ $cat->id_categoria }}">{{ $cat->nombre }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- 6. ACTAS Y DOCUMENTOS (DISEÑO BLANCO PROFESIONAL) --}}
        <div style="background: white; border-radius: 16px; border: 1px solid #e2e8f0; padding: 22px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                    <span style="background: #fef3c7; color: #d97706; padding: 8px; border-radius: 10px; font-size: 18px;">📜</span>
                    <span style="font-size: 10px; font-weight: 800; color: #64748b; background: #f1f5f9; padding: 3px 8px; border-radius: 6px; text-transform: uppercase;">Legal</span>
                </div>
                <h4 style="font-size: 16px; font-weight: 800; color: #1e293b; margin: 0 0 4px 0;">Actas y Documentos</h4>
                <p style="font-size: 13px; color: #64748b; margin: 0 0 16px 0;">Entrega, Alta, Baja, Transferencia, Liberación</p>
            </div>
            <div style="border-top: 1px solid #f1f5f9; padding-top: 14px; display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px;">
                <a href="{{ route('actas.recepcion.index') }}" style="padding: 8px; background: #f8fafc; color: #334155; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 11px; font-weight: 700; text-align: center; text-decoration: none;">Recepción</a>
                <a href="{{ route('actas.baja.index') }}" style="padding: 8px; background: #f8fafc; color: #334155; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 11px; font-weight: 700; text-align: center; text-decoration: none;">Baja</a>
                <a href="{{ route('actas.transferencia.index') }}" style="padding: 8px; background: #f8fafc; color: #334155; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 11px; font-weight: 700; text-align: center; text-decoration: none;">Transferencia</a>
                <a href="{{ route('actas.liberacion.index') }}" style="padding: 8px; background: #f8fafc; color: #334155; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 11px; font-weight: 700; text-align: center; text-decoration: none;">Liberación</a>
            </div>
        </div>

    </div>

</div>
@endsection
