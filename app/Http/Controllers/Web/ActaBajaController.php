<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ActaBaja;
use App\Models\ActivoFijo;
<<<<<<< HEAD
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
=======
use App\Models\Ambiente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c

class ActaBajaController extends Controller
{
    // ============================================================
    // INDEX — Listado de actas de baja
    // ============================================================
    public function index(Request $request)
    {
        $user = Auth::user();

<<<<<<< HEAD
        $query = ActaBaja::with(['activo', 'usuario', 'aprobador'])->latest();

=======
        $query = ActaBaja::with(['activo.categoria', 'activo.ambiente', 'usuario', 'aprobador', 'activoSustituto'])
            ->orderByDesc('id_acta_baja');

        // La administración ve todas; los demás solo las suyas
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
        if (! $user->esAdmin()) {
            $query->where('id_usuario', $user->id_usuario);
        }

        if ($request->filled('estado') && in_array($request->estado, [
            ActaBaja::ESTADO_PENDIENTE,
            ActaBaja::ESTADO_APROBADA,
            ActaBaja::ESTADO_RECHAZADA,
        ], true)) {
            $query->where('estado', $request->estado);
        }

        $actas = $query->paginate(15)->appends($request->query());
<<<<<<< HEAD
        $pendientes = ActaBaja::where('estado', ActaBaja::ESTADO_PENDIENTE)->count();

        return view('actas.baja.index', compact('actas', 'pendientes'));
    }

    // ============================================================
    // CREATE — Formulario de solicitud de baja
=======

        return view('actas.baja.index', compact('actas'));
    }

    // ============================================================
    // CREATE — Formulario
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
    // ============================================================
    public function create(Request $request)
    {
        $user = Auth::user();

<<<<<<< HEAD
        $query = ActivoFijo::with(['categoria', 'ambiente.carrera', 'custodio'])
            ->paraUsuario($user)
            ->where('estado_registro', '!=', 'BAJA')
            ->where('estado_registro', '!=', 'EN_TRANSFERENCIA');

        if ($request->filled('q')) {
            $bus = $request->q;
            $query->where(function ($s) use ($bus) {
                $s->where('codigo_activo', 'like', "%{$bus}%")
                  ->orWhere('nombre', 'like', "%{$bus}%");
            });
        }

        $activos = $query->orderBy('nombre')->get();
=======
        $query = ActivoFijo::with(['categoria', 'ambiente.carrera'])
            ->paraUsuario($user)
            ->where('estado_registro', '!=', 'BAJA');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('codigo_activo', 'like', "%{$q}%")
                    ->orWhere('nombre', 'like', "%{$q}%");
            });
        }

        $activos = $query->get();
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c

        return view('actas.baja.create', compact('activos'));
    }

    // ============================================================
<<<<<<< HEAD
    // STORE — Registro de baja (Inmediato si es Admin, Solicitud si es Inventariador)
