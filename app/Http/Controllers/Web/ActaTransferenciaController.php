<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ActaTransferencia;
use App\Models\ActivoFijo;
use App\Models\Ambiente;
use App\Models\User;
use App\Support\PdfHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ActaTransferenciaController extends Controller
{
    // ============================================================
    // INDEX — Listado de transferencias
    // ============================================================
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = ActaTransferencia::with([
            'activo',
            'origenAmbiente',
            'destinoAmbiente',
            'custodioAnterior',
            'custodioNuevo',
            'aprobador',
        ])->latest();

<<<<<<< HEAD
=======
        // La administración ve todas; los demás solo las suyas
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
        if (! $user->esAdmin()) {
            $query->where(function ($q) use ($user) {
                $q->where('id_custodio_anterior', $user->id_usuario)
                  ->orWhere('id_custodio_nuevo', $user->id_usuario);
            });
        }

        if ($request->filled('estado') && in_array($request->estado, [
            ActaTransferencia::ESTADO_PENDIENTE,
            ActaTransferencia::ESTADO_APROBADA,
            ActaTransferencia::ESTADO_RECHAZADA,
        ], true)) {
            $query->where('estado', $request->estado);
        }

        $transferencias = $query->paginate(15)->appends($request->query());

        $ambientesVisibles = $user->ambientesVisibles()->with('carrera')->orderBy('nombre')->get();

        return view('actas.transferencia.index', [
            'transferencias' => $transferencias,
            'activos'        => ActivoFijo::paraUsuario($user)->where('estado_registro', '!=', 'BAJA')->get(),
            'ambientes'      => $ambientesVisibles,
            'usuarios'       => User::where('estado', 'ACTIVO')->orderBy('nombre_completo')->get(),
            'pendientes'     => ActaTransferencia::pendientes()->count(),
        ]);
    }

    // ============================================================
<<<<<<< HEAD
    // CREATE — Formulario de nueva transferencia (CORREGIDO)
=======
    // CREATE — Formulario de nueva transferencia
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
    // ============================================================
    public function create(Request $request)
    {
        $user = Auth::user();

<<<<<<< HEAD
        // Obtener activos disponibles para la transferencia
        $queryActivos = ActivoFijo::with(['categoria', 'ambiente.carrera', 'custodio'])
=======
        // Solo activos dentro del ámbito del usuario, no dados de baja y
        // sin una transferencia pendiente de resolver.
        $query = ActivoFijo::with(['categoria', 'ambiente.carrera', 'custodio'])
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
            ->paraUsuario($user)
            ->where('estado_registro', '!=', 'BAJA')
            ->where('estado_registro', '!=', 'EN_TRANSFERENCIA');

        if ($request->filled('q')) {
            $bus = $request->q;
<<<<<<< HEAD
            $queryActivos->where(function ($s) use ($bus) {
=======
            $query->where(function ($s) use ($bus) {
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
                $s->where('codigo_activo', 'like', "%{$bus}%")
                  ->orWhere('nombre', 'like', "%{$bus}%");
            });
        }

<<<<<<< HEAD
        $activosDisponibles = $queryActivos->orderBy('nombre')->get();

        // Obtener ambientes de destino disponibles
        $ambientesDisponibles = Ambiente::with('carrera')->orderBy('nombre')->get();

        // Obtener usuarios activos (nuevos custodios)
        $usuarios = User::where('estado', 'ACTIVO')
            ->with(['items' => fn($q) => $q->whereNull('item_usuario.fecha_fin')])
            ->orderBy('nombre_completo')
            ->get();

        return view('actas.transferencia.create', compact('activosDisponibles', 'ambientesDisponibles', 'usuarios'));
    }
// ============================================================
    // STORE — Registrar la transferencia
=======
        $activos = $query->get();

        $ambientes = $user->ambientesVisibles()->with('carrera')->orderBy('nombre')->get();
        $usuarios  = User::where('estado', 'ACTIVO')
            ->where('id_usuario', '!=', $user->id_usuario)
            ->orderBy('nombre_completo')
            ->get();

        return view('actas.transferencia.create', compact('activos', 'ambientes', 'usuarios'));
    }

    // ============================================================
    // STORE — Registrar la SOLICITUD. No mueve el bien.
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
    // ============================================================
    public function store(Request $request)
    {
        $user = Auth::user();

<<<<<<< HEAD
=======
        // Permisos: quien verifica en campo y la administración
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
        if (! $user->puedeSolicitarBajaOTransferencia()) {
            abort(403, 'No tiene permisos para solicitar transferencias.');
        }

        $data = $request->validate([
            'id_activo'           => 'required|exists:activos_fijos,id_activo',
<<<<<<< HEAD
            'id_ambiente_destino' => 'required|exists:ambientes,id_ambiente',
            'id_custodio'         => 'required|exists:usuarios,id_usuario',
=======
            'id_destino_ambiente' => 'required|exists:ambientes,id_ambiente',
            'id_custodio_nuevo'   => 'required|exists:usuarios,id_usuario',
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
            'observaciones'       => 'nullable|string|max:500',
            'fecha_transferencia' => 'required|date',
        ], [
            'id_activo.required'           => 'Debe seleccionar un activo.',
<<<<<<< HEAD
            'id_ambiente_destino.required' => 'Debe seleccionar el ambiente destino.',
            'id_custodio.required'         => 'Debe seleccionar el nuevo custodio.',
            'fecha_transferencia.required' => 'La fecha de transferencia es obligatoria.',
        ]);

        $activo = ActivoFijo::with(['categoria.ambiente'])->findOrFail($data['id_activo']);

=======
            'id_destino_ambiente.required' => 'Debe seleccionar el ambiente destino.',
            'id_custodio_nuevo.required'   => 'Debe seleccionar el nuevo custodio.',
            'fecha_transferencia.required' => 'La fecha de transferencia es obligatoria.',
        ]);

        $activo = ActivoFijo::findOrFail($data['id_activo']);

        // Validar scoping: el activo debe estar dentro del ámbito del usuario
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
        $permitidos = ActivoFijo::select('id_activo')->paraUsuario($user)->pluck('id_activo');
        if (! $permitidos->contains($activo->id_activo)) {
            abort(403, 'El activo no pertenece a su ámbito.');
        }

