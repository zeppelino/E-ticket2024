<?php

namespace App\Http\Controllers;

use App\Mail\InscripcionListaMail;
use App\Models\Evento;
use App\Models\Inscripcion;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Exception;
use Illuminate\Support\Facades\Log;

class ListaEsperaController extends Controller
{
    // Mostrar Lista de espera

    public function mostrarListaEspera() {}

    //creamos la inscripcion
   /*  public function crearInscripcion($user, $idEvento)
    {
        $data = [
            'idUsuario' => $user->id,
            'idEvento' => $idEvento,
            'fechaInscripcion' => Carbon::now(),
            //'estadoVenta' => 'confirmado', creeen confirmados primero con un correo y despues prueben con el mismo correo crear varios pendientes
            'estadoVenta' => 'pendiente',
            'estadoEnvio' => 'pendiente',
        ];
        Inscripcion::create($data);
    } */

    public function crearInscripcion($user, $idEvento)
{
    if ($user) {
        if ($user->hasRole('Cliente')) {
            // Verificar si ya existe una inscripción con estadoEnvio = pendiente
            $inscripcionExistente = Inscripcion::where('idUsuario', $user->id)
                ->where('idEvento', $idEvento)
                ->where('estadoEnvio', 'pendiente')
                ->first();

            if ($inscripcionExistente) {
                // No crear la inscripción si ya existe una con estadoEnvio = pendiente
                return response()->json([
                    'message' => 'Ya existe una inscripción pendiente para este evento.'
                ], 400);
            }

            // Crear la inscripción si no existe
            $data = [
                'idUsuario' => $user->id,
                'idEvento' => $idEvento,
                'fechaInscripcion' => Carbon::now(),
                'estadoVenta' => 'pendiente',
                'estadoEnvio' => 'pendiente',
            ];
            Inscripcion::create($data);

            return response()->json([
                'message' => 'Inscripción creada exitosamente.'
            ], 201);
        }
    }

    // Respuesta si el usuario no tiene rol de Cliente o no está autenticado
    return response()->json([
        'message' => 'No se pudo crear la inscripción. Verifique sus credenciales.'
    ], 403);
}



    /* obtener la inscripción */
    public function getInscripcion($idUsuario, $idEvento)
    {
        $inscripcion = Inscripcion::where('idUsuario', $idUsuario)
            ->where('idEvento', $idEvento)
            ->orderBy('idInscripcion', 'desc')
            ->first();

        return $inscripcion;
    }

    // Enviar Email de la lista de espera
    public function enviarMailListaEspera(Request $request)
    {

        // Validar el correo electrónico
        $validated = $request->validate([
            'email' => 'required|email',
        ]);

        // Obtener el idEvento del formulario
        $idEvento = $request->input('idEvento');
        $user = User::where('email', $request->email)->first();
        $evento = Evento::find($idEvento);

        if ($user) {

            if ($user->hasRole('Cliente')) {

                //busca si tiene una inscripcion para el evento seleccionado, si la tiene no deberia dejar inscribirse
                $inscripcion = Inscripcion::where('idUsuario', $user->id)
                    ->where('idEvento', $idEvento) // Asumiendo que $evento es el evento actual
                    ->whereIn('estadoEnvio', ['pendiente', 'enviado'])
                    ->whereNotIn('estadoVenta', ['confirmado', 'cancelado'])
                    /* ->where('estadoEnvio', 'enviado') */
                    /* ->where('estadoVenta', 'pendiente')  */
                    ->first();


                    /* BUSCA UNA INSCRIPCION ARRIBA, SI NO HAY INSCRIPCION ENVIA UN EMAIL Y DESPUES CREA LA INSCRIPCION 
                    EN CREAR INSCRIPCION LA CREA CON ESTADO PENDIENTE , se cambia a enviado en la tarea programada */
                if (!$inscripcion) {

                    //creamos la inscripcion
                    $this->crearInscripcion($user, $idEvento);

                    /* prueba enviar el email */
                    try {
                        Mail::to($user->email)->send(new InscripcionListaMail($user, $evento, $idEvento));
                        
                    } catch (Exception $e) {
                        // Manejar el error, por ejemplo, registrar un log o notificar al administrador
                        Log::error('Error al enviar correo: ' . $e->getMessage());
                    }
                    //Mail::to($user->email)->send(new InscripcionListaMail($user, $evento, $idEvento));

                    
                    session(['show_modal' => true]);

                    // Redirigir con un mensaje de éxito
                    /* return redirect()->back()->with('success', 'Te has inscripto en la lista de espera y se enviara un la pagina de compra al correo a ' . $user->email); */
                    return redirect()->route('unEvento', ['idEvento' => $idEvento])
                        ->with('success', 'Te has inscrito en la lista de espera y se enviará la página de compra al correo ' . $user->email);
                } else {
                    // Almacenar un mensaje de éxito en la sesión
                    session(['show_modal' => true]);

                    return redirect()->back()->withErrors(['email' => 'Este correo ya tiene una inscripcion pendiente, debe esperar a que su inscripcion se termine para volver a inscribirse.']);
                }
            } else {
                // Almacenar un mensaje de éxito en la sesión
                session(['show_modal' => true]);

                // Si el usuario no existe, mostrar un error
                return redirect()->back()->withErrors(['email' => 'Este correo no puede inscribirse.']);
            }
        } else {
            // Almacenar un mensaje de éxito en la sesión
            session(['show_modal' => true]);

            // Si el usuario no existe, mostrar un error
            return redirect()->back()->withErrors(['email' => 'Este correo no está registrado como usuario, debe estar registrado antes de inscribirse.']);
        }
    }