=======
    // STORE — Registrar la SOLICITUD. El bien no se da de baja todavía.
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
    // ============================================================
    public function store(Request $request)
    {
        $user = Auth::user();

        if (! $user->puedeSolicitarBajaOTransferencia()) {
            abort(403, 'No tiene permisos para solicitar bajas.');
        }

<<<<<<< HEAD
        // ⭐ Capturar el ID del activo de cualquier formato enviado (incluyendo activo_ids[])
        $idActivoSeleccionado = $request->input('id_activo')
            ?? $request->input('activo_id')
            ?? ($request->input('activos')[0] ?? null)
            ?? ($request->input('activo_ids')[0] ?? null);

        $textoMotivo = $request->input('motivo') ?? $request->input('motivo_baja');

        if (! $textoMotivo) {
            return back()->withInput()->withErrors(['motivo' => 'El motivo de la baja es obligatorio.']);
        }

        if (! $idActivoSeleccionado) {
            return back()->withInput()->withErrors(['id_activo' => 'Debe seleccionar un activo para dar de baja.']);
        }

        $activo = ActivoFijo::findOrFail($idActivoSeleccionado);
=======
        $data = $request->validate([
            'activo_ids'          => 'required|array|min:1',
            'activo_ids.*'        => 'required|exists:activos_fijos,id_activo',
            'motivo_baja'         => 'required|string|max:500',
            'observaciones'       => 'nullable|string|max:500',
            'es_sustitucion'      => 'nullable|boolean',
            'sustituto_de'       => 'nullable|required_if:es_sustitucion,1|exists:activos_fijos,id_activo',
            'sustituto_codigo'    => 'nullable|required_if:es_sustitucion,1|string|max:50|unique:activos_fijos,codigo_activo',
            'sustituto_nombre'    => 'nullable|required_if:es_sustitucion,1|string|max:150',
            'sustituto_marca'     => 'nullable|string|max:80',
            'sustituto_modelo'    => 'nullable|string|max:80',
            'sustituto_serie'     => 'nullable|string|max:80',
            'sustituto_valor'     => 'nullable|numeric|min:0',
            'sustituto_fecha'     => 'nullable|date',
        ], [
            'activo_ids.required'          => 'Debe seleccionar al menos un activo.',
            'motivo_baja.required'         => 'El motivo de la baja es obligatorio.',
            'sustituto_codigo.required_if' => 'Para una sustitución debes indicar el código del equipo nuevo.',
            'sustituto_nombre.required_if' => 'Para una sustitución debes indicar el nombre del equipo nuevo.',
            'sustituto_de.required_if'    => 'Indica a qué equipo de la lista sustituye el equipo nuevo.',
        ]);

        // Validar scoping
        $permitidos = ActivoFijo::select('id_activo')->paraUsuario($user)->pluck('id_activo');
        $fuera = array_diff($request->input('activo_ids'), $permitidos->all());
        if (! empty($fuera)) {
            abort(403, 'Uno o más activos no pertenecen a su ámbito.');
        }

        $esSustitucion = $request->boolean('es_sustitucion');

        if ($esSustitucion && ! in_array((int) $request->input('sustituto_de'), array_map('intval', $data['activo_ids']), true)) {
            return back()->withInput()->with('error', 'El equipo sustituido debe estar entre los activos seleccionados.');
        }

        // Un equipo con baja pendiente no puede volver a solicitarse
        $conBajaPendiente = ActaBaja::pendientes()
            ->whereIn('id_activo', $request->input('activo_ids'))
            ->pluck('id_activo');

        if ($conBajaPendiente->isNotEmpty()) {
            return back()->withInput()->with(
                'error',
                'Uno o más activos ya tienen una baja pendiente de aprobación.'
            );
        }
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c

        $numero = 'BAJA-' . now()->format('Y') . '-' . str_pad(
            (string) ((ActaBaja::max('id_acta_baja') ?? 0) + 1),
            4, '0', STR_PAD_LEFT
        );

<<<<<<< HEAD
        $esAdmin = $user->esAdmin();

        $acta = DB::transaction(function () use ($request, $activo, $user, $numero, $esAdmin, $idActivoSeleccionado, $textoMotivo) {
            $acta = ActaBaja::create([
                'numero_acta'      => $numero,
                'id_activo'        => $idActivoSeleccionado,
                'id_usuario'       => $user->id_usuario,
                'motivo'           => $textoMotivo,
                'fecha_baja'       => now(),
                'observaciones'    => $request->input('observaciones') ?? null,
                'estado'           => $esAdmin ? ActaBaja::ESTADO_APROBADA : ActaBaja::ESTADO_PENDIENTE,
                'id_aprobador'     => $esAdmin ? $user->id_usuario : null,
                'fecha_aprobacion' => $esAdmin ? now() : null,
            ]);

            if ($esAdmin) {
                $activo->update([
                    'estado_registro' => 'BAJA',
                ]);
            } else {
                $activo->update([
                    'estado_registro' => 'EN_REVISION_BAJA',
                ]);
            }

            return $acta;
        });

        $mensaje = $esAdmin
            ? "Acta de baja {$numero} registrada y aplicada de inmediato (Modo Administrador)."
            : "Solicitud de baja {$numero} enviada. Queda pendiente de aprobación de la administración.";

        return redirect()
            ->route('actas.baja.show', $acta)
            ->with('status', $mensaje);
    }

    // ============================================================
    // APROBAR — Solo administración
