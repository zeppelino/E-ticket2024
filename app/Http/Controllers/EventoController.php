<?php

namespace App\Http\Controllers;

use App\Mail\EventoCanceladoMail;
use App\Mail\SuspenderEventoMail;
use App\Models\Beneficio;
use App\Models\Categoria;
use App\Models\CategoriaTicket;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Evento;
use App\Models\Tanda;
use App\Models\TipoTicket;
use App\Models\Ubicacion;
use App\Models\Entrada;
use App\Mail\EntradaMail;
use App\Http\Controllers\EntradaController;
use Illuminate\Http\Request;
/* libreria DomPDF */
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\Inscripcion;
use App\Notifications\EventCanceladoNotification;
use Illuminate\Support\Facades\Mail;
use Iluminar\Http\JsonResponse;
use App\Notifications\EventCreatedNotification;
use App\Notifications\EventSuspendidoNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;



class EventoController extends Controller
{
    /*=========================
    CREAR EVENTO
    ==========================*/

    public function crearEvento()
    {
        $fechaActual = now()->format('Y-m-d');
        $fechaHoraActual = now()->format('Y-m-d\TH:i');
        $categorias = Categoria::all();
        $catTickets = CategoriaTicket::all();
        $catTicketsCantidad = $catTickets->count();
        $paises = DB::table('countries')->get();

        return view('admin.crearEvento', compact('paises', 'categorias', 'catTickets', 'catTicketsCantidad', 'fechaActual', 'fechaHoraActual'));
    }

    /*=========================
    REPROGRAMAR EVENTO
    ==========================*/

    public function reprogramarEvento($idEventoSuspendido)
    {
        $eventoSuspendido = Evento::find($idEventoSuspendido);
        $fechaActual = now()->format('Y-m-d');
        $fechaHoraActual = now()->format('Y-m-d\TH:i');
        $catTickets = CategoriaTicket::all();
        $catTicketsCantidad = $catTickets->count();

        return view('admin.reprogramarEvento', compact('eventoSuspendido', 'catTickets', 'catTicketsCantidad', 'fechaActual', 'fechaHoraActual'));
    }

    /*=========================
    BUSCAR PROVINCIA
    ==========================*/

    public function buscarProvincia($paisId)
    {
        $provincias = DB::table('states')->where('country_id', $paisId)->get();

        return response()->json([
            'provincias' => $provincias,
        ]);
    }

    /*=========================
    BUSCAR LOCALIDAD
    ==========================*/

    public function buscarLocalidad($provinciaId)
    {
        $localidades = DB::table('cities')->where('state_id', $provinciaId)->get();

        return response()->json([
            'localidades' => $localidades,
        ]);
    }

    /*===============================
    Entradas del evento suspendido
    ===============================*/

    public function obtenerEntradasVendidas($idEventoSuspendido)
    {
        // Obtener el evento suspendido por su id
        $eventoSuspendido = Evento::with('tipoTickets.entradas')
            ->where('idEvento', $idEventoSuspendido)
            ->first();


        // Recorrer los tipos de tickets y sus entradas asociadas
        $entradasVendidas = [];
        foreach ($eventoSuspendido->tipoTickets as $tipoTicket) {
            foreach ($tipoTicket->entradas as $entrada) {
                $entradasVendidas[] = $entrada;
            }
        }
        // Retornar la lista de entradas vendidas
        return ($entradasVendidas);
    }

    /*============================
    GUARDAR EVENTO REPROGRAMADO
    ============================*/

    public function guardarEventoReprogramado(Request $request)
    {
        $resultadoGuardarEvento = $this->guardarEvento($request);

        if (!is_null($resultadoGuardarEvento)) {
            $entradas = $this->obtenerEntradasVendidas($request->idEventoSuspendido);

            $entradaController = new EntradaController();
            $entradasNuevas = [];


            foreach ($entradas as $entrada) {
                $nuevaEntrada = $entradaController->crearEntrada($entrada, $resultadoGuardarEvento); // Pasa el ID del nuevo evento
                $entradasNuevas[] = $nuevaEntrada;
            }

            foreach ($entradasNuevas as $entrada) {
                $usuario = $entrada->usuario; // Asegúrate de tener la relación con el usuario
                Mail::to($usuario->email)->send(new EntradaMail($entrada));
            }
            $evento = Evento::findOrFail($request->idEventoSuspendido);
            $evento->estadoEvento = 'reprogramado';

            // Guardar los cambios
            $eventoGuardado = $evento->save();

            return redirect()->route('admin.eventos')->with('success', 'Evento reprogramado correctamente.');
        }
    }

