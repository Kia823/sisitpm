<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ActivoFijo;
use App\Models\Ambiente;
use App\Models\Carrera;
use App\Models\Categoria;
use App\Models\FuenteFinanciamiento;
use App\Models\Item;
use App\Models\User;
use App\Services\QRCodeService;
use App\Support\PdfHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class ActivoController extends Controller
{
    protected QRCodeService $qrService;

    public function __construct(QRCodeService $qrService)
    {
        $this->qrService = $qrService;
    }

    // ==========================================
    // PERMISOS — Solo admin modifica
    // ==========================================
    protected function authorizeActivoModification(): void
    {
        $user = Auth::user();

        if (! $user instanceof User || ! $user->puedeModificar()) {
            abort(403, 'No tiene permisos para modificar activos. Solo el administrador puede.');
        }
    }

    // ==========================================
<<<<<<< HEAD
    // INDEX — TODOS ven TODOS los activos (Excepto los dados de baja)
    // ==========================================
    public function index(Request $request)
    {
        $query = ActivoFijo::with(['categoria', 'ambiente.carrera', 'fuente', 'custodio'])
            ->where('estado_registro', '!=', 'BAJA'); // ⭐ Oculta los dados de baja del inventario general
=======
    // INDEX — TODOS ven TODOS los activos
    // ==========================================
    public function index(Request $request)
    {
        $query = ActivoFijo::with(['categoria', 'ambiente.carrera', 'fuente', 'custodio']);
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c

        if ($request->filled('buscar')) {
            $s = $request->buscar;
            $query->where(function ($q) use ($s) {
                $q->where('codigo_activo', 'like', "%{$s}%")
                  ->orWhere('nombre', 'like', "%{$s}%")
                  ->orWhere('numero_serie', 'like', "%{$s}%")
                  ->orWhere('marca', 'like', "%{$s}%")
                  ->orWhere('modelo', 'like', "%{$s}%");
            });
        }

        if ($request->filled('id_categoria')) {
            $query->where('id_categoria', $request->id_categoria);
        }

        if ($request->filled('id_ambiente')) {
            $query->where('id_ambiente', $request->id_ambiente);
        }

        $tipoBien = $request->input('tipo_bien', 'TODOS');

        if (in_array($tipoBien, ['ACTIVO_FIJO', 'NO_ACTIVO'], true)) {
            $query->where('tipo_bien', $tipoBien);
        }

        $activos    = $query->orderByDesc('id_activo')->get();
        $carreras   = Carrera::orderBy('nombre')->get();
        $categorias = Categoria::orderBy('nombre')->get();
        $ambientes  = Ambiente::with('carrera')->orderBy('nombre')->get();
        $fuentes    = FuenteFinanciamiento::orderBy('nombre')->get();
        $usuarios   = User::where('estado', 'ACTIVO')->orderBy('nombre_completo')->get();

        $totales = [
<<<<<<< HEAD
            'TODOS'       => ActivoFijo::where('estado_registro', '!=', 'BAJA')->count(),
            'ACTIVO_FIJO' => ActivoFijo::where('estado_registro', '!=', 'BAJA')->where('tipo_bien', 'ACTIVO_FIJO')->count(),
            'NO_ACTIVO'   => ActivoFijo::where('estado_registro', '!=', 'BAJA')->where('tipo_bien', 'NO_ACTIVO')->count(),
=======
            'ACTIVO_FIJO' => ActivoFijo::where('tipo_bien', 'ACTIVO_FIJO')->count(),
            'NO_ACTIVO'   => ActivoFijo::where('tipo_bien', 'NO_ACTIVO')->count(),
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
        ];

        return view('activos.index', compact(
            'activos', 'carreras', 'categorias', 'ambientes', 'fuentes', 'usuarios', 'tipoBien', 'totales'
        ));
    }

    // ==========================================
<<<<<<< HEAD
    // CREATE — Solo admin
=======
    // CREATE — Solo admin (middleware lo bloquea)
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
    // ==========================================
    public function create(Request $request)
    {
        $this->authorizeActivoModification();

<<<<<<< HEAD
        $idAmbientePreseleccionado = $request->input('id_ambiente');

        $categorias = Categoria::when($idAmbientePreseleccionado, function($q) use ($idAmbientePreseleccionado) {
            $q->where('id_ambiente', $idAmbientePreseleccionado);
        })->orderBy('nombre')->get();

        $ambientes  = Ambiente::with('carrera')->orderBy('nombre')->get();
        $fuentes    = FuenteFinanciamiento::orderBy('nombre')->get();

        $usuarios   = User::where('estado', 'ACTIVO')
            ->with(['items' => fn($q) => $q->whereNull('item_usuario.fecha_fin')])
            ->orderBy('nombre_completo')
            ->get();

        $config  = DB::table('configuraciones')->first();
        $prefijo = $config->prefijo_activo ?? 'TPM-';
        $codigoSugerido = $prefijo . date('Y') . '-' . rand(1000, 9999);

        return view('activos.create', compact(
            'categorias', 'ambientes', 'fuentes', 'usuarios', 'idAmbientePreseleccionado', 'codigoSugerido'
=======
        $categorias = Categoria::orderBy('nombre')->get();
        $ambientes  = Ambiente::with('carrera')->orderBy('nombre')->get();
        $fuentes    = FuenteFinanciamiento::orderBy('nombre')->get();
        $usuarios   = User::where('estado', 'ACTIVO')->orderBy('nombre_completo')->get();
        $items      = Item::orderBy('numero_item')->get();

        $id_ambiente_preseleccionado = $request->input('id_ambiente');

        // ⭐ Obtener el prefijo configurado en el sistema (por defecto 'TPM-' si no existe)
        $config = DB::table('configuraciones')->first();
        $prefijo = $config->prefijo_activo ?? 'TPM-';

        // ⭐ Generar un código sugerido combinando el prefijo, el año y un número aleatorio o correlativo
        $codigoSugerido = $prefijo . date('Y') . '-' . rand(1000, 9999);

        return view('activos.create', compact(
            'categorias', 'ambientes', 'fuentes', 'usuarios', 'id_ambiente_preseleccionado', 'codigoSugerido', 'items'
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
        ));
    }

    // ==========================================
<<<<<<< HEAD
    // STORE — Solo admin (CON 3 IMÁGENES Y VALIDACIÓN FLEXIBLE)
=======
    // STORE — Solo admin
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
    // ==========================================
    public function store(Request $request)
    {
        $this->authorizeActivoModification();

<<<<<<< HEAD
        $tipoBien = $request->input('tipo_bien', 'ACTIVO_FIJO');

        $data = $request->validate([
            'codigo_activo'     => 'required|string|max:50|unique:activos_fijos,codigo_activo',
            'tipo_bien'         => 'required|in:ACTIVO_FIJO,NO_ACTIVO',
            'nombre'            => 'required|string|max:150',
            'marca'             => $tipoBien === 'ACTIVO_FIJO' ? 'required|string|max:80' : 'nullable|string|max:80',
            'modelo'            => $tipoBien === 'ACTIVO_FIJO' ? 'required|string|max:80' : 'nullable|string|max:80',
            'numero_serie'      => $tipoBien === 'ACTIVO_FIJO' ? 'required|string|max:80' : 'nullable|string|max:80',
            'descripcion'       => 'required|string|max:500',
            'id_ambiente'       => 'required|exists:ambientes,id_ambiente',
            'id_categoria'      => 'required|exists:categorias,id_categoria',
            'id_fuente'         => 'required|exists:fuentes_financiamiento,id_fuente',
            'id_custodio'       => 'required|exists:usuarios,id_usuario',
            'estado_fisico'     => 'required|in:B,R,M,FF',
            'fecha_adquisicion' => 'required|date',
            'valor_adquisicion' => 'required|numeric|min:0',
            'imagen'            => 'nullable|image|max:5120',
            'imagen_lateral'    => 'nullable|image|max:5120',
            'imagen_detalle'    => 'nullable|image|max:5120',
        ], [
            'codigo_activo.required' => 'El código del activo es obligatorio.',
            'codigo_activo.unique'   => 'Este código de activo ya está registrado.',
            'nombre.required'        => 'El nombre del activo es obligatorio.',
            'marca.required'         => 'La marca es obligatoria para activos fijos.',
            'modelo.required'        => 'El modelo es obligatorio para activos fijos.',
            'numero_serie.required'  => 'El número de serie es obligatorio para activos fijos.',
            'id_ambiente.required'   => 'El ambiente es obligatorio.',
            'id_categoria.required'  => 'La categoría es obligatoria.',
            'id_fuente.required'     => 'La fuente de financiamiento es obligatoria.',
            'id_custodio.required'   => 'El custodio responsable es obligatorio.',
        ]);

        $data['tipo_bien'] = $tipoBien;
        $cantidad = max(1, min(100, (int) $request->input('cantidad', 1)));
        $data['id_item'] = $this->itemDelCustodio($data['id_custodio'] ?? null);

        $imagenPath        = $request->hasFile('imagen') ? $request->file('imagen')->store('activos', 'public') : null;
        $imagenLateralPath = $request->hasFile('imagen_lateral') ? $request->file('imagen_lateral')->store('activos', 'public') : null;
        $imagenDetallePath = $request->hasFile('imagen_detalle') ? $request->file('imagen_detalle')->store('activos', 'public') : null;
=======
        $data = $request->validate(
            ActivoFijo::rules(null, $request->input('tipo_bien', 'ACTIVO_FIJO')),
            ActivoFijo::$messages
        );

        $data['tipo_bien'] = $request->input('tipo_bien', 'ACTIVO_FIJO');

        $cantidad = (int) ($request->input('cantidad', 1));
        $cantidad = max(1, min(100, $cantidad));

        // El ítem no se elige: es del custodio. Si no tiene ítem asignado, queda null.
        $data['id_item'] = $this->itemDelCustodio($data['id_custodio'] ?? null);

        $imagenPath = null;
        if ($request->hasFile('imagen')) {
            $imagenPath = $request->file('imagen')->store('activos', 'public');
        }
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c

        $creados    = 0;
        $codigoBase = $data['codigo_activo'];

<<<<<<< HEAD
        DB::transaction(function () use (&$creados, $data, $cantidad, $codigoBase, $imagenPath, $imagenLateralPath, $imagenDetallePath) {
            for ($i = 0; $i < $cantidad; $i++) {
                $item = $data;
=======
        DB::transaction(function () use (&$creados, $data, $cantidad, $codigoBase, $imagenPath) {
            for ($i = 0; $i < $cantidad; $i++) {
                $item = $data;

>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
                $item['codigo_activo'] = ($cantidad > 1)
                    ? $codigoBase . '-' . str_pad($i + 1, 2, '0', STR_PAD_LEFT)
                    : $codigoBase;

                if (ActivoFijo::where('codigo_activo', $item['codigo_activo'])->exists()) {
                    continue;
                }

<<<<<<< HEAD
                if ($imagenPath) $item['imagen'] = $imagenPath;
                if ($imagenLateralPath) $item['imagen_lateral'] = $imagenLateralPath;
                if ($imagenDetallePath) $item['imagen_detalle'] = $imagenDetallePath;
=======
                if ($imagenPath) {
                    $item['imagen'] = $imagenPath;
                }
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c

                $activo = ActivoFijo::create($item);

                try {
                    $qrData = $this->generarQRParaActivo($item['codigo_activo']);
                    $activo->update($qrData);
                } catch (\Throwable $e) {
<<<<<<< HEAD
                    Log::warning('Error generando QR: ' . $e->getMessage());
=======
                    Log::warning('Error generando QR para ' . $item['codigo_activo'] . ': ' . $e->getMessage());
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
                }

                $creados++;
            }
        });

<<<<<<< HEAD
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => "¡{$creados} activo(s) registrado(s) correctamente!"]);
        }

        $idCategoriaOrigen = $request->input('id_categoria_origen') ?? $request->input('id_categoria');
        if ($idCategoriaOrigen) {
            return redirect()->route('categorias.show', $idCategoriaOrigen)
                ->with('success', "¡{$creados} activo(s) registrado(s) correctamente!");
        }

=======
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
        return redirect()->route('activos.index')
            ->with('success', "¡{$creados} activo(s) registrado(s) correctamente!");
    }

<<<<<<< HEAD
=======
    // ==========================================
    // El ítem pertenece a la persona: un activo con custodio hereda
    // el ítem de ese custodio. Sin custodio, el activo no tiene ítem.
    // ==========================================
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
    private function itemDelCustodio($idCustodio)
    {
        if (! $idCustodio) {
            return null;
        }

        return Item::query()
            ->whereHas('custodios', fn ($q) => $q
                ->where('usuarios.id_usuario', $idCustodio)
                ->whereNull('item_usuario.fecha_fin'))
            ->orderBy('id_item')
            ->value('id_item');
    }

    // ==========================================
<<<<<<< HEAD
    // SHOW por categoría — TODOS ven (Excluyendo dados de baja)
=======
    // SHOW por categoría — TODOS ven
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
    // ==========================================
    public function show($id)
    {
        $categoria = Categoria::with('ambiente.carrera')->findOrFail($id);
        $ambiente  = $categoria->ambiente;
        $carrera   = $ambiente?->carrera;

<<<<<<< HEAD
        $activos = ActivoFijo::paraUsuario(Auth::user())
            ->where('id_categoria', $categoria->id_categoria)
            ->where('estado_registro', '!=', 'BAJA')
=======
        $activos = ActivoFijo::paraUsuario(Auth::user())->where('id_categoria', $categoria->id_categoria)
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
            ->with(['ambiente', 'custodio', 'fuente'])
            ->orderBy('nombre')
            ->orderBy('codigo_activo')
            ->get();

        $agrupados = $activos
            ->groupBy(fn($a) => $a->nombre.'|'.$a->estado_fisico.'|'.$a->id_fuente.'|'.$a->gestion)
            ->map(function ($grupo) {
                $first = $grupo->first();
                return (object) [
                    'nombre'        => $first->nombre,
                    'cantidad'      => $grupo->count(),
                    'codigos'       => $grupo->pluck('codigo_activo')->implode(', '),
                    'codigos_array' => $grupo->pluck('codigo_activo')->toArray(),
                    'ids_array'     => $grupo->pluck('id_activo')->toArray(),
                    'estado_fisico' => $first->estado_fisico,
                    'estado_texto'  => $first->estado_fisico_texto,
                    'fuente'        => $first->fuente->nombre ?? '—',
                    'fuente_codigo' => $first->fuente->codigo ?? '',
                    'gestion'       => $first->gestion,
                    'marca'         => $first->marca,
                    'modelo'        => $first->modelo,
                ];
            })->values();

        $totalActivos   = $activos->count();
        $totalBuenos    = $activos->where('estado_fisico', 'B')->count();
        $totalRegulares = $activos->where('estado_fisico', 'R')->count();
        $totalMalos     = $activos->whereIn('estado_fisico', ['M','FF'])->count();

        $categorias = Categoria::where('id_ambiente', $ambiente->id_ambiente ?? null)->get();
        $fuentes    = FuenteFinanciamiento::orderBy('nombre')->get();
        $usuarios   = User::where('estado', 'ACTIVO')->orderBy('nombre_completo')->get();

        return view('categorias.show', compact(
            'ambiente', 'carrera', 'categoria', 'activos', 'agrupados',
            'totalActivos', 'totalBuenos', 'totalRegulares', 'totalMalos',
            'categorias', 'fuentes', 'usuarios'
        ));
    }

    // ==========================================
<<<<<<< HEAD
    // EDIT — Devuelve JSON para el modal por AJAX ⭐ CORREGIDO
=======
    // EDIT — Solo admin
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
    // ==========================================
    public function edit($id)
    {
        $this->authorizeActivoModification();
<<<<<<< HEAD
        $activo = ActivoFijo::findOrFail($id);
        return response()->json($activo);
    }

    // ==========================================
    // UPDATE — Solo admin (CON 3 IMÁGENES)
=======

        $activo = ActivoFijo::findOrFail($id);

        $categorias = Categoria::orderBy('nombre')->get();
        $ambientes  = Ambiente::orderBy('nombre')->get();
        $fuentes    = FuenteFinanciamiento::orderBy('nombre')->get();
        $usuarios   = User::where('estado', 'ACTIVO')->orderBy('nombre_completo')->get();
        $items      = Item::orderBy('numero_item')->get();

        return view('activos.edit', compact('activo', 'categorias', 'ambientes', 'fuentes', 'usuarios', 'items'));
    }

    // ==========================================
    // UPDATE — Solo admin
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
    // ==========================================
    public function update(Request $request, $id)
    {
        $this->authorizeActivoModification();

        $activo = ActivoFijo::findOrFail($id);
<<<<<<< HEAD
        $tipoBien = $request->input('tipo_bien', $activo->tipo_bien);

        $data = $request->validate([
            'codigo_activo'     => ['required', 'string', 'max:50', \Illuminate\Validation\Rule::unique('activos_fijos', 'codigo_activo')->ignore($activo->id_activo, 'id_activo')],
            'tipo_bien'         => 'required|in:ACTIVO_FIJO,NO_ACTIVO',
            'nombre'            => 'required|string|max:150',
            'marca'             => $tipoBien === 'ACTIVO_FIJO' ? 'required|string|max:80' : 'nullable|string|max:80',
            'modelo'            => $tipoBien === 'ACTIVO_FIJO' ? 'required|string|max:80' : 'nullable|string|max:80',
            'numero_serie'      => $tipoBien === 'ACTIVO_FIJO' ? 'required|string|max:80' : 'nullable|string|max:80',
            'descripcion'       => 'required|string|max:500',
            'id_ambiente'       => 'required|exists:ambientes,id_ambiente',
            'id_categoria'      => 'required|exists:categorias,id_categoria',
            'id_fuente'         => 'required|exists:fuentes_financiamiento,id_fuente',
            'id_custodio'       => 'required|exists:usuarios,id_usuario',
            'estado_fisico'     => 'required|in:B,R,M,FF',
            'fecha_adquisicion' => 'required|date',
            'valor_adquisicion' => 'required|numeric|min:0',
            'imagen'            => 'nullable|image|max:5120',
        ]);

        $data['tipo_bien'] = $tipoBien;
=======
        $data   = $request->validate(
            ActivoFijo::rules($id, $request->input('tipo_bien', $activo->tipo_bien)),
            ActivoFijo::$messages
        );

        $data['tipo_bien'] = $request->input('tipo_bien', $activo->tipo_bien);

        // El ítem es del custodio, no del activo. Siempre se deriva del custodio.
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
        $data['id_item'] = $this->itemDelCustodio($data['id_custodio'] ?? null);

        if ($request->hasFile('imagen')) {
            if ($activo->imagen && Storage::disk('public')->exists($activo->imagen)) {
                Storage::disk('public')->delete($activo->imagen);
            }
            $data['imagen'] = $request->file('imagen')->store('activos', 'public');
        } else {
            unset($data['imagen']);
        }

        if (isset($data['codigo_activo']) && $data['codigo_activo'] !== $activo->codigo_activo) {
            try {
                if ($activo->ruta_qr && Storage::disk('public')->exists($activo->ruta_qr)) {
                    Storage::disk('public')->delete($activo->ruta_qr);
                }
                $data = array_merge($data, $this->generarQRParaActivo($data['codigo_activo']));
            } catch (\Throwable $e) {
                Log::warning('Error regenerando QR: ' . $e->getMessage());
            }
        }

        $activo->update($data);

<<<<<<< HEAD
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Activo actualizado correctamente.']);
        }

        return redirect()->route('categorias.show', $activo->id_categoria)
=======
        return redirect()->route('activos.index')
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
            ->with('success', 'Activo actualizado correctamente.');
    }

    // ==========================================
    // DESTROY — Solo admin
    // ==========================================
    public function destroy($id)
    {
        $this->authorizeActivoModification();

        $activo = ActivoFijo::findOrFail($id);
<<<<<<< HEAD
        $idCategoria = $activo->id_categoria;
=======
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c

        if ($activo->imagen && Storage::disk('public')->exists($activo->imagen)) {
            Storage::disk('public')->delete($activo->imagen);
        }
        if ($activo->ruta_qr && Storage::disk('public')->exists($activo->ruta_qr)) {
            Storage::disk('public')->delete($activo->ruta_qr);
        }

        $activo->delete();

<<<<<<< HEAD
        return redirect()->route('categorias.show', $idCategoria)
            ->with('success', 'Activo eliminado correctamente.');
    }

    public function actaAltaPdf($id)
    {
        $activo = $this->activoVisible($id);

        $pdf = Pdf::loadView('actas.alta_pdf', compact('activo'))
            ->setPaper('letter', 'landscape')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultMediaType' => 'screen',
                'isFontSubsettingEnabled' => true,
            ]);

        return $pdf->stream('acta_alta_' . $activo->codigo_activo . '.pdf');
    }