=======
        $datosSustituto = $esSustitucion ? [
            'codigo_activo'     => $data['sustituto_codigo'],
            'nombre'            => $data['sustituto_nombre'],
            'marca'             => $data['sustituto_marca'] ?? null,
            'modelo'            => $data['sustituto_modelo'] ?? null,
            'numero_serie'      => $data['sustituto_serie'] ?? null,
            'valor_adquisicion' => $data['sustituto_valor'] ?? null,
            'fecha_adquisicion' => $data['sustituto_fecha'] ?? null,
        ] : null;

        $acta = DB::transaction(function () use ($request, $data, $user, $numero, $esSustitucion, $datosSustituto) {
            // Una solicitud de baja por activo: la aprobación es individual
            $actaIds = [];
            foreach ($data['activo_ids'] as $aid) {
                $sustitucionDeEste = $esSustitucion && $aid === (int) $request->input('sustituto_de');

                $nuevaActa = ActaBaja::create([
                    'numero_acta'           => $actaIds ? $numero . '-' . count($actaIds) : $numero,
                    'id_activo'             => $aid,
                    'id_usuario'            => $user->id_usuario,
                    'motivo'                => $data['motivo_baja'],
                    'fecha_baja'            => now()->toDateString(),
                    'archivo_resolucion'    => ($data['observaciones'] ?? null)
                        ? \Illuminate\Support\Str::limit($data['observaciones'], 250, '…')
                        : null,
                    'estado'                => ActaBaja::ESTADO_PENDIENTE,
                    'es_sustitucion'        => $sustitucionDeEste,
                    'datos_sustituto'       => $sustitucionDeEste ? $datosSustituto : null,
                ]);

                $actaIds[] = $nuevaActa->id_acta_baja;
            }

            return $actaIds[0];
        });

        return redirect()
            ->route('actas.baja.show', $acta)
            ->with('status', 'Solicitud de baja registrada. Queda pendiente hasta que la administración la apruebe.');
    }

    // ============================================================
    // APROBAR — Solo administración. Aquí sí se da de baja.
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
    // ============================================================
    public function aprobar(Request $request, ActaBaja $acta)
    {
        $this->autorizarAprobacion($acta);

<<<<<<< HEAD
        DB::transaction(function () use ($acta, $request) {
            $acta->update([
                'estado'           => ActaBaja::ESTADO_APROBADA,
                'id_aprobador'     => $request->user()->id_usuario,
                'fecha_aprobacion' => now(),
            ]);

            $acta->activo?->update([
                'estado_registro' => 'BAJA',
            ]);
        });

        return back()->with('status', "Acta de baja {$acta->numero_acta} aprobada. El activo fue dado de baja correctamente.");
    }

    // ============================================================
    // RECHAZAR — Cancela la solicitud
