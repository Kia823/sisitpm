<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ActivoFijo;
use App\Models\Ambiente;
use App\Models\Carrera;
use App\Models\Categoria;
use App\Models\FuenteFinanciamiento;
use App\Support\PdfHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
<<<<<<< HEAD
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
=======
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c

class ReporteController extends Controller
{
    // ============================================================
    // PANEL PRINCIPAL DE REPORTES
    // ============================================================
    public function index(Request $request)
    {
        $user = Auth::user();

<<<<<<< HEAD
        // Totales generales excluyendo los dados de baja
        $queryBase = ActivoFijo::paraUsuario($user)->where('estado_registro', '!=', 'BAJA');

        $totalBuenos    = (clone $queryBase)->where('estado_fisico', 'B')->count();
        $totalRegulares = (clone $queryBase)->where('estado_fisico', 'R')->count();
        $totalMalos     = (clone $queryBase)->where('estado_fisico', 'M')->count();
        $totalFueraServ = (clone $queryBase)->where('estado_fisico', 'FF')->count();

        $carreras   = Carrera::orderBy('nombre')->get();
        $ambientes  = Ambiente::with('carrera')->orderBy('nombre')->get();
        $categorias = Categoria::orderBy('nombre')->get();

        return view('reportes.index', compact(
            'totalBuenos', 'totalRegulares', 'totalMalos', 'totalFueraServ',
            'carreras', 'ambientes', 'categorias'
=======
        $carreras   = Carrera::withCount('ambientes')->orderBy('nombre')->get();
        $ambientes  = Auth::user()->ambientesVisibles()->with('carrera')->orderBy('nombre')->get();
        $categorias = Categoria::orderBy('nombre')->get();

        // Totales para el hero
        $query = ActivoFijo::paraUsuario($user);
        $activosPorEstado = [
            'B'  => (clone $query)->where('estado_fisico', 'B')->count(),
            'R'  => (clone $query)->where('estado_fisico', 'R')->count(),
            'M'  => (clone $query)->where('estado_fisico', 'M')->count(),
            'FF' => (clone $query)->where('estado_fisico', 'FF')->count(),
        ];

        return view('reportes.index', compact(
            'carreras', 'ambientes', 'categorias', 'activosPorEstado'
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
        ));
    }

    // ============================================================
    // 1. INVENTARIO GENERAL
    // ============================================================
    public function inventarioGeneral(Request $request)
    {
        $tipoBien = $this->tipoBienReporte($request);

<<<<<<< HEAD
        $query = ActivoFijo::query()
            ->selectRaw('
                GROUP_CONCAT(activos_fijos.codigo_activo ORDER BY activos_fijos.codigo_activo SEPARATOR " ") as codigos,
                GROUP_CONCAT(activos_fijos.id_activo ORDER BY activos_fijos.id_activo SEPARATOR ",") as ids_array,
                activos_fijos.nombre as descripcion,
                CONCAT_WS(", ",
                    activos_fijos.marca,
                    activos_fijos.modelo,
                    GROUP_CONCAT(DISTINCT activos_fijos.numero_serie ORDER BY activos_fijos.numero_serie SEPARATOR ", "),
                    activos_fijos.descripcion
                ) as caracteristicas,
                COUNT(*) as cantidad,
                SUM(activos_fijos.valor_adquisicion) as costo_total,
                activos_fijos.estado_fisico,
                fuentes_financiamiento.nombre as fuente,
                fuentes_financiamiento.codigo as fuente_codigo,
                MIN(activos_fijos.fecha_adquisicion) as fecha_entrega,
                carreras.nombre as carrera,
                activos_fijos.observaciones,
                activos_fijos.imagen
            ')
            ->join('categorias', 'activos_fijos.id_categoria', '=', 'categorias.id_categoria')
            ->join('ambientes', 'activos_fijos.id_ambiente', '=', 'ambientes.id_ambiente')
            ->join('carreras', 'ambientes.id_carrera', '=', 'carreras.id_carrera')
            ->leftJoin('fuentes_financiamiento', 'activos_fijos.id_fuente', '=', 'fuentes_financiamiento.id_fuente')
            ->where('activos_fijos.estado_registro', '!=', 'BAJA')
            ->tipoBien($tipoBien);

        if ($request->filled('carrera')) {
            $query->where('carreras.id_carrera', $request->carrera);
        }
        if ($request->filled('ambiente')) {
            $query->where('activos_fijos.id_ambiente', $request->ambiente);
        }
        if ($request->filled('estado_fisico')) {
            $query->where('activos_fijos.estado_fisico', $request->estado_fisico);
        }
        if ($request->filled('fuente')) {
            $query->where('activos_fijos.id_fuente', $request->fuente);
        }
        if ($request->filled('anio')) {
            $query->whereYear('activos_fijos.fecha_adquisicion', $request->anio);
        }

        $query->groupBy(
            'activos_fijos.nombre',
            'activos_fijos.marca',
            'activos_fijos.modelo',
            'activos_fijos.descripcion',
            'activos_fijos.estado_fisico',
            'fuentes_financiamiento.nombre',
            'carreras.nombre',
            'activos_fijos.observaciones',
            'activos_fijos.imagen'
        )
        ->orderBy('activos_fijos.modelo')
        ->orderBy('activos_fijos.marca')
        ->orderBy('activos_fijos.nombre');

        $reportes = $query->get()->map(function ($item, $index) {
            $fecha = $item->fecha_entrega;
            if (is_string($fecha)) {
                $fecha = Carbon::parse($fecha);
            }
            return (object) [
                'nro' => $index + 1,
                'codigos' => $item->codigos,
                'ids_array' => explode(',', $item->ids_array),
                'descripcion' => $item->descripcion,
                'caracteristicas' => $item->caracteristicas,
                'cantidad' => $item->cantidad,
                'costo_total' => $item->costo_total,
                'estado_fisico' => $item->estado_fisico,
                'estado_fisico_texto' => $this->estadoFisicoTexto($item->estado_fisico),
                'fuente' => $item->fuente,
                'fuente_codigo' => $item->fuente_codigo,
                'fecha_entrega' => $fecha,
                'dia' => $fecha ? $fecha->format('d') : '',
                'mes' => $fecha ? $fecha->format('m') : '',
                'anio' => $fecha ? $fecha->format('Y') : '',
                'carrera' => $item->carrera,
                'observaciones' => $item->observaciones,
                'imagen' => $item->imagen,
            ];
        });

        $carreras = Carrera::orderBy('nombre')->get();
        $ambientes = Ambiente::orderBy('nombre')->get();
        $fuentes = FuenteFinanciamiento::orderBy('nombre')->get();

        return view('reportes.inventario_general', compact('reportes', 'carreras', 'ambientes', 'fuentes', 'tipoBien'));
=======
        $activos = ActivoFijo::with(['categoria', 'ambiente.carrera', 'fuente', 'custodio'])
            ->paraUsuario(Auth::user())
            ->tipoBien($tipoBien)
            ->orderBy('id_categoria')
            ->orderBy('nombre')
            ->orderBy('codigo_activo')
            ->get();

        $agrupados = $this->agruparActivos($activos);

        return view('reportes.inventario_general', compact('activos', 'agrupados', 'tipoBien'));
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
    }

    public function inventarioGeneralPdf(Request $request)
    {
        $tipoBien = $this->tipoBienReporte($request);

<<<<<<< HEAD
        $query = ActivoFijo::query()
            ->selectRaw('
                GROUP_CONCAT(activos_fijos.codigo_activo ORDER BY activos_fijos.codigo_activo SEPARATOR " ") as codigos,
                activos_fijos.nombre as descripcion,
                CONCAT_WS(", ",
                    activos_fijos.marca,
                    activos_fijos.modelo,
                    GROUP_CONCAT(DISTINCT activos_fijos.numero_serie ORDER BY activos_fijos.numero_serie SEPARATOR ", "),
                    activos_fijos.descripcion
                ) as caracteristicas,
                COUNT(*) as cantidad,
                SUM(activos_fijos.valor_adquisicion) as costo_total,
                activos_fijos.estado_fisico,
                fuentes_financiamiento.nombre as fuente,
                fuentes_financiamiento.codigo as fuente_codigo,
                MIN(activos_fijos.fecha_adquisicion) as fecha_entrega,
                carreras.nombre as carrera,
                activos_fijos.observaciones,
                activos_fijos.imagen
            ')
            ->join('categorias', 'activos_fijos.id_categoria', '=', 'categorias.id_categoria')
            ->join('ambientes', 'activos_fijos.id_ambiente', '=', 'ambientes.id_ambiente')
            ->join('carreras', 'ambientes.id_carrera', '=', 'carreras.id_carrera')
            ->leftJoin('fuentes_financiamiento', 'activos_fijos.id_fuente', '=', 'fuentes_financiamiento.id_fuente')
            ->where('activos_fijos.estado_registro', '!=', 'BAJA')
            ->tipoBien($tipoBien);

        if ($request->filled('carrera')) {
            $query->where('carreras.id_carrera', $request->carrera);
        }
        if ($request->filled('ambiente')) {
            $query->where('activos_fijos.id_ambiente', $request->ambiente);
        }
        if ($request->filled('estado_fisico')) {
            $query->where('activos_fijos.estado_fisico', $request->estado_fisico);
        }
        if ($request->filled('fuente')) {
            $query->where('activos_fijos.id_fuente', $request->fuente);
        }
        if ($request->filled('anio')) {
            $query->whereYear('activos_fijos.fecha_adquisicion', $request->anio);
        }

        $query->groupBy(
            'activos_fijos.nombre',
            'activos_fijos.marca',
            'activos_fijos.modelo',
            'activos_fijos.descripcion',
            'activos_fijos.estado_fisico',
            'fuentes_financiamiento.nombre',
            'carreras.nombre',
            'activos_fijos.observaciones',
            'activos_fijos.imagen'
        )
        ->orderBy('activos_fijos.modelo')
        ->orderBy('activos_fijos.marca')
        ->orderBy('activos_fijos.nombre');

        $reportes = $query->get()->map(function ($item, $index) {
            $fecha = $item->fecha_entrega;
            if (is_string($fecha)) {
                $fecha = Carbon::parse($fecha);
            }
            return (object) [
                'nro' => $index + 1,
                'codigos' => $item->codigos,
                'ids_array' => [],
                'descripcion' => $item->descripcion,
                'caracteristicas' => $item->caracteristicas,
                'cantidad' => $item->cantidad,
                'costo_total' => $item->costo_total,
                'estado_fisico' => $item->estado_fisico,
                'estado_fisico_texto' => $this->estadoFisicoTexto($item->estado_fisico),
                'fuente' => $item->fuente,
                'fuente_codigo' => $item->fuente_codigo,
                'fecha_entrega' => $fecha,
                'dia' => $fecha ? $fecha->format('d') : '',
                'mes' => $fecha ? $fecha->format('m') : '',
                'anio' => $fecha ? $fecha->format('Y') : '',
                'carrera' => $item->carrera,
                'observaciones' => $item->observaciones,
                'imagen' => $item->imagen,
            ];
        });

        $pdf = PdfHelper::oficio('reportes.pdf.inventario_general', compact('reportes', 'tipoBien'), 'landscape');
=======
        $activos = ActivoFijo::with(['categoria', 'ambiente.carrera', 'fuente', 'custodio'])
            ->paraUsuario(Auth::user())
            ->tipoBien($tipoBien)
            ->orderBy('id_categoria')
            ->orderBy('nombre')
            ->get();

        $agrupados = $this->agruparActivos($activos);

        $pdf = PdfHelper::oficio('reportes.pdf.inventario_general', compact('activos', 'agrupados', 'tipoBien'), 'landscape');
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
        return $pdf->stream('Inventario_' . $this->sufijoTipoBien($tipoBien) . 'General_' . date('Y-m-d') . '.pdf');
    }

    public function inventarioGeneralExcel(Request $request)
    {
        $tipoBien = $this->tipoBienReporte($request);

<<<<<<< HEAD
        $query = ActivoFijo::query()
            ->selectRaw('
                GROUP_CONCAT(activos_fijos.codigo_activo ORDER BY activos_fijos.codigo_activo SEPARATOR " ") as codigos,
                activos_fijos.nombre as descripcion,
                CONCAT_WS(", ",
                    activos_fijos.marca,
                    activos_fijos.modelo,
                    GROUP_CONCAT(DISTINCT activos_fijos.numero_serie ORDER BY activos_fijos.numero_serie SEPARATOR ", "),
                    activos_fijos.descripcion
                ) as caracteristicas,
                COUNT(*) as cantidad,
                SUM(activos_fijos.valor_adquisicion) as costo_total,
                activos_fijos.estado_fisico,
                fuentes_financiamiento.nombre as fuente,
                fuentes_financiamiento.codigo as fuente_codigo,
                MIN(activos_fijos.fecha_adquisicion) as fecha_entrega,
                carreras.nombre as carrera,
                activos_fijos.observaciones,
                activos_fijos.imagen
            ')
            ->join('categorias', 'activos_fijos.id_categoria', '=', 'categorias.id_categoria')
            ->join('ambientes', 'activos_fijos.id_ambiente', '=', 'ambientes.id_ambiente')
            ->join('carreras', 'ambientes.id_carrera', '=', 'carreras.id_carrera')
            ->leftJoin('fuentes_financiamiento', 'activos_fijos.id_fuente', '=', 'fuentes_financiamiento.id_fuente')
            ->where('activos_fijos.estado_registro', '!=', 'BAJA')
            ->tipoBien($tipoBien);

        if ($request->filled('carrera')) {
            $query->where('carreras.id_carrera', $request->carrera);
        }
        if ($request->filled('ambiente')) {
            $query->where('activos_fijos.id_ambiente', $request->ambiente);
        }
        if ($request->filled('estado_fisico')) {
            $query->where('activos_fijos.estado_fisico', $request->estado_fisico);
        }
        if ($request->filled('fuente')) {
            $query->where('activos_fijos.id_fuente', $request->fuente);
        }
        if ($request->filled('anio')) {
            $query->whereYear('activos_fijos.fecha_adquisicion', $request->anio);
        }

        $query->groupBy(
            'activos_fijos.nombre',
            'activos_fijos.marca',
            'activos_fijos.modelo',
            'activos_fijos.descripcion',
            'activos_fijos.estado_fisico',
            'fuentes_financiamiento.nombre',
            'carreras.nombre',
            'activos_fijos.observaciones',
            'activos_fijos.imagen'
        )
        ->orderBy('activos_fijos.modelo')
        ->orderBy('activos_fijos.marca')
        ->orderBy('activos_fijos.nombre');

        $reportes = $query->get()->map(function ($item, $index) {
            $fecha = $item->fecha_entrega;
            if (is_string($fecha)) {
                $fecha = Carbon::parse($fecha);
            }
            return (object) [
                'nro' => $index + 1,
                'codigos' => $item->codigos,
                'ids_array' => [],
                'descripcion' => $item->descripcion,
                'caracteristicas' => $item->caracteristicas,
                'cantidad' => $item->cantidad,
                'costo_total' => $item->costo_total,
                'estado_fisico' => $item->estado_fisico,
                'estado_fisico_texto' => $this->estadoFisicoTexto($item->estado_fisico),
                'fuente' => $item->fuente,
                'fuente_codigo' => $item->fuente_codigo,
                'fecha_entrega' => $fecha,
                'dia' => $fecha ? $fecha->format('d') : '',
                'mes' => $fecha ? $fecha->format('m') : '',
                'anio' => $fecha ? $fecha->format('Y') : '',
                'carrera' => $item->carrera,
                'observaciones' => $item->observaciones,
                'imagen' => $item->imagen,
            ];
        });

        return response()
            ->view('reportes.excel.inventario_general', compact('reportes', 'tipoBien'))
=======
        $activos = ActivoFijo::with(['categoria', 'ambiente.carrera', 'fuente', 'custodio'])
            ->paraUsuario(Auth::user())
            ->tipoBien($tipoBien)
            ->orderBy('id_categoria')
            ->orderBy('nombre')
            ->get();

        return response()
            ->view('reportes.excel.inventario_general', compact('activos', 'tipoBien'))
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
            ->header('Content-Type', 'application/vnd.ms-excel; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="Inventario_'
                . $this->sufijoTipoBien($tipoBien) . 'General_' . date('Y-m-d') . '.xls"');
    }

<<<<<<< HEAD
    private function tipoBienReporte(Request $request): string
    {
        $tipo = $request->input('tipo_bien', 'TODOS');
=======
    /**
     * Filtro de tipo de bien del reporte: TODOS, ACTIVO_FIJO o NO_ACTIVO.
     */
    private function tipoBienReporte(Request $request): string
    {
        $tipo = $request->input('tipo_bien', 'TODOS');

>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
        return in_array($tipo, ['ACTIVO_FIJO', 'NO_ACTIVO'], true) ? $tipo : 'TODOS';
    }

    private function sufijoTipoBien(string $tipo): string
    {
        return match ($tipo) {
            'ACTIVO_FIJO' => 'Activos_Fijos_',
            'NO_ACTIVO'   => 'No_Activos_',
            default       => 'Todos_',
        };
    }

    // ============================================================
    // 2. INVENTARIO POR AMBIENTE
    // ============================================================
    public function porAmbiente($id_ambiente)
    {
        $ambiente = $this->ambienteVisible($id_ambiente);
<<<<<<< HEAD

        $query = ActivoFijo::query()
            ->selectRaw('
                GROUP_CONCAT(activos_fijos.codigo_activo ORDER BY activos_fijos.codigo_activo SEPARATOR " ") as codigos,
                activos_fijos.nombre as descripcion,
                CONCAT_WS(", ",
                    activos_fijos.marca,
                    activos_fijos.modelo,
                    GROUP_CONCAT(DISTINCT activos_fijos.numero_serie ORDER BY activos_fijos.numero_serie SEPARATOR ", "),
                    activos_fijos.descripcion
                ) as caracteristicas,
                COUNT(*) as cantidad,
                SUM(activos_fijos.valor_adquisicion) as costo_total,
                activos_fijos.estado_fisico,
                fuentes_financiamiento.nombre as fuente,
                MIN(activos_fijos.fecha_adquisicion) as fecha_entrega,
                carreras.nombre as carrera,
                activos_fijos.observaciones,
                activos_fijos.imagen
            ')
            ->join('categorias', 'activos_fijos.id_categoria', '=', 'categorias.id_categoria')
            ->join('ambientes', 'activos_fijos.id_ambiente', '=', 'ambientes.id_ambiente')
            ->join('carreras', 'ambientes.id_carrera', '=', 'carreras.id_carrera')
            ->leftJoin('fuentes_financiamiento', 'activos_fijos.id_fuente', '=', 'fuentes_financiamiento.id_fuente')
            ->where('activos_fijos.estado_registro', '!=', 'BAJA')
            ->where('activos_fijos.id_ambiente', $id_ambiente)
            ->groupBy(
                'activos_fijos.nombre',
                'activos_fijos.marca',
                'activos_fijos.modelo',
                'activos_fijos.descripcion',
                'activos_fijos.estado_fisico',
                'fuentes_financiamiento.nombre',
                'carreras.nombre',
                'activos_fijos.observaciones',
                'activos_fijos.imagen'
            )
            ->orderBy('activos_fijos.modelo')
            ->orderBy('activos_fijos.marca')
            ->orderBy('activos_fijos.nombre');

        $reportes = $query->get()->map(function ($item, $index) {
            $fecha = $item->fecha_entrega;
            if (is_string($fecha)) {
                $fecha = Carbon::parse($fecha);
            }
            return (object) [
                'nro' => $index + 1,
                'codigos' => $item->codigos,
                'ids_array' => [],
                'descripcion' => $item->descripcion,
                'caracteristicas' => $item->caracteristicas,
                'cantidad' => $item->cantidad,
                'costo_total' => $item->costo_total,
                'estado_fisico' => $item->estado_fisico,
                'estado_fisico_texto' => $this->estadoFisicoTexto($item->estado_fisico),
                'fuente' => $item->fuente,
                'fuente_codigo' => $item->fuente_codigo ?? '',
                'fecha_entrega' => $fecha,
                'dia' => $fecha ? $fecha->format('d') : '',
                'mes' => $fecha ? $fecha->format('m') : '',
                'anio' => $fecha ? $fecha->format('Y') : '',
                'carrera' => $item->carrera,
                'observaciones' => $item->observaciones,
                'imagen' => $item->imagen,
            ];
        });

        return view('reportes.por_ambiente', compact('ambiente', 'reportes'));
=======
        $activos  = $this->activosDeAmbiente($id_ambiente);
        $agrupados = $this->agruparActivos($activos);

        return view('reportes.por_ambiente', compact('ambiente', 'activos', 'agrupados'));
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
    }

    public function porAmbientePdf($id_ambiente)
    {
        $ambiente = $this->ambienteVisible($id_ambiente);
<<<<<<< HEAD
        // Reutiliza la misma lógica de consulta por ambiente
        return $this->porAmbiente($id_ambiente); // o genera PDF directamente
=======
        $activos  = $this->activosDeAmbiente($id_ambiente);
        $agrupados = $this->agruparActivos($activos);

        $pdf = PdfHelper::oficio('reportes.pdf.por_ambiente', compact('ambiente', 'activos', 'agrupados'));
        return $pdf->stream('Inventario_Ambiente_' . str_replace(' ', '_', $ambiente->nombre) . '.pdf');
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
    }

    public function porAmbienteExcel($id_ambiente)
    {
        $ambiente = $this->ambienteVisible($id_ambiente);
<<<<<<< HEAD
        return response()
            ->view('reportes.excel.por_ambiente', compact('ambiente'))
            ->header('Content-Type', 'application/vnd.ms-excel; charset=utf-8');
    }

    // ============================================================
    // 3. MÉTODOS DINÁMICOS PARA REPORTES (DESDE EL CENTRO DE REPORTES)
    // ============================================================
    public function pdf(Request $request)
    {
        $tipoBien = $this->tipoBienReporte($request);

        $query = ActivoFijo::query()
            ->selectRaw('
                GROUP_CONCAT(activos_fijos.codigo_activo ORDER BY activos_fijos.codigo_activo SEPARATOR " ") as codigos,
                activos_fijos.nombre as descripcion,
                CONCAT_WS(", ",
                    activos_fijos.marca,
                    activos_fijos.modelo,
                    GROUP_CONCAT(DISTINCT activos_fijos.numero_serie ORDER BY activos_fijos.numero_serie SEPARATOR ", "),
                    activos_fijos.descripcion
                ) as caracteristicas,
                COUNT(*) as cantidad,
                SUM(activos_fijos.valor_adquisicion) as costo_total,
                activos_fijos.estado_fisico,
                fuentes_financiamiento.nombre as fuente,
                fuentes_financiamiento.codigo as fuente_codigo,
                MIN(activos_fijos.fecha_adquisicion) as fecha_entrega,
                carreras.nombre as carrera,
                activos_fijos.observaciones,
                activos_fijos.imagen
            ')
            ->join('categorias', 'activos_fijos.id_categoria', '=', 'categorias.id_categoria')
            ->join('ambientes', 'activos_fijos.id_ambiente', '=', 'ambientes.id_ambiente')
            ->join('carreras', 'ambientes.id_carrera', '=', 'carreras.id_carrera')
            ->leftJoin('fuentes_financiamiento', 'activos_fijos.id_fuente', '=', 'fuentes_financiamiento.id_fuente')
            ->where('activos_fijos.estado_registro', '!=', 'BAJA')
            ->tipoBien($tipoBien);

        if ($request->filled('id_ambiente')) {
            $query->where('activos_fijos.id_ambiente', $request->id_ambiente);
        }
        if ($request->filled('id_carrera')) {
            $query->where('carreras.id_carrera', $request->id_carrera);
        }
        if ($request->filled('id_categoria')) {
            $query->where('activos_fijos.id_categoria', $request->id_categoria);
        }

        $query->groupBy(
            'activos_fijos.nombre',
            'activos_fijos.marca',
            'activos_fijos.modelo',
            'activos_fijos.descripcion',
            'activos_fijos.estado_fisico',
            'fuentes_financiamiento.nombre',
            'carreras.nombre',
            'activos_fijos.observaciones',
            'activos_fijos.imagen'
        )
        ->orderBy('activos_fijos.modelo')
        ->orderBy('activos_fijos.marca')
        ->orderBy('activos_fijos.nombre');

        $reportes = $query->get()->map(function ($item, $index) {
            $fecha = $item->fecha_entrega;
            if (is_string($fecha)) {
                $fecha = Carbon::parse($fecha);
            }
            return (object) [
                'nro' => $index + 1,
                'codigos' => $item->codigos,
                'ids_array' => [],
                'descripcion' => $item->descripcion,
                'caracteristicas' => $item->caracteristicas,
                'cantidad' => $item->cantidad,
                'costo_total' => $item->costo_total,
                'estado_fisico' => $item->estado_fisico,
                'estado_fisico_texto' => $this->estadoFisicoTexto($item->estado_fisico),
                'fuente' => $item->fuente,
                'fuente_codigo' => $item->fuente_codigo ?? '',
                'fecha_entrega' => $fecha,
                'dia' => $fecha ? $fecha->format('d') : '',
                'mes' => $fecha ? $fecha->format('m') : '',
                'anio' => $fecha ? $fecha->format('Y') : '',
                'carrera' => $item->carrera,
                'observaciones' => $item->observaciones,
                'imagen' => $item->imagen,
            ];
        });

        $pdf = PdfHelper::oficio('reportes.pdf.inventario_general', compact('reportes', 'tipoBien'), 'landscape');
        return $pdf->stream('Inventario_Filtro_' . date('Y-m-d') . '.pdf');
    }

    public function excel(Request $request)
    {
        $tipoBien = $this->tipoBienReporte($request);

        $query = ActivoFijo::query()
            ->selectRaw('
                GROUP_CONCAT(activos_fijos.codigo_activo ORDER BY activos_fijos.codigo_activo SEPARATOR " ") as codigos,
                activos_fijos.nombre as descripcion,
                CONCAT_WS(", ",
                    activos_fijos.marca,
                    activos_fijos.modelo,
                    GROUP_CONCAT(DISTINCT activos_fijos.numero_serie ORDER BY activos_fijos.numero_serie SEPARATOR ", "),
                    activos_fijos.descripcion
                ) as caracteristicas,
                COUNT(*) as cantidad,
                SUM(activos_fijos.valor_adquisicion) as costo_total,
                activos_fijos.estado_fisico,
                fuentes_financiamiento.nombre as fuente,
                fuentes_financiamiento.codigo as fuente_codigo,
                MIN(activos_fijos.fecha_adquisicion) as fecha_entrega,
                carreras.nombre as carrera,
                activos_fijos.observaciones,
                activos_fijos.imagen
            ')
            ->join('categorias', 'activos_fijos.id_categoria', '=', 'categorias.id_categoria')
            ->join('ambientes', 'activos_fijos.id_ambiente', '=', 'ambientes.id_ambiente')
            ->join('carreras', 'ambientes.id_carrera', '=', 'carreras.id_carrera')
            ->leftJoin('fuentes_financiamiento', 'activos_fijos.id_fuente', '=', 'fuentes_financiamiento.id_fuente')
            ->where('activos_fijos.estado_registro', '!=', 'BAJA')
            ->tipoBien($tipoBien);

        if ($request->filled('id_ambiente')) {
            $query->where('activos_fijos.id_ambiente', $request->id_ambiente);
        }
        if ($request->filled('id_carrera')) {
            $query->where('carreras.id_carrera', $request->id_carrera);
        }
        if ($request->filled('id_categoria')) {
            $query->where('activos_fijos.id_categoria', $request->id_categoria);
        }

        $query->groupBy(
            'activos_fijos.nombre',
            'activos_fijos.marca',
            'activos_fijos.modelo',
            'activos_fijos.descripcion',
            'activos_fijos.estado_fisico',
            'fuentes_financiamiento.nombre',
            'carreras.nombre',
            'activos_fijos.observaciones',
            'activos_fijos.imagen'
        )
        ->orderBy('activos_fijos.modelo')
        ->orderBy('activos_fijos.marca')
        ->orderBy('activos_fijos.nombre');

        $reportes = $query->get()->map(function ($item, $index) {
            $fecha = $item->fecha_entrega;
            if (is_string($fecha)) {
                $fecha = Carbon::parse($fecha);
            }
            return (object) [
                'nro' => $index + 1,
                'codigos' => $item->codigos,
                'ids_array' => [],
                'descripcion' => $item->descripcion,
                'caracteristicas' => $item->caracteristicas,
                'cantidad' => $item->cantidad,
                'costo_total' => $item->costo_total,
                'estado_fisico' => $item->estado_fisico,
                'estado_fisico_texto' => $this->estadoFisicoTexto($item->estado_fisico),
                'fuente' => $item->fuente,
                'fuente_codigo' => $item->fuente_codigo ?? '',
                'fecha_entrega' => $fecha,
                'dia' => $fecha ? $fecha->format('d') : '',
                'mes' => $fecha ? $fecha->format('m') : '',
                'anio' => $fecha ? $fecha->format('Y') : '',
                'carrera' => $item->carrera,
                'observaciones' => $item->observaciones,
                'imagen' => $item->imagen,
            ];
        });

        return response()
            ->view('reportes.excel.inventario_general', compact('reportes', 'tipoBien'))
            ->header('Content-Type', 'application/vnd.ms-excel; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="Inventario_Filtro_' . date('Y-m-d') . '.xls"');
    }

    // ============================================================
    // HELPERS Y ALCANCE
    // ============================================================
=======
        $activos  = $this->activosDeAmbiente($id_ambiente);

        return response()
            ->view('reportes.excel.por_ambiente', compact('ambiente', 'activos'))
            ->header('Content-Type', 'application/vnd.ms-excel; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="Inventario_' . str_replace(' ', '_', $ambiente->nombre) . '.xls"');
    }

    // ============================================================
    // 3. INVENTARIO POR AULA (JEFE DE CARRERA — filtrable)
    // ============================================================
    public function porAula(Request $request, $id_ambiente)
    {
        $ambiente = $this->ambienteVisible($id_ambiente);

        $query = ActivoFijo::paraUsuario(Auth::user())->where('id_ambiente', $id_ambiente)
            ->with(['categoria', 'fuente', 'custodio']);

        // Filtros opcionales (el jefe puede filtrar equipos, sillas, mesas, etc.)
        if ($request->filled('categoria_id')) {
            $query->where('id_categoria', $request->categoria_id);
        }
        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', "%{$request->nombre}%");
        }
        if ($request->filled('estado_fisico')) {
            $query->where('estado_fisico', $request->estado_fisico);
        }
        if ($request->filled('fuente_id')) {
            $query->where('id_fuente', $request->fuente_id);
        }

        $activos    = $query->orderBy('nombre')->orderBy('codigo_activo')->get();
        $agrupados  = $this->agruparActivos($activos);

        // Para los filtros
        $categorias = Categoria::where('id_ambiente', $id_ambiente)->orderBy('nombre')->get();
        $fuentes    = FuenteFinanciamiento::orderBy('nombre')->get();

        // Estadísticas
        $stats = [
            'total'      => $activos->count(),
            'buenos'     => $activos->where('estado_fisico', 'B')->count(),
            'regulares'  => $activos->where('estado_fisico', 'R')->count(),
            'malos'      => $activos->where('estado_fisico', 'M')->count(),
            'fuera'      => $activos->where('estado_fisico', 'FF')->count(),
        ];

        return view('reportes.por_aula', compact(
            'ambiente', 'activos', 'agrupados', 'categorias', 'fuentes', 'stats'
        ));
    }

    public function porAulaPdf(Request $request, $id_ambiente)
    {
        $ambiente = $this->ambienteVisible($id_ambiente);

        $query = ActivoFijo::paraUsuario(Auth::user())->where('id_ambiente', $id_ambiente)->with(['categoria', 'fuente', 'custodio']);

        if ($request->filled('categoria_id'))  $query->where('id_categoria', $request->categoria_id);
        if ($request->filled('nombre'))        $query->where('nombre', 'like', "%{$request->nombre}%");
        if ($request->filled('estado_fisico')) $query->where('estado_fisico', $request->estado_fisico);

        $activos   = $query->orderBy('nombre')->get();
        $agrupados = $this->agruparActivos($activos);

        $pdf = PdfHelper::oficio('reportes.pdf.por_aula', compact('ambiente', 'activos', 'agrupados'));
        return $pdf->stream('Aula_' . str_replace(' ', '_', $ambiente->nombre) . '.pdf');
    }

    public function porAulaExcel(Request $request, $id_ambiente)
    {
        $ambiente = $this->ambienteVisible($id_ambiente);

        $activos = ActivoFijo::paraUsuario(Auth::user())->where('id_ambiente', $id_ambiente)
            ->with(['categoria', 'fuente', 'custodio'])
            ->orderBy('nombre')
            ->get();

        return response()
            ->view('reportes.excel.por_aula', compact('ambiente', 'activos'))
            ->header('Content-Type', 'application/vnd.ms-excel; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="Aula_' . str_replace(' ', '_', $ambiente->nombre) . '.xls"');
    }

    // ============================================================
    // 4. INVENTARIO POR CARRERA (JEFE — resumen)
    // ============================================================
    public function porCarrera($id_carrera)
    {
        $carrera = Carrera::findOrFail($id_carrera);

        $ambientes = Ambiente::where('id_carrera', $id_carrera)
            ->withCount('activos')
            ->orderBy('nombre')
            ->get();

        // Resumen por categoría dentro de la carrera
        $resumen = ActivoFijo::paraUsuario(Auth::user())->whereHas('ambiente', fn($q) => $q->where('id_carrera', $id_carrera))
            ->with(['categoria', 'ambiente'])
            ->get()
            ->groupBy(fn($a) => ($a->categoria->nombre ?? 'Sin categoría') . '|' . ($a->ambiente->nombre ?? 'Sin ambiente'))
            ->map(function ($grupo) {
                $first = $grupo->first();
                return (object) [
                    'categoria'     => $first->categoria->nombre ?? '—',
                    'ambiente'      => $first->ambiente->nombre ?? '—',
                    'total'         => $grupo->count(),
                    'buenos'        => $grupo->where('estado_fisico', 'B')->count(),
                    'regulares'     => $grupo->where('estado_fisico', 'R')->count(),
                    'malos'         => $grupo->where('estado_fisico', 'M')->count(),
                    'fuera'         => $grupo->where('estado_fisico', 'FF')->count(),
                ];
            })->values();

        return view('reportes.por_carrera', compact('carrera', 'ambientes', 'resumen'));
    }

    public function porCarreraPdf($id_carrera)
    {
        $carrera = Carrera::findOrFail($id_carrera);

        $ambientes = Ambiente::where('id_carrera', $id_carrera)
            ->withCount('activos')
            ->orderBy('nombre')
            ->get();

        $resumen = ActivoFijo::paraUsuario(Auth::user())->whereHas('ambiente', fn($q) => $q->where('id_carrera', $id_carrera))
            ->with(['categoria', 'ambiente'])
            ->get()
            ->groupBy(fn($a) => ($a->categoria->nombre ?? 'Sin categoría') . '|' . ($a->ambiente->nombre ?? 'Sin ambiente'))
            ->map(function ($grupo) {
                $first = $grupo->first();
                return (object) [
                    'categoria' => $first->categoria->nombre ?? '—',
                    'ambiente'  => $first->ambiente->nombre ?? '—',
                    'total'     => $grupo->count(),
                    'buenos'    => $grupo->where('estado_fisico', 'B')->count(),
                    'regulares' => $grupo->where('estado_fisico', 'R')->count(),
                    'malos'     => $grupo->where('estado_fisico', 'M')->count(),
                    'fuera'     => $grupo->where('estado_fisico', 'FF')->count(),
                ];
            })->values();

        $pdf = PdfHelper::oficio('reportes.pdf.por_carrera', compact('carrera', 'ambientes', 'resumen'));
        return $pdf->stream('Carrera_' . str_replace(' ', '_', $carrera->nombre) . '.pdf');
    }

    // ============================================================
    // ALCANCE
    // ============================================================

    /**
     * Un ambiente fuera del ámbito del usuario no se consulta, ni aunque
     * se conozca su número.
     */
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
    protected function ambienteVisible($id): Ambiente
    {
        return Auth::user()->ambientesVisibles()->with('carrera')->findOrFail($id);
    }

<<<<<<< HEAD
    protected function estadoFisicoTexto($estado): string
    {
        return match ($estado) {
            'B' => 'BUENO',
            'R' => 'REGULAR',
            'M' => 'MALO',
            'FF' => 'FUERA DE FUNCIONAMIENTO',
            default => 'DESCONOCIDO',
        };
=======
    protected function autorizarCategoria(Categoria $categoria): void
    {
        $idsAmbientes = Auth::user()->idsAmbientesVisibles();

        abort_if(
            $categoria->id_ambiente
                && $idsAmbientes !== null
                && ! in_array((int) $categoria->id_ambiente, array_map('intval', $idsAmbientes), true),
            403,
            'Esa categoría no le corresponde.'
        );
    }

    // ============================================================
    // 5. INVENTARIO POR CATEGORÍA
    // ============================================================
    public function porCategoria($id_categoria)
    {
        $categoria = Categoria::with('ambiente.carrera')->findOrFail($id_categoria);
        $this->autorizarCategoria($categoria);
        $activos   = ActivoFijo::paraUsuario(Auth::user())->where('id_categoria', $id_categoria)
            ->with(['ambiente', 'fuente', 'custodio'])
            ->orderBy('nombre')
            ->get();
        $agrupados = $this->agruparActivos($activos);

        return view('reportes.por_categoria', compact('categoria', 'activos', 'agrupados'));
    }

    public function porCategoriaPdf($id_categoria)
    {
        $categoria = Categoria::with('ambiente.carrera')->findOrFail($id_categoria);
        $this->autorizarCategoria($categoria);
        $activos   = ActivoFijo::paraUsuario(Auth::user())->where('id_categoria', $id_categoria)
            ->with(['ambiente', 'fuente', 'custodio'])
            ->orderBy('nombre')
            ->get();
        $agrupados = $this->agruparActivos($activos);

        $pdf = PdfHelper::oficio('reportes.pdf.por_categoria', compact('categoria', 'activos', 'agrupados'));
        return $pdf->stream('Categoria_' . str_replace(' ', '_', $categoria->nombre) . '.pdf');
    }

    // ============================================================
    // HELPERS PRIVADOS
    // ============================================================

    /**
     * Agrupa activos por nombre + estado + fuente + gestión (igual que tu Excel).
     */
    private function agruparActivos($activos)
    {
        return $activos
            ->groupBy(fn($a) => $a->tipo_bien . '|' . $a->nombre . '|' . $a->estado_fisico . '|' . $a->id_fuente . '|' . $a->gestion)
            ->map(function ($grupo) {
                $first = $grupo->first();
                return (object) [
                    'nombre'        => $first->nombre,
                    'tipo_bien'     => $first->tipo_bien,
                    'tipo_bien_texto' => $first->tipo_bien_texto,
                    'cantidad'      => $grupo->count(),
                    'codigos'       => $grupo->pluck('codigo_activo')->implode("\n"),
                    'codigos_array' => $grupo->pluck('codigo_activo')->toArray(),
                    'ids_array'     => $grupo->pluck('id_activo')->toArray(),
                    'estado_fisico' => $first->estado_fisico,
                    'estado_texto'  => $first->estado_fisico_texto,
                    'fuente'        => $first->fuente->nombre ?? '—',
                    'fuente_codigo' => $first->fuente->codigo ?? '',
                    'gestion'       => $first->gestion,
                    'marca'         => $first->marca,
                    'modelo'        => $first->modelo,
                    'descripcion'   => $first->descripcion,
                    'observaciones' => $grupo->pluck('observaciones')->filter()->implode(' | '),
                ];
            })
            ->values();
    }

    private function activosDeAmbiente($id_ambiente)
    {
        return ActivoFijo::paraUsuario(Auth::user())->where('id_ambiente', $id_ambiente)
            ->with(['categoria', 'fuente', 'custodio'])
            ->orderBy('nombre')
            ->orderBy('codigo_activo')
            ->get();
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
    }
}