    /*=========================
    GUARDAR EVENTO
    ==========================*/

    public function guardarEvento(Request $request)
    {
        //dd($request->all());
        if (($request-> input('cupoDisponible')) !== null) {
            $cupoDisponible = $request -> input('cupoDisponible');
        } else {
            $cupoDisponible = 1;
        }

        error_log('cupoDisponible=' . $cupoDisponible);
        
        if ($cupoDisponible != 0) {
            // El evento no esta agotado
            $request->validate([
                'eventoNombre' => 'required|string|max:255', // Nombre del evento
                'eventoCategoria' => 'required|string|max:255', // Categoría del evento
                'eventEnableDate' => 'required|date', // Fecha de publicacion del evento
                'eventEnableTime' => 'required|date_format:H:i', // Hora de publicacion  tación del evento
                'eventStartDate' => 'required|date|after:eventEnableDate', // Fecha de realizacion del evento
                'eventStartTime' => 'required|date_format:H:i', // Hora de realizacion del evento
                'pais' => 'required|string|max:255', // País
                'provincia' => 'required|string|max:255', // Provincia
                'localidad' => 'required|string|max:255', // Localidad
                'direccionEvento' => 'required|string|max:255', // Dirección del evento
                'eventDescription' => 'required|string|max:1000', // Descripción del evento
    
                // Para arrays dinámicos: ticketQuantity, ticketType, ticketPrice, ticketDescription
                'ticketType' => 'required|array',
                'ticketType.*' => 'string|max:255',
    
                'ticketPrice' => 'required|array',
                'ticketPrice.*' => 'numeric|min:0',
    
                'ticketQuantity' => 'required|array',
                'ticketQuantity.*' => 'integer|min:1',
    
                'ticketDescription' => 'required|array',
                'ticketDescription.*' => 'string|max:1000',
    
                // Validación para arrays dinámicos de tanda
                'nombre_tanda' => 'required|array', // Nombre de la tanda como array
                'nombre_tanda.*' => 'string|max:255', // Cada nombre de tanda debe ser una cadena de texto
    
                'fecha_inicio_tanda' => 'required|array', // Fechas de inicio de tanda como array
                'fecha_inicio_tanda.*' => 'date', // Cada fecha de inicio debe ser una fecha válida
    
                'fecha_fin_tanda' => 'required|array', // Fechas de fin de tanda como array
                'fecha_fin_tanda.*' => 'date', // Cada fecha de fin debe ser igual o posterior a la fecha de inicio correspondiente
    
                'cupo_tanda' => 'required|array', // Cupo de tanda como array
                'cupo_tanda.*' => 'integer|min:1', // Cada cupo debe ser un entero positivo
    
                'eventoImagen' => 'file|image|mimes:jpeg,png,jpg' // Imagen del evento, máximo 2MB seria: (|max:2048) y formatos permitidos
            ], [
                //mensajes personalizados
                'eventoNombre.required' => 'El nombre del evento es obligatorio.',
                'eventoNombre.max' => 'El nombre del evento no debe exceder los 255 caracteres.',
                'eventoCategoria.required' => 'La categoría del evento es obligatoria.',
                /* 'fecha_fin_tanda.*.after_or_equal' => 'La fecha de fin de la tanda no puede ser anterior a la fecha de inicio de la tanda'  */
            ]);
        } else {
            // Evento agotado
            $request->validate([
                'eventoNombre' => 'required|string|max:255', // Nombre del evento
                'eventoCategoria' => 'required|string|max:255', // Categoría del evento
                'eventEnableDate' => 'required|date', // Fecha de publicacion del evento
                'eventEnableTime' => 'required|date_format:H:i', // Hora de publicacion  tación del evento
                'eventStartDate' => 'required|date|after:eventEnableDate', // Fecha de realizacion del evento
                'eventStartTime' => 'required|date_format:H:i', // Hora de realizacion del evento
                'pais' => 'required|string|max:255', // País
                'provincia' => 'required|string|max:255', // Provincia
                'localidad' => 'required|string|max:255', // Localidad
                'direccionEvento' => 'required|string|max:255', // Dirección del evento
                'eventDescription' => 'required|string|max:1000', // Descripción del evento
    
                // Para arrays dinámicos: ticketQuantity, ticketType, ticketPrice, ticketDescription
                'ticketType' => 'required|array',
                'ticketType.*' => 'string|max:255',
    
                'ticketPrice' => 'required|array',
                'ticketPrice.*' => 'numeric|min:0',
    
                'ticketQuantity' => 'required|array',
                'ticketQuantity.*' => 'integer|min:1',
    
                'ticketDescription' => 'required|array',
                'ticketDescription.*' => 'string|max:1000',
    
                'eventoImagen' => 'file|image|mimes:jpeg,png,jpg' // Imagen del evento, máximo 2MB seria: (|max:2048) y formatos permitidos
            ], [
                //mensajes personalizados
                'eventoNombre.required' => 'El nombre del evento es obligatorio.',
                'eventoNombre.max' => 'El nombre del evento no debe exceder los 255 caracteres.',
                'eventoCategoria.required' => 'La categoría del evento es obligatoria.',
                /* 'fecha_fin_tanda.*.after_or_equal' => 'La fecha de fin de la tanda no puede ser anterior a la fecha de inicio de la tanda'  */
            ]);
        }


        /*===========
        IMAGEN
        ============*/

        $save_url = "";
    if (is_null($request->idEventoSuspendido) || $request->file('eventoImagen') ){
        //guarda imagen en servidor
        if ($request->file('eventoImagen')) {
            $image = $request->file('eventoImagen');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(300, 300)->save(public_path('frontend/img/eventos/' . $name_gen));
            $save_url = 'frontend/img/eventos/' . $name_gen;
        }
        else
        { $save_url = 'frontend/img/eventos/imagenDefecto/porDefectoEvento.jpg';}}
         else {
            $eventoSus = Evento::find($request->idEventoSuspendido);
             $save_url = $eventoSus->urlImagen;
             
        }

        /*===========
        UBICACION
        ============*/

        if (is_null($request->idEventoSuspendido)) {
            //consulta de datos para tabla  Ubicacion
            $nombrePais = DB::table('countries')->where('id', $request->pais)->value('name');
            $nombreProvincia = DB::table('states')->where('id', $request->provincia)->value('name');
            $nombreCiudad = DB::table('cities')->where('id', $request->localidad)->value('name');

            //guarda Ubicacion y obtiene id generado
            $idUbicacion = Ubicacion::insertGetId([
                'país' => $nombrePais,
                'provincia' => $nombreProvincia,
                'ciudad' => $nombreCiudad,
                'direccion' => $request->direccionEvento,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        } else {

            //guarda Ubicacion y obtiene id generado
            $idUbicacion = Ubicacion::insertGetId([
                'país' => $request->pais,
                'provincia' => $request->provincia,
                'ciudad' => $request->localidad,
                'direccion' => $request->direccionEvento,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        /*===========
        EVENTO
        ============*/

        //combinar fecha hora Realizacion
        $fechaInicio = $request->eventStartDate;
        $horaInicio = $request->eventStartTime;
        $fechaRealizacion = Carbon::createFromFormat('Y-m-d H:i', $fechaInicio . ' ' . $horaInicio);

        //combinar fecha hora Habilitacion
        $fechaHabilitacion = $request->eventEnableDate;
        $horaHabilitacion = $request->eventEnableTime;
        $fechaHabilitacion = Carbon::createFromFormat('Y-m-d H:i', $fechaHabilitacion . ' ' . $horaHabilitacion);

        $nombreEvento = $request->eventoNombre;

        //guarda evento y obtiene id generado
        $idEvento = Evento::insertGetId([
            'nombreEvento' => $nombreEvento,
            'descripcionEvento' => $request->eventDescription,
            'urlImagen' => $save_url,
            'fechaHabilitacion' => $fechaHabilitacion,
            'fechaRealizacion' => $fechaRealizacion,
            'estadoEvento' => 'pendiente',
            'idUbicacion' => $idUbicacion,
            'idCategoriaEvento' => $request->eventoCategoria,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        /*===========
        TIPO TICKET
        ============*/

        // Obtener los datos de ticket del formulario
        $ticketTypes = $request->input('ticketType');
        $ticketPrices = $request->input('ticketPrice');
        $ticketQuantities = $request->input('ticketQuantity');
        $ticketDescriptions = $request->input('ticketDescription');
        // Crear un array para almacenar los registros
        $ticketsToInsert = [];

        // Iterar sobre los arrays y crear un nuevo registro para cada ticket
        for ($i = 0; $i < count($ticketTypes); $i++) {
            $ticketsToInsert[] = [
                'idEvento' => $idEvento,
                'descripcionTipoTicket' => $ticketDescriptions[$i],
                'precioTicket' => $ticketPrices[$i],
                'cupoTotal' => $ticketQuantities[$i],
                'cupoDisponible' => $ticketQuantities[$i],
                'idCatTicket' => $ticketTypes[$i],
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        //guarda tipo tickets
        foreach ($ticketsToInsert as $ticketData) {
            TipoTicket::create($ticketData);
        }

        /*===========
        TANDAS
        ============*/

        // Obtener los datos de tanda del formulario
        if ($cupoDisponible != 0) {
            // El evento no esta agotado
            $nombreTanda = $request->input('nombre_tanda');
            $fechaInicioTanda = $request->input('fecha_inicio_tanda');
            $fechaFinTanda = $request->input('fecha_fin_tanda');
            $cupoTanda = $request->input('cupo_tanda');
    
            // Crear un array para almacenar los registros
            $tandasToInsert = [];
    
            // Iterar sobre los arrays y crear un nuevo registro para cada ticket
            for ($i = 0; $i < count($nombreTanda); $i++) {
                $tandasToInsert[] = [
                    'idEvento' => $idEvento,
                    'nombreTanda' => $nombreTanda[$i],
                    'fechaInicio' => $fechaInicioTanda[$i],
                    'fechaFin' => $fechaFinTanda[$i],
                    'cupos' => $cupoTanda[$i],
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
        } else {
            // Creo tanda vacia para evento agotado
            $tandasToInsert[] = [
                'idEvento' => $idEvento,
                'nombreTanda' => 'Tanda 1',
                'fechaInicio' => $fechaHabilitacion,
                'fechaFin' => $fechaRealizacion,
                'cupos' => '0',
                'created_at' => now(),
                'updated_at' => now()
            ];
        }


        //guarda tandas
        foreach ($tandasToInsert as $tandaData) {
            Tanda::create($tandaData);
        }

        if (is_null($request->idEventoSuspendido)) {
            //notificacion en campana del dashboard
            $adminUsers = User::role('Admin')->get();
            Notification::send($adminUsers, new EventCreatedNotification($nombreEvento, $idEvento));
            //return redirect()->route('admin.eventos')->with('success', 'Evento guardado correctamente.');
            return response()->json(['message' => 'Evento guardado correctamente.'], 200);
        }

        return ($idEvento);
    } // fin guardar evento

    /*==========================
    MOSTRAR EVENTO ESPECIFICO
    ==========================*/

    public function show($idEvento)
    {

        // Buscar el evento con el idEvento y la relacion de ubicacion y tipoTickets
        $evento = Evento::with(['ubicacion', 'tipoTickets.categoriaTicket', 'categoria'])
            ->where('idEvento', $idEvento)
            ->findOrFail($idEvento);

        // Mensaje por si no encuentra el evento
        if (!$evento) {
            return redirect()->route('welcome')->with('error', 'Evento no encontrado');
        }

        // sumo la cantidad de tickets
        $entradasDisponibles = $evento->tipoTickets->sum('cupoDisponible') > 0;

        return view('unEvento', compact('evento', 'entradasDisponibles'));
    }

    /*==============================
    FUNCIONES ---- TABLA EVENTOS 
    ==============================*/

    // Listar eventos
    public function listarEventos()
    {

        $eventos = Evento::with(['ubicacion', 'categoria', 'tipoTickets.categoriaTicket'])->orderby('fechaRealizacion', 'asc')->get();

        return view('admin.eventos', compact('eventos'));
    }
    
    //cambiar estado eventos
    public function cambiarEstadoEvento(Request $request, $idEvento)
    {
        // Validar el estado del evento
        $request->validate([
            'estadoEvento' => 'required|string|in:pendiente,disponible,suspendido,cancelado,terminado',
        ]);


        // Buscar el evento por su ID
        $evento = Evento::find($idEvento);

        if (!$evento) {
            return response()->json(['message' => 'Evento no encontrado'], 404);
        }

        // Actualizar el estado del evento
        $evento->estadoEvento = $request->input('estadoEvento');

        if($evento->estadoEvento === 'disponible'){
            // Obtener el total de tickets disponibles para el evento
            $totalTicketsDisponibles = TipoTicket::where('idEvento', $evento->idEvento)
            ->sum('cupoDisponible');
            if($totalTicketsDisponibles === 0 ){
                $evento->estadoEvento = 'agotado';
            }
        }

        $evento->save();

        // se obtienen id del o los usuarios administradores para notificar
        $adminUsers = User::role('Admin')->get();

        // Enviar correo cuando cambia de estado a Cancelado o Suspendido
        if ($request->input('estadoEvento') === 'cancelado') {

            // Enviar notifiacion para campana en cuenta del admin
            Notification::send($adminUsers, new EventCanceladoNotification($evento->nombreEvento, $idEvento));
            
            // Obtener las inscripciones relacionadas al evento
            $inscripciones = Inscripcion::with('usuario')->where('idEvento', $idEvento)->get();
    
            foreach ($inscripciones as $inscripcion) {
                try {
                    $nroTransaccion = $this->generarNumeroTransaccion(); // genera numero random para la transaccion
                    Mail::to($inscripcion->usuario->email)->send(new EventoCanceladoMail($inscripcion->usuario, $evento, $nroTransaccion));
                } catch (\Exception $e) {
                    // Manejo general de cualquier otra excepción
                    Log::error('Error general al enviar correo: ' . $e->getMessage());
                }
            }

        } else if ($request->input('estadoEvento') === 'suspendido') {

            // Enviar notifiacion para campana en cuenta del admin
            Notification::send($adminUsers, new EventSuspendidoNotification($evento->nombreEvento, $idEvento));

            $inscripciones = Inscripcion::with('usuario')->where('idEvento', $idEvento)->get();
            foreach ($inscripciones as $inscripcion) {
                try {
                    Mail::to($inscripcion->usuario->email)->send(new SuspenderEventoMail($inscripcion->usuario, $evento));
                } catch (\Exception $e) {
                    // Manejo general de cualquier otra excepción
                    Log::error('Error general al enviar correo: ' . $e->getMessage());
                }
            }
        }

        // Devolver una respuesta JSON para confirmar el éxito
        /*  return response()->json(['message' => 'Estado del evento actualizado correctamente']); */
        // Retornar respuesta JSON con el estado actualizado
        return response()->json([
            'message' => 'Estado del evento actualizado correctamente',
            'nuevoEstado' => $evento->estadoEvento, // Incluir el nuevo estado
        ]);
    }

    //cambiar estado en fila de la tabla al actualizar estado
/*     public function actualizarFila($idEvento)
    {
        // Buscar el evento por ID
        $evento = Evento::find($idEvento);

        if (!$evento) {
            return response()->json(['error' => 'Evento no encontrado.'], 404);
        }

        // Retornar el estado actual del evento
        return response()->json([
            'nuevoEstado' => $evento->estadoEvento
        ]);
    } */

    // Agregar beneficio
    public function getBeneficio($idEvento)
    {
        $beneficio = Beneficio::where('idEvento', $idEvento)->first();
        /*   return response()->json(['beneficio' => $beneficio]); */


        // Buscar el evento y cargar las tandas relacionadas
        $evento = Evento::with('tandas')->find($idEvento);

        // Obtener la fecha de habilitación de la tanda (ejemplo: asumiendo que la primera tanda es la que te interesa)
        $fechaHabilitacionTanda = $evento->tandas->first()->fechaInicio ?? null;

        // Retornar la respuesta en JSON
        return response()->json([
            'beneficio' => $beneficio,
            'fechaHabilitacionTanda' => $fechaHabilitacionTanda,
            'fechaRealizacion' => $evento->fechaRealizacion,
        ]);
    }

    // Guardar beneficio
    public function saveBeneficio(Request $request, $idEvento)
    {

        $request->validate([
            'fechaInicioBeneficio' => 'required|date|after_or_equal:today',
            'fechaFinBeneficio' => 'required|date|after_or_equal:fechaDesde',
        ]);

        $beneficio = Beneficio::updateOrCreate(
            ['idEvento' => $idEvento],
            [
                'fechaInicioBeneficio' => $request->fechaInicioBeneficio,
                'fechaFinBeneficio' => $request->fechaFinBeneficio,
                'porcentaje' => $request->porcentaje
            ]
        );

        return response()->json(['success' => true]);
    }

    // Eliminar beneficio
    public function deleteBeneficio($idEvento)
    {
        Beneficio::where('idEvento', $idEvento)->delete();
        return response()->json(['success' => true]);
    }

    /*====================
    BOTON DE VER MAS
    ====================*/

    public function mostrarDetalle($id)
    {
        $evento = Evento::with(['ubicacion', 'categoria', 'tandas', 'tipoTickets', 'beneficios'])->findOrFail($id);
        return view('admin.detalleEvento', compact('evento'));
    }

    /*==================================
        EDITAR / MODIFICAR EVENTO   
    ==================================*/

    public function update(Request $request, $id)
    {
        // Obtener el evento y su ubicación
        $evento = Evento::findOrFail($id);
        $ubicacion = $evento->ubicacion;

        // Actualización de la ubicación (ya manejada en tu código)
        if ($request->filled('pais')) {
            $nombrePais = DB::table('countries')->where('id', $request->pais)->value('name');
            $ubicacion->país = $nombrePais ?: $ubicacion->país;
        }
        if ($request->filled('provincia')) {
            $nombreProvincia = DB::table('states')->where('id', $request->provincia)->value('name');
            $ubicacion->provincia = $nombreProvincia ?: $ubicacion->provincia;
        }
        if ($request->filled('localidad')) {
            $nombreCiudad = DB::table('cities')->where('id', $request->localidad)->value('name');
            $ubicacion->ciudad = $nombreCiudad ?: $ubicacion->ciudad;
        }
        $ubicacion->direccion = $request->input('direccionEvento', $ubicacion->direccion);

        // Actualizar otros campos del evento
        $evento->nombreEvento = $request->input('nombreEvento', $evento->nombreEvento);
        $evento->descripcionEvento = $request->input('descripcionEvento', $evento->descripcionEvento);
        $evento->idCategoriaEvento = $request->input('eventoCategoria', $evento->idCategoriaEvento);

        // Manejar la imagen del evento
        $save_url = "";

        // Manejar la imagen del evento
        if ($request->file('eventoImagen')) {
            $image = $request->file('eventoImagen');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(300, 300)->save(public_path('frontend/img/eventos/' . $name_gen));
            $evento->urlImagen = 'frontend/img/eventos/' . $name_gen; // Actualiza la propiedad de la imagen del evento
        } else {
            // Mantener la imagen existente
            $evento->urlImagen = $evento->urlImagen; // O simplemente no hacer nada aquí
        }


        // Guardar los cambios en el evento y la ubicación
        $evento->save();
        $ubicacion->save();

        return redirect()->route('admin.eventos')->with('success', 'Evento actualizado correctamente.');
    }

    //editar evento
    public function editar($id)
    {
        $evento = Evento::findOrFail($id);
        $categorias = Categoria::all(); // Asegúrate de que el modelo Categoria esté importado
        $paises = DB::table('countries')->get(); // Obtener todos los países
        $provincias = DB::table('states')->where('country_id', $evento->pais_id)->get(); // Obtener provincias del país del evento
        $localidades = DB::table('cities')->where('state_id', $evento->provincia_id)->get(); // Obtener localidades de la provincia del evento

        return view('admin.editarEvento', compact('evento', 'categorias', 'paises', 'provincias', 'localidades'));
    }

    public function buscarEventosClientes(Request $request)
    {
        $titulo = 'Resultado de la búsqueda';

        try {
            $query = $request->input('query');
            $categoria = $request->input('categoria');

            // Filtrar eventos según el criterio de búsqueda
            $eventos = Evento::where(function ($q) use ($query, $categoria) {
                if ($query) {
                    $q->where('nombreEvento', 'like', '%' . $query . '%');
                }
                if ($categoria && $categoria != 0) {
                    $q->where('idCategoriaEvento', $categoria);
                }
            })->with(['categoria', 'ubicacion'])->get(); // Asegúrate de incluir relaciones necesarias

            // Verificar si hay resultados
            if ($eventos->isEmpty()) {
                return response()->json(['message' => 'No se encontraron eventos.'], 404);
            }

            // Renderizar la vista de resultados parciales
            $html = view('partials.eventos_resultadosCliente', ['eventos' => $eventos])->render();

            return response()->json(['html' => $html, 'titulo' => $titulo], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Ocurrió un error al buscar eventos.'], 500);
        }
    }

    /*====================
        MISCELANEOS 
    ====================*/
    function generarNumeroTransaccion()
    {
        $numeroTransaccion = '';
        for ($i = 0; $i < 19; $i++) {
            $numeroTransaccion .= mt_rand(0, 9);
        }
        return $numeroTransaccion;
    }
}