=======
        $data = $request->validate([
            'comentario'      => 'nullable|string|max:500',
            'id_ambiente_almacen' => 'nullable|exists:ambientes,id_ambiente',
        ]);

        $sustituto = null;

        DB::transaction(function () use ($acta, $data, $request, &$sustituto) {
            $acta->update([
                'estado'                => ActaBaja::ESTADO_APROBADA,
                'id_aprobador'          => $request->user()->id_usuario,
                'fecha_aprobacion'      => now(),
                'comentario_aprobacion' => $data['comentario'] ?? null,
            ]);

            $viejo = $acta->activo;
            $datos = $acta->datos_sustituto;

            // Sustitución: entra el equipo nuevo y el viejo queda de baja
            // guardado en el almacén.
            if ($acta->es_sustitucion && $viejo && is_array($datos) && ! empty($datos['codigo_activo'])) {
                $sustituto = $this->registrarSustituto($acta, $viejo, $datos);
            }

            if ($viejo) {
                $cambios = ['estado_registro' => 'BAJA'];

                // El equipo dado de baja se guarda en el almacén.
                $almacen = $data['id_ambiente_almacen'] ?? null ?: $this->ambienteAlmacen();
                if ($almacen) {
                    $cambios['id_ambiente'] = $almacen;
                }

                $viejo->update($cambios);
            }

            if ($sustituto) {
                $acta->update(['id_activo_sustituto' => $sustituto->id_activo]);
            }
        });

        $mensaje = "Baja {$acta->numero_acta} aprobada.";

        if ($sustituto) {
            $mensaje .= " El equipo {$sustituto->codigo_activo} quedó registrado como sustituto.";
        }

        return back()->with('status', $mensaje);
    }

    // ============================================================
    // RECHAZAR — El bien no se toca.
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
    // ============================================================
    public function rechazar(Request $request, ActaBaja $acta)
    {
        $this->autorizarAprobacion($acta);

<<<<<<< HEAD
        DB::transaction(function () use ($acta, $request) {
            $acta->update([
                'estado'           => ActaBaja::ESTADO_RECHAZADA,
                'id_aprobador'     => $request->user()->id_usuario,
                'fecha_aprobacion' => now(),
            ]);

            $acta->activo?->update([
                'estado_registro' => 'ASIGNADO',
            ]);
        });

        return back()->with('status', "Acta de baja {$acta->numero_acta} rechazada. El bien vuelve a estado asignado.");
=======
        $data = $request->validate([
            'comentario' => 'nullable|string|max:500',
        ]);

        $acta->update([
            'estado'                => ActaBaja::ESTADO_RECHAZADA,
            'id_aprobador'          => $request->user()->id_usuario,
            'fecha_aprobacion'      => now(),
            'comentario_aprobacion' => $data['comentario'] ?? 'Rechazado por la administración.',
        ]);

        return back()->with('status', "Baja {$acta->numero_acta} rechazada. El bien sigue como estaba.");
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
    }

    protected function autorizarAprobacion(ActaBaja $acta): void
    {
        abort_unless(Auth::user()?->puedeAprobar(), 403, 'Solo la administración aprueba bajas.');
<<<<<<< HEAD
        abort_if($acta->estado !== ActaBaja::ESTADO_PENDIENTE, 422, 'Esta acta ya fue procesada.');
    }

    // ============================================================
    // SHOW — Detalle
    // ============================================================
    public function show(ActaBaja $acta)
    {
        $acta->load(['activo.categoria', 'activo.ambiente.carrera', 'usuario', 'aprobador']);
=======

        abort_if(! $acta->esPendiente(), 422, 'Esta baja ya fue procesada.');
    }

    /**
     * Da de alta el equipo que sustituye al viejo: entra a trabajar en el
     * mismo ambiente y con el mismo custodio que tenía.
     */
    protected function registrarSustituto(ActaBaja $acta, ActivoFijo $viejo, array $datos): ?ActivoFijo
    {
        if (ActivoFijo::where('codigo_activo', $datos['codigo_activo'])->exists()) {
            return null;
        }

        $esActivoFijo = $viejo->tipo_bien !== 'NO_ACTIVO';

        return ActivoFijo::create([
            'codigo_activo'      => $datos['codigo_activo'],
            'nombre'             => $datos['nombre'],
            'descripcion'        => 'Sustituye al activo ' . $viejo->codigo_activo . ' (' . $acta->numero_acta . ').',
            'marca'              => $datos['marca'] ?? null,
            'modelo'             => $datos['modelo'] ?? null,
            'numero_serie'       => $datos['numero_serie'] ?? null,
            'valor_adquisicion'  => $datos['valor_adquisicion'] ?? 0,
            'fecha_adquisicion'  => $datos['fecha_adquisicion'] ?? now()->toDateString(),
            'tipo_bien'          => $viejo->tipo_bien,
            'estado_fisico'      => 'B',
            'estado_registro'    => 'ASIGNADO',
            'id_categoria'       => $viejo->id_categoria,
            'id_ambiente'        => $viejo->id_ambiente,
            'id_fuente'          => $viejo->id_fuente,
            'id_item'            => $viejo->id_item,
            'id_custodio'        => $viejo->id_custodio,
            'observaciones'      => $esActivoFijo ? null : 'Alta como equipo de reposición.',
        ]);
    }

    /**
     * Ambiente de resguardo. Se toma ALM-1 si existe; si no, el ambiente
     * con "almacén" en el nombre.
     */
    protected function ambienteAlmacen(): ?int
    {
        $ambiente = Ambiente::where('codigo', 'ALM-1')->first()
            ?: Ambiente::where('nombre', 'like', '%almac%')->first();

        return $ambiente?->id_ambiente;
    }

    // ============================================================
    // SHOW — Ver acta
    // ============================================================
    public function show($id)
    {
        $acta = ActaBaja::with(['activo.categoria', 'activo.ambiente', 'usuario', 'aprobador', 'activoSustituto'])
            ->findOrFail($id);

        $this->authorizeActa($acta);

>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
        return view('actas.baja.show', compact('acta'));
    }

    // ============================================================