=======
        return redirect()->route('activos.index')
            ->with('success', 'Activo eliminado correctamente.');
    }

    // ==========================================
    // TARJETA INDIVIDUAL (HTML) — TODOS ven
    // ==========================================
    public function tarjeta($id)
    {
        $activo = $this->activoVisible($id);

        return view('activos.tarjeta', compact('activo'));
    }

    // ==========================================
    // TARJETA INDIVIDUAL (PDF) — TODOS ven
    // ==========================================
    public function tarjetaPdf($id)
    {
        $activo = $this->activoVisible($id);

        $pdf = Pdf::loadView('activos.tarjeta_pdf', compact('activo'))
            ->setPaper('letter', 'portrait')
            ->setOption(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);

        return $pdf->stream('tarjeta_' . $activo->codigo_activo . '.pdf');
    }

    // ==========================================
    // BUSCAR POR CÓDIGO (para escáner QR) — TODOS
    // ==========================================
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
    public function buscarPorCodigo(Request $request, $codigo = null)
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        $codigoLimpio = trim((string) ($codigo ?: $request->query('codigo')));

        if ($codigoLimpio === '') {
            return response()->json([
                'success' => false,
                'message' => 'Indica el código del activo.',
            ], 422);
        }

<<<<<<< HEAD
=======
        // El QR puede traer la URL completa del propio sistema, no solo el
        // código suelto.
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
        if (preg_match('#/activos/codigo/([^/?]+)#', $codigoLimpio, $coincidencias)) {
            $codigoLimpio = urldecode($coincidencias[1]);
        }

        $codigoLimpio = trim($codigoLimpio);