<<<<<<< HEAD
=======
        // Validaciones de negocio
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
        if ($activo->estado_registro === 'BAJA') {
            return back()->withInput()->with('error', 'No se puede transferir un activo dado de baja.');
        }

        if ($activo->estado_registro === 'EN_TRANSFERENCIA') {
            return back()->withInput()->with('error', 'Este activo ya tiene una transferencia pendiente de aprobación.');
        }

<<<<<<< HEAD
        if ((int) $data['id_custodio'] === (int) $activo->id_custodio && (int) $data['id_ambiente_destino'] === (int) $activo->id_ambiente) {
            return back()->withInput()->with('error', 'El activo ya pertenece a ese custodio y se encuentra en el mismo ambiente.');
        }

=======
        if ((int) $data['id_custodio_nuevo'] === (int) $activo->id_custodio) {
            return back()->withInput()->with('error', 'El activo ya pertenece a ese custodio.');
        }

        if ((int) $data['id_destino_ambiente'] === (int) $activo->id_ambiente) {
            return back()->withInput()->with('error', 'El ambiente destino es el mismo de origen.');
        }

        // Generar número de acta corregido usando la llave primaria correcta
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
        $numero = 'TRANS-' . now()->format('Y') . '-' . str_pad(
            (string) ((ActaTransferencia::max('id_acta_transferencia') ?? 0) + 1),
            4, '0', STR_PAD_LEFT
        );