    /*
    VISTA TEMPORAL DE COMPRA
     */

    /* public function mostrarComprarEntradaTemporal(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para acceder a esta página');
        }

        $userId = $request->query('user'); // Extrae el ID del usuario de los parámetros de la URL
        if (Auth::id() != $userId) {
            Auth::logout(); // Cierra la sesión actual, si es incorrecta
            return redirect()->route('login')->with('error', 'No tienes permiso para acceder a esta página');
        }

        // Verificar que el enlace tenga una firma válida
        if (!$request->hasValidSignature()) {
            return view('tiempoExpirado');
        }

        // Obtener el evento y el usuario
        // $evento = Evento::with('tipoTickets', 'beneficios')->findOrFail($request->query('evento')); 
        $evento = Evento::with(['tipoTickets', 'beneficios' => function ($query) {
            $query->orderBy('created_at', 'desc'); // Asegúrate de que los beneficios estén ordenados por fecha
        }])->findOrFail($request->query('evento'));

        // Obtener el último beneficio
        $ultimoBeneficio = $evento->beneficios->first();

        $user = User::findOrFail($request->query('user'));

        //Verifica el estado de la inscripcion
        $inscripcion = ListaEsperaController::getInscripcion($user->id, $evento->idEvento);
        //$estadoVenta = $inscripcion -> estadoVenta;
        if ($inscripcion->estadoVenta != 'pendiente') {
            //Si el estado es "confirmado" el usuario ya adiquirio su entrada para esta inscripcion
            return view('entradaAdquirida', compact('evento', 'user'));
        }

        // Obtener los timestamps en segundos
        $expiresTimestamp = (int) $request->query('expires');
        $generadoEn = (int) $request->query('generadoEn');

        // Validar si los timestamps están bien
        if (!$expiresTimestamp || !$generadoEn) {
            return view('tiempoExpirado'); // Evita problemas si los valores no llegan
        }

        // Calcular el tiempo transcurrido desde que se generó el enlace
        $tiempoTranscurrido = now()->timestamp - $generadoEn; // Tiempo en segundos

        // Calcular el tiempo restante en segundos
        $tiempoRestante = max($expiresTimestamp - now()->timestamp, 0);


        // PARA MOSTRAR SI HAY TICKETS 
        $evento = Evento::with(['tipoTickets', 'tipoTickets.categoriaTicket', 'beneficios' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])->findOrFail($request->query('evento'));
    
        // Verificar si existe al menos un tipo de entrada con cupo disponible
        $hayDisponibilidad = $evento->tipoTickets->contains(function ($ticket) {
            return $ticket->cupoDisponible > 0;
        });

        // Retornar la vista con los datos necesarios
        return view('comprarEntradaTemporal', compact('evento', 'user', 'tiempoRestante', 'ultimoBeneficio', 'hayDisponibilidad'));
    } */
 /*    public function mostrarComprarEntradaTemporal(Request $request)
    {

        // Verificar que el enlace esté firmado y que no haya expirado
        if (!$request->hasValidSignature()) {
            return view('tiempoExpirado');
        }

        // Extraer y validar parámetros de usuario y evento
        $userId = $request->query('user');
        $eventId = $request->query('evento');


        // Obtener el evento con sus tickets y beneficios
        $evento = Evento::with(['tipoTickets.categoriaTicket', 'beneficios' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])->findOrFail($eventId);


        // Verificar si hay al menos un tipo de ticket disponible
        $hayDisponibilidad = $evento->tipoTickets->contains(fn($ticket) => $ticket->cupoDisponible > 0);
        if (!$hayDisponibilidad) {
            return redirect()->route('entradasAgotadas');
        }

        // Calcular el tiempo de expiración
        $expiresTimestamp = (int) $request->query('expires');
        $generadoEn = (int) $request->query('generadoEn');

        // Validar los timestamps
        if (!$expiresTimestamp || !$generadoEn) {

            // Redirigir a la vista de tiempo expirado
            return view('tiempoExpirado');

            // return $this->tiempoExpirado($request, $userId, $eventId); // Redirige si los valores no son válidos
        }

        // Obtener el tiempo actual en segundos
        $currentTime = now()->timestamp;

        // Verificar si el tiempo ha expirado
        if ($currentTime > $expiresTimestamp) {
            return view('tiempoExpirado');
        }

        // Verificar autenticación
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para acceder a esta página');
        }

        // Esto es por si ingresa la cuenta de otra persona, lo desloguea y redirecciona al login
        //if (Auth::id() != $userId) {
        //    Auth::logout();
        //    return redirect()->route('login')->with('error', 'No tienes permiso para acceder a esta página');
        //} 

        // Obtener el usuario y su inscripción en la lista de espera
        $user = User::findOrFail($userId);
        $inscripcion = ListaEsperaController::getInscripcion($userId, $evento->idEvento);

        // Si la inscripción no está pendiente, redirigir a la página de entrada adquirida
        if ($inscripcion->estadoVenta != 'pendiente') {
            return view('entradaAdquirida', compact('evento', 'user'));
        }


        // Calcular el tiempo restante y el tiempo transcurrido
        $tiempoRestante = max($expiresTimestamp - now()->timestamp, 0);
        $tiempoTranscurrido = now()->timestamp - $generadoEn;

        // Retornar la vista de compra con los datos necesarios si hay disponibilidad y el tiempo es válido
        return view('comprarEntradaTemporal', compact('evento', 'user', 'tiempoRestante'));
    } */