<<<<<<< HEAD
        $activo = ActivoFijo::with(['custodio', 'ambiente.carrera', 'categoria'])
            ->paraUsuario($user)
            ->where('estado_registro', '!=', 'BAJA')
=======
// Coincidencia exacta primero: un código parcial no debe devolver
        // el primer activo que se parezca.
        $activo = ActivoFijo::with(['custodio', 'ambiente.carrera', 'categoria'])
            ->paraUsuario($user)
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
            ->where(function ($q) use ($codigoLimpio) {
                $q->where('codigo_activo', $codigoLimpio)
                    ->orWhere('numero_serie', $codigoLimpio);
            })
            ->first();

        if (! $activo) {
<<<<<<< HEAD
            return response()->json([
                'success' => false,
                'message' => 'El código QR no se encuentra registrado o se encuentra dado de baja.',
=======
            $activo = ActivoFijo::with(['custodio', 'ambiente.carrera', 'categoria'])
                ->paraUsuario($user)
                ->where(function ($q) use ($codigoLimpio) {
                    $q->where('codigo_activo', 'like', "%{$codigoLimpio}%")
                        ->orWhere('numero_serie', 'like', "%{$codigoLimpio}%");
                })
                ->first();
        }

        if (! $activo) {
            return response()->json([
                'success' => false,
                'message' => 'El código QR no se encuentra registrado en el sistema.',
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
            ], 404);
        }

        $ambienteId = $request->query('ambiente_id');
<<<<<<< HEAD
        $esDelAmbiente = $ambienteId ? $activo->id_ambiente == $ambienteId : true;
=======

        $esDelAmbiente = $ambienteId ? $activo->id_ambiente == $ambienteId : true;

>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
        $esMio = (int) $activo->id_custodio === (int) $user->id_usuario;

        return response()->json([
            'success' => true,
            'es_del_ambiente' => $esDelAmbiente,
            'es_mi_activo' => $esMio,
            'ambiente_escaneado' => $ambienteId ? (int) $ambienteId === (int) $activo->id_ambiente : null,
            'activo' => [
                'id' => $activo->id_activo,
                'codigo_activo' => $activo->codigo_activo,
                'nombre' => $activo->nombre,
                'marca' => $activo->marca,
                'modelo' => $activo->modelo,
                'numero_serie' => $activo->numero_serie,
                'tipo_bien' => $activo->tipo_bien,
                'tipo_bien_texto' => $activo->tipo_bien_texto,
                'estado_registro' => $activo->estado_registro,
                'estado_registro_texto' => $activo->estado_registro_texto,
                'estado_fisico_texto' => $activo->estado_fisico_texto,
                'id_ambiente' => $activo->id_ambiente,
                'ambiente' => $activo->ambiente?->nombre,
                'id_carrera' => $activo->ambiente?->id_carrera,
                'carrera' => $activo->ambiente?->carrera?->nombre,
                'id_categoria' => $activo->id_categoria,
                'categoria' => $activo->categoria?->nombre,
                'id_custodio' => $activo->id_custodio,
                'custodio' => $activo->custodio?->nombre_completo,
            ],
        ]);
    }

<<<<<<< HEAD
=======
    // ==========================================
    // DESCARGAR QR — TODOS
    // ==========================================
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
    public function descargarQr($id)
    {
        $activo = ActivoFijo::findOrFail($id);

        if ($activo->ruta_qr && Storage::disk('public')->exists($activo->ruta_qr)) {
            $path = Storage::disk('public')->path($activo->ruta_qr);
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            return response()->download($path, 'QR-' . $activo->codigo_activo . '.' . $extension);
        }

        return back()->with('error', 'El archivo QR no existe. Regenera el activo.');
    }

<<<<<<< HEAD
=======
    // ==========================================
    // EXPORTAR PDF — TODOS
    // ==========================================
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
    public function pdf(Request $request)
    {
        $ambiente  = null;
        $categoria = null;
        $tipoBien  = $this->tipoBienExportado($request);

        $query = ActivoFijo::with(['categoria', 'ambiente.carrera', 'fuente', 'custodio', 'item'])
<<<<<<< HEAD
            ->where('estado_registro', '!=', 'BAJA')
=======
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
            ->tipoBien($tipoBien);

        if ($request->filled('id_ambiente')) {
            $ambiente = Ambiente::find($request->id_ambiente);
            $query->where('id_ambiente', $request->id_ambiente);
        }
        if ($request->filled('id_categoria')) {
            $categoria = Categoria::find($request->id_categoria);
            $query->where('id_categoria', $request->id_categoria);
        }
        if ($request->filled('buscar')) {
            $s = $request->buscar;
            $query->where(function ($q) use ($s) {
                $q->where('codigo_activo', 'like', "%{$s}%")
                  ->orWhere('nombre', 'like', "%{$s}%")
                  ->orWhere('numero_serie', 'like', "%{$s}%");
            });
        }

        $activos = $query->orderBy('tipo_bien')->orderBy('nombre')->get();

        $pdf = PdfHelper::oficio(
            'reportes.pdf.inventario_general',
            ['activos' => $activos, 'agrupados' => $this->agruparPorNombre($activos), 'tipoBien' => $tipoBien],
            'landscape'
        );

        return $pdf->stream('Inventario_' . $this->sufijoTipoBien($tipoBien) . date('Y-m-d_His') . '.pdf');
    }

<<<<<<< HEAD
=======
    // ==========================================
    // EXPORTAR EXCEL — TODOS
    // ==========================================
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
    public function excel(Request $request)
    {
        $ambiente  = null;
        $categoria = null;
        $tipoBien  = $this->tipoBienExportado($request);

        $query = ActivoFijo::with(['categoria', 'ambiente.carrera', 'fuente', 'custodio', 'item'])
<<<<<<< HEAD
            ->where('estado_registro', '!=', 'BAJA')
=======
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
            ->tipoBien($tipoBien);

        if ($request->filled('id_ambiente')) {
            $ambiente = Ambiente::find($request->id_ambiente);
            $query->where('id_ambiente', $request->id_ambiente);
        }
        if ($request->filled('id_categoria')) {
            $categoria = Categoria::find($request->id_categoria);
            $query->where('id_categoria', $request->id_categoria);
        }
        if ($request->filled('buscar')) {
            $s = $request->buscar;
            $query->where(function ($q) use ($s) {
                $q->where('codigo_activo', 'like', "%{$s}%")
                  ->orWhere('nombre', 'like', "%{$s}%")
                  ->orWhere('numero_serie', 'like', "%{$s}%");
            });
        }

        $activos = $query->orderBy('tipo_bien')->orderBy('nombre')->get();

        return response()
            ->view('reportes.excel.inventario_general', compact('activos', 'tipoBien'))
            ->header('Content-Type', 'application/vnd.ms-excel; charset=utf-8')
            ->header('Content-Disposition',
                'attachment; filename="Inventario_' . $this->sufijoTipoBien($tipoBien) . date('Y-m-d') . '.xls"');
    }

<<<<<<< HEAD
    private function tipoBienExportado(Request $request): string
    {
        $tipo = $request->input('tipo_bien', 'TODOS');
=======
    /**
     * Filtro de tipo de bien para las exportaciones:
     * TODOS (default), ACTIVO_FIJO o NO_ACTIVO.
     */
    private function tipoBienExportado(Request $request): string
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

<<<<<<< HEAD
    protected function activoVisible($id): ActivoFijo
    {
        return ActivoFijo::paraUsuario(Auth::user())->where('estado_registro', '!=', 'BAJA')->findOrFail($id);
    }

=======
    // ==========================================
    // ALCANCE: un activo que no está dentro del ámbito del usuario
    // no se muestra, ni aunque se conozca su número.
    // ==========================================
    protected function activoVisible($id): ActivoFijo
    {
        $activo = ActivoFijo::paraUsuario(Auth::user())->findOrFail($id);

        return $activo;
    }

    /**
     * Agrega por nombre para no repetir la misma descripción en cada fila.
     */
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
    private function agruparPorNombre($activos)
    {
        return $activos->groupBy(fn ($a) => $a->nombre.'|'.$a->marca.'|'.$a->modelo)
            ->map(function ($grupo, $clave) {
                $primero = $grupo->first();

                return (object) [
                    'codigos' => $grupo->pluck('codigo_activo')->implode(', '),
                    'nombre' => $primero->nombre,
                    'descripcion' => $primero->descripcion,
                    'marca' => $primero->marca,
                    'modelo' => $primero->modelo,
                    'cantidad' => $grupo->count(),
                    'estado_texto' => $primero->estado_registro_texto,
                    'fuente_codigo' => $primero->fuente?->codigo ?? '—',
                    'gestion' => $primero->gestion,
                    'observaciones' => $primero->observaciones,
                    'tipo_bien_texto' => $primero->tipo_bien_texto,
                ];
            })
            ->values();
    }

<<<<<<< HEAD
=======
    // ==========================================
    // HELPER: Generar QR
    // ==========================================
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
    protected function generarQRParaActivo(string $codigoActivo): array
    {
        $contenido = route('activos.buscarPorCodigo', ['codigo' => $codigoActivo]);
        $fileName  = 'qrcodes/' . Str::slug($codigoActivo) . '-' . uniqid() . '.svg';

        $svg = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')
            ->size(300)
            ->margin(1)
            ->generate($contenido);

        Storage::disk('public')->put($fileName, $svg);

        return [
            'codigo_qr' => $contenido,
            'qr_code'   => $fileName,
            'ruta_qr'   => $fileName,
        ];
    }

<<<<<<< HEAD
=======
    // ==========================================
    // VER ACTIVOS DE UN GRUPO (dentro de categoría)
    // ==========================================
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
    public function verGrupo($id_categoria, $nombre)
    {
        $categoria = Categoria::with('ambiente.carrera')->findOrFail($id_categoria);
        $ambiente  = $categoria->ambiente;
        $carrera   = $ambiente?->carrera;

        $nombreDecoded = urldecode($nombre);

        $activos = ActivoFijo::paraUsuario(Auth::user())
            ->where('id_categoria', $categoria->id_categoria)
<<<<<<< HEAD
            ->where('estado_registro', '!=', 'BAJA')
=======
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
            ->where('nombre', 'LIKE', "%{$nombreDecoded}%")
            ->with(['ambiente', 'custodio', 'fuente'])
            ->orderBy('codigo_activo')
            ->get();

        $totalActivos   = $activos->count();
        $totalBuenos    = $activos->where('estado_fisico', 'B')->count();
        $totalRegulares = $activos->where('estado_fisico', 'R')->count();
        $totalMalos     = $activos->whereIn('estado_fisico', ['M','FF'])->count();

        $fuentes    = FuenteFinanciamiento::orderBy('nombre')->get();
        $usuarios   = User::where('estado', 'ACTIVO')->orderBy('nombre_completo')->get();

        return view('categorias.grupo', compact(
            'categoria', 'ambiente', 'carrera',
            'activos', 'nombreDecoded',
            'totalActivos', 'totalBuenos', 'totalRegulares', 'totalMalos',
            'fuentes', 'usuarios'
        ));
    }

<<<<<<< HEAD
    public function etiqueta($id)
    {
        $activo = $this->activoVisible($id);
=======
    // ==========================================
    // ETIQUETA DEL ACTIVO (con QR lateral)
    // ==========================================
    public function etiqueta($id)
    {
        $activo = $this->activoVisible($id);

>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
        $qrImage = '';

        if ($activo->ruta_qr && Storage::disk('public')->exists($activo->ruta_qr)) {
            $qrImage = Storage::disk('public')->get($activo->ruta_qr);
        } else {
            try {
                $contenido = route('activos.buscarPorCodigo', ['codigo' => $activo->codigo_activo]);
                $qrImage = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')
                    ->size(300)
                    ->margin(1)
                    ->generate($contenido);
            } catch (\Throwable $e) {
                $qrImage = '<p style="color:#dc2626;font-size:10px;">QR no disponible</p>';
            }
        }

        return view('activos.etiqueta', compact('activo', 'qrImage'));
    }
<<<<<<< HEAD

    // ============================================================
    // NO ACTIVOS — Artículos clasificados como No Activos (ej. grapadoras, lápices)
    // ============================================================
    public function noActivos(Request $request)
    {
        $query = ActivoFijo::with(['categoria', 'ambiente.carrera', 'fuente', 'custodio'])
            ->where('tipo_bien', 'NO_ACTIVO')
            ->where('estado_registro', '!=', 'BAJA');

        if ($request->filled('buscar')) {
            $s = $request->buscar;
            $query->where(function ($q) use ($s) {
                $q->where('codigo_activo', 'like', "%{$s}%")
                  ->orWhere('nombre', 'like', "%{$s}%")
                  ->orWhere('numero_serie', 'like', "%{$s}%")
                  ->orWhere('marca', 'like', "%{$s}%")
                  ->orWhere('modelo', 'like', "%{$s}%");
            });
        }

        $activos = $query->orderByDesc('updated_at')->get();
        $totalNoActivos = $activos->count();

        return view('activos.no_activos', compact('activos', 'totalNoActivos'));
    }

    public function tarjeta($id)
    {
        $activo = ActivoFijo::with([
            'categoria',
            'ambiente.carrera',
            'fuenteFinanciamiento',
            'custodioActual'
        ])->where('estado_registro', '!=', 'BAJA')->findOrFail($id);

        return view('activos.tarjeta', compact('activo'));
    }

    public function activosBaja(Request $request)
    {
        $user = Auth::user();

        $query = \App\Models\ActivoFijo::with(['categoria', 'ambiente.carrera', 'custodio'])
            ->paraUsuario($user)
            ->where('estado_registro', 'BAJA');

        if ($request->filled('q')) {
            $bus = $request->q;
            $query->where(function ($s) use ($bus) {
                $s->where('codigo_activo', 'like', "%{$bus}%")
                  ->orWhere('nombre', 'like', "%{$bus}%")
                  ->orWhere('marca', 'like', "%{$bus}%");
            });
        }

        $activos = $query->orderBy('updated_at', 'desc')->paginate(15)->appends($request->query());

        return view('activos.baja', compact('activos'));
    }
=======
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
}