<<<<<<< HEAD
        $esAdmin = $user->esAdmin();

        $acta = DB::transaction(function () use ($data, $activo, $user, $numero, $esAdmin) {
=======
        // El bien espera en el ambiente de origen. Ambiente y custodio solo
        // cambian cuando la administradora apruebe.
        $acta = DB::transaction(function () use ($data, $activo, $user, $numero) {
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
            $acta = ActaTransferencia::create([
                'numero_acta'          => $numero,
                'id_activo'            => $activo->id_activo,
                'id_origen_ambiente'   => $activo->id_ambiente,
<<<<<<< HEAD
                'id_destino_ambiente'  => $data['id_ambiente_destino'],
                'id_custodio_anterior' => $activo->id_custodio ?? $user->id_usuario,
                'id_custodio_nuevo'    => $data['id_custodio'],
                'fecha_transferencia'  => $data['fecha_transferencia'],
                'observaciones'        => $data['observaciones'] ?? null,
                'estado'               => $esAdmin ? ActaTransferencia::ESTADO_APROBADA : ActaTransferencia::ESTADO_PENDIENTE,
                'id_aprobador'         => $esAdmin ? $user->id_usuario : null,
                'fecha_aprobacion'     => $esAdmin ? now() : null,
                'estado_anterior'      => $activo->estado_registro,
            ]);

            if ($esAdmin) {
                // ⭐ Localizar una categoría existente en el ambiente destino que coincida en nombre,
                // o tomar la primera categoría válida del nuevo ambiente de destino.
                $categoriaDestino = \App\Models\Categoria::where('id_ambiente', $data['id_ambiente_destino'])
                    ->where('nombre', $activo->categoria->nombre ?? '')
                    ->first()
                    ?? \App\Models\Categoria::where('id_ambiente', $data['id_ambiente_destino'])->first();

                // Si el ambiente destino no tiene ninguna categoría creada todavía, creamos una por defecto
                if (! $categoriaDestino) {
                    $categoriaDestino = \App\Models\Categoria::create([
                        'id_ambiente' => $data['id_ambiente_destino'],
                        'codigo'      => 'CAT-' . rand(100, 999),
                        'nombre'      => 'General - ' . ($activo->categoria->nombre ?? 'Activos'),
                    ]);
                }

                // ⭐ Traslado completo e inmediato de todos los datos y su nueva ubicación/carrera
                $activo->update([
                    'id_ambiente'     => $data['id_ambiente_destino'],
                    'id_categoria'    => $categoriaDestino->id_categoria,
                    'id_custodio'     => $data['id_custodio'],
                    'estado_registro' => 'ASIGNADO',
                ]);
            } else {
                $activo->update([
                    'estado_registro' => 'EN_TRANSFERENCIA',
                ]);
            }
=======
                'id_destino_ambiente'  => $data['id_destino_ambiente'],
                'id_custodio_anterior' => $activo->id_custodio ?? $user->id_usuario,
                'id_custodio_nuevo'    => $data['id_custodio_nuevo'],
                'fecha_transferencia'  => $data['fecha_transferencia'],
                'observaciones'        => $data['observaciones'] ?? null,
                'estado'               => ActaTransferencia::ESTADO_PENDIENTE,
                'estado_anterior'      => $activo->estado_registro,
            ]);

            $activo->update([
                'estado_registro' => 'EN_TRANSFERENCIA',
            ]);
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c

            return $acta;
        });

<<<<<<< HEAD
        $mensaje = $esAdmin
            ? "Transferencia {$numero} registrada y aplicada de inmediato al nuevo ambiente."
            : "Transferencia {$numero} solicitada. Queda pendiente de aprobación de la administración.";

        return redirect()
            ->route('actas.transferencia.show', $acta)
            ->with('status', $mensaje);
    }
=======
        return redirect()
            ->route('actas.transferencia.show', $acta)
            ->with('status', "Transferencia {$numero} solicitada. Queda pendiente de aprobación de la administración.");
    }

>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
    // ============================================================
    // APROBAR — Solo administración. Aquí sí se mueve el bien.
    // ============================================================
    public function aprobar(Request $request, ActaTransferencia $acta)
    {
        $this->autorizarAprobacion($acta);

        $data = $request->validate([
            'comentario' => 'nullable|string|max:500',
        ]);

        DB::transaction(function () use ($acta, $data, $request) {
            $acta->update([
                'estado'              => ActaTransferencia::ESTADO_APROBADA,
                'id_aprobador'        => $request->user()->id_usuario,
                'fecha_aprobacion'    => now(),
                'comentario_aprobacion' => $data['comentario'] ?? null,
            ]);

            $acta->activo?->update([
                'id_ambiente'     => $acta->id_destino_ambiente,
                'id_custodio'     => $acta->id_custodio_nuevo,
                'estado_registro' => 'ASIGNADO',
            ]);
        });

        return back()->with('status', "Transferencia {$acta->numero_acta} aprobada. El bien ya figura en el ambiente destino.");
    }

    // ============================================================
    // RECHAZAR — Deja el bien como estaba.
    // ============================================================
    public function rechazar(Request $request, ActaTransferencia $acta)
    {
        $this->autorizarAprobacion($acta);

        $data = $request->validate([
            'comentario' => 'nullable|string|max:500',
        ]);

        DB::transaction(function () use ($acta, $data, $request) {
            $acta->update([
                'estado'              => ActaTransferencia::ESTADO_RECHAZADA,
                'id_aprobador'        => $request->user()->id_usuario,
                'fecha_aprobacion'    => now(),
                'comentario_aprobacion' => $data['comentario'] ?? 'Rechazado por la administración.',
            ]);

            $acta->activo?->update([
                'estado_registro' => $acta->estado_anterior ?: 'ASIGNADO',
            ]);
        });

        return back()->with('status', "Transferencia {$acta->numero_acta} rechazada. El bien sigue en su ambiente de origen.");
    }

    protected function autorizarAprobacion(ActaTransferencia $acta): void
    {
        abort_unless(Auth::user()?->puedeAprobar(), 403, 'Solo la administración aprueba transferencias.');
<<<<<<< HEAD
=======

>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
        abort_if(! $acta->esPendiente(), 422, 'Esta transferencia ya fue procesada.');
    }

    // ============================================================
    // SHOW — Ver detalle de una transferencia
    // ============================================================
    public function show(ActaTransferencia $acta)
    {
        $this->authorizeActa($acta);

        $acta->load([
            'activo.categoria',
            'activo.ambiente.carrera',
            'activo.fuente',
            'origenAmbiente.carrera',
            'destinoAmbiente.carrera',
            'custodioAnterior.carrera',
            'custodioNuevo.carrera',
        ]);

        return view('actas.transferencia.show', compact('acta'));
    }

    // ============================================================