    public function mostrarComprarEntradaTemporal(Request $request)
{
    // Verificar la firma manualmente sin el middleware `signed`
    if (!$request->hasValidSignature()) {
        return view('tiempoExpirado');
    }

    // Extraer los parámetros de usuario y evento
    $userId = $request->query('user');
    $eventId = $request->query('evento');

    // Verificar si la marca de tiempo de expiración ha pasado
    $expiresTimestamp = $request->query('expires');
    if (now()->timestamp > $expiresTimestamp) {
        // Si ha expirado, mostrar la vista de tiempo expirado
        return view('tiempoExpirado');
    }

    // Continuar con el flujo normal si la firma es válida y no ha expirado
    $evento = Evento::with(['tipoTickets.categoriaTicket', 'beneficios' => function ($query) {
        $query->orderBy('created_at', 'desc');
    }])->findOrFail($eventId);

    // Obtener el último beneficio
    $ultimoBeneficio = $evento->beneficios->first();

    // Verificar la disponibilidad de tickets
    $hayDisponibilidad = $evento->tipoTickets->contains(fn($ticket) => $ticket->cupoDisponible > 0);
    if (!$hayDisponibilidad) {
        return redirect()->route('entradasAgotadas');
    }

    // Verificar autenticación
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Debes iniciar sesión para acceder a esta página');
    }
    
    $userId = $request->query('user'); // Extrae el ID del usuario de los parámetros de la URL
        if (Auth::id() != $userId) {
            Auth::logout(); // Cierra la sesión actual, si es incorrecta
            return redirect()->route('login')->with('error', 'No tienes permiso para acceder a esta página');
        }

    // Obtener el usuario y su inscripción en la lista de espera
    $user = User::findOrFail($userId);
    $inscripcion = ListaEsperaController::getInscripcion($userId, $evento->idEvento);

    // Si la inscripción no está pendiente, redirigir a la página de entrada adquirida
    if ($inscripcion->estadoVenta != 'pendiente') {
        return view('entradaAdquirida', compact('evento', 'user'));
    }

    // Calcular el tiempo restante
    $tiempoRestante = max($expiresTimestamp - now()->timestamp, 0);

    // Retornar la vista de compra con los datos necesarios
    return view('comprarEntradaTemporal', compact('evento', 'user', 'tiempoRestante', 'ultimoBeneficio'));
}
    // FUNCION PARA SEPARAR LA LOGICA, NO FUNCIONA POR MAS QUE SE LE PASEN PARAMETROS
    public function tiempoExpirado(Request $request)
    {
        $userId = $request->query('user');
        $eventoId = $request->query('evento');

        $inscripcion = ListaEsperaController::getInscripcion($userId, $eventoId);

        if ($inscripcion && $inscripcion->estadoVenta == 'pendiente') {
            $inscripcion->estadoVenta = 'cancelado';
            $inscripcion->save();
        }

        // Redirigir a la vista de tiempo expirado
        return view('tiempoExpirado');
    }
}