<<<<<<< HEAD
    // PDF — Carta Horizontal (Landscape)
    // ============================================================
    public function pdf(ActaBaja $acta)
    {
        $acta->load(['activo.categoria', 'activo.ambiente.carrera', 'usuario', 'aprobador']);

        $pdf = Pdf::loadView('actas.baja.pdf', compact('acta'))
            ->setPaper('letter', 'landscape')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultMediaType' => 'screen',
                'isFontSubsettingEnabled' => true,
            ]);

        return $pdf->stream('Acta_Baja_' . $acta->numero_acta . '.pdf');
    }
    public function excel(ActaBaja $acta)
    {
        $acta->load(['activo.categoria', 'activo.ambiente.carrera', 'usuario', 'aprobador']);

        return response()->view('actas.baja.excel', compact('acta'));
    }
    // ============================================================
    // DAR DE ALTA — Reactivar un activo dado de baja
    // ============================================================
    public function darDeAlta(Request $request, ActaBaja $acta)
    {
        abort_unless(Auth::user()?->esAdmin(), 403, 'Solo la administración puede dar de alta activos.');

        $data = $request->validate([
            'id_ambiente'  => 'required|exists:ambientes,id_ambiente',
            'id_categoria' => 'required|exists:categorias,id_categoria',
            'id_custodio'  => 'nullable|exists:usuarios,id_usuario',
        ]);

        DB::transaction(function () use ($acta, $data) {
            // Actualizar el estado y ubicación del activo relacionado
            if ($acta->activo) {
                $acta->activo->update([
                    'id_ambiente'     => $data['id_ambiente'],
                    'id_categoria'    => $data['id_categoria'],
                    'id_custodio'     => $data['id_custodio'] ?? $acta->activo->id_custodio,
                    'estado_registro' => 'ASIGNADO',
                ]);
            }

            // Opcional: Marcar el acta como cerrada/anulada o eliminarla lógicamente
            $acta->update([
                'comentario_aprobacion' => ($acta->comentario_aprobacion ? $acta->comentario_aprobacion . ' | ' : '') . 'Activo dado de alta y reasignado.',
            ]);
        });

        return back()->with('status', "El activo de la baja {$acta->numero_acta} ha sido dado de alta y reasignado correctamente.");
=======
    // PDF — Descargar acta
    // ============================================================
    public function pdf($id)
    {
        $acta = ActaBaja::with(['activo.categoria', 'activo.ambiente', 'usuario', 'aprobador', 'activoSustituto'])
            ->findOrFail($id);

        $this->authorizeActa($acta);

        $pdf = Pdf::loadView('actas.baja.pdf', compact('acta'))
            ->setPaper([0, 0, 612, 936], 'portrait') // OFICIO
            ->setOption(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);

        return $pdf->stream('Acta_Baja_' . $acta->numero_acta . '.pdf');
    }

    // ============================================================
    // AUTORIZACIÓN
    // ============================================================
    protected function authorizeActa(ActaBaja $acta): void
    {
        $user = Auth::user();

        if ($user->esAdmin()) {
            return;
        }

        if ((int) $acta->id_usuario === (int) $user->id_usuario) {
            return;
        }

        // Quienes registran en campo pueden revisar las actas de su ámbito.
        if ($user->esOperativo()) {
            return;
        }

        abort(403, 'No autorizado.');
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
    }
}