<<<<<<< HEAD
    // PDF — Acta de Transferencia en tamaño OFICIO HORIZONTAL
=======
    // PDF — Acta de Transferencia en tamaño OFICIO
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
    // ============================================================
    public function pdf(ActaTransferencia $acta)
    {
        $this->authorizeActa($acta);

        $acta->load([
            'activo.categoria',
            'activo.ambiente.carrera',
            'activo.fuente',
            'origenAmbiente.carrera',
            'destinoAmbiente.carrera',
            'custodioAnterior.carrera',
            'custodioNuevo.carrera',
        ]);

<<<<<<< HEAD
        $pdf = PdfHelper::oficio('actas.transferencia.pdf', compact('acta'), 'landscape');
=======
        $pdf = PdfHelper::oficio('actas.transferencia.pdf', compact('acta'));
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
        return $pdf->stream('Acta_Transferencia_' . $acta->numero_acta . '.pdf');
    }

    // ============================================================
<<<<<<< HEAD
    // EXCEL — Acta de Transferencia en formato tabular
    // ============================================================
    public function excel(ActaTransferencia $acta)
    {
        $this->authorizeActa($acta);

        $acta->load([
            'activo.categoria',
            'activo.ambiente.carrera',
            'activo.fuente',
            'origenAmbiente.carrera',
            'destinoAmbiente.carrera',
            'custodioAnterior.carrera',
            'custodioNuevo.carrera',
        ]);

        return response()->view('actas.transferencia.excel', compact('acta'));
    }
=======
    // AUTORIZACIÓN — Verifica quién puede ver/descargar un acta
    // ============================================================
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
    protected function authorizeActa(ActaTransferencia $acta): void
    {
        $user = Auth::user();

        if (! $user) {
            abort(403, 'No autenticado.');
        }

<<<<<<< HEAD
=======
        // Admin ve todo
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
        if ($user->esAdmin()) {
            return;
        }

<<<<<<< HEAD
=======
        // El custodio anterior o el nuevo pueden verla
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
        if ((int) $acta->id_custodio_anterior === (int) $user->id_usuario) {
            return;
        }
        if ((int) $acta->id_custodio_nuevo === (int) $user->id_usuario) {
            return;
        }

<<<<<<< HEAD
=======
        // Inventariador y ayudante Operan en campo: ven todos los ambientes
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
        if ($user->esOperativo()) {
            return;
        }

<<<<<<< HEAD
=======
        // Jefe de carrera, custodio y rector: solo si el ambiente del acta
        // está dentro de su alcance.
>>>>>>> 937525f96ceae3863d451daf4f8ef7e5ddfdbc3c
        $ambientesVisibles = $user->idsAmbientesVisibles();

        if (! empty($ambientesVisibles)) {
            $visibles = $ambientesVisibles
                ->map(fn ($id) => (int) $id)
                ->all();

            if (in_array((int) $acta->id_origen_ambiente, $visibles, true)
                || in_array((int) $acta->id_destino_ambiente, $visibles, true)) {
                return;
            }
        }

        abort(403, 'No autorizado para ver esta acta.');
    }
}
