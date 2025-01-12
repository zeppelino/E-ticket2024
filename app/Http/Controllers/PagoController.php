<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Evento;
use App\Models\TipoTicket;
use App\Models\CategoriaTicket;
use App\Models\User;
use App\Http\Controllers\ListaEsperaController;
use Illuminate\Support\Facades\URL;

use App\Mail\EntradaMail;
use App\Models\Beneficio;
use App\Models\Entrada;
use Illuminate\Support\Facades\Mail;

use Faker\Factory as Faker;
use App\Notifications\EntradaCompraNotification;
use Illuminate\Support\Facades\Notification;


class PagoController extends Controller
{

    public function mostrarPasarela(Request $request)
    {      
        // Recibir datos del evento, tipoTicket y usuario desde la URL
        $evento = Evento::findOrFail($request->input('evento')); //Al ser el metodo POST se utiliza input()
        $tipoTicket = TipoTicket::findOrFail($request->input('tipoTicket'));
        $user = User::findOrFail($request->input('usuario'));

        // Recuperar el enlace temporal
        $enlaceCompra = $request->input('enlaceCompra');

        $expires = (int) $request->input('expires');
        if ($expires <= now()->timestamp) {
            return view('tiempoExpirado');
        }

    // Verificar si hay un solo tipo de ticket y es gratuito
    if ($tipoTicket->categoriaTicket->nombreCatTicket == 'Gratis') {

        $request->merge([
            'evento' => $evento->idEvento,
            'tipoTicket' => $tipoTicket->idTipoTicket,
            'usuario' => $user->id,
            'gratuito' => 1
        ]);

        // Llama a procesarPago
        return $this->procesarPago($request);
    }
        
        // Pasar los datos a la vista
        return view('pasarelaPago', compact('evento', 'tipoTicket', 'user', 'enlaceCompra'));
    }

    public function procesarPago(Request $request)
    {   
        $gratuito = $request->input('gratuito');
        if ($gratuito == 1) {
            $compraExitosa = True;
        } else {
            //Simulacion la confirmación de pago
            $compraExitosa = (bool)random_int(0, 1);
        }
        
        if ($compraExitosa) {

            // Generar un número de transacción ficticio
            $faker = Faker::create();
            $numeroTransaccion = $faker->bothify('TRX###???');

            // Obtener evento, tipoticket y usuario que provienen de la vista de Pago
            $evento = Evento::findOrFail($request->input('evento'));

            //buscar ticket
            $tipoTicket = TipoTicket::where('idEvento',$request->input('evento'))
                                    ->where('idTipoTicket',$request->input('tipoTicket'))
                                    ->first();

             //Buscar categoria del ticket
            $categoriaTicket = CategoriaTicket::where('idCatTicket',$tipoTicket -> idCatTicket)
                                    ->first();

            // Buscar usuario
            $user = User::findOrFail($request->input('usuario'));
            
            // Verificar el estado de la inscripcion
            $listaEspera = new ListaEsperaController;
            $inscripcion = $listaEspera -> getInscripcion($user -> id, $evento -> idEvento);
            if ($inscripcion -> estadoVenta == 'confirmado') {
                //El usuario ya adiquirio su entrada para esta inscripcion
                return view('entradaAdquirida', compact('evento', 'user'));
            } else {
                //Cambiar el estado de la inscripcion
                $inscripcion -> estadoVenta = 'confirmado';
                $inscripcion -> save();
            }
            
            // Restar un cupo al tipo de ticket al evento
            $tipoTicket -> cupoDisponible --;
            $tipoTicket -> save();

            // Obtener el total de tickets disponibles para el evento
            $totalTicketsDisponibles = TipoTicket::where('idEvento', $request->input('evento'))
            ->sum('cupoDisponible');
        
            //cambiar de estado evento a agotado
            if($totalTicketsDisponibles === 0){
                $evento -> estadoEvento = 'agotado';
                $evento -> save();
            }
            // GENERAR EL PRECIO CON DESCUENTO

            $beneficio = Beneficio::where('idEvento', $request->input('evento'))->first();

            if($beneficio){
                    $precio = $tipoTicket->precioTicket - ($tipoTicket->precioTicket * $beneficio->porcentaje)/100;
            }else{
                $precio = $tipoTicket->precioTicket;
            }

            //Creacion de la entrada
            $entrada = $this->crearEntrada($numeroTransaccion, $user -> id, $precio, $tipoTicket);

            // Enviar mail con entrada al usuario
            Mail::to($user->email)->send(new EntradaMail($entrada));

            // Enviar notifiacion para campana en cuenta del cliente
            Notification::send($user, new EntradaCompraNotification($evento->nombreEvento, $evento->idEvento));
            
            // Redirigir a la página de éxito con los datos necesarios
            return view('resultadoCompra', compact('numeroTransaccion', 'evento', 'tipoTicket','categoriaTicket', 'user'));

        } else {
            // Se recupera el enlace temporal desde los parámetros de la solicitud
            $enlaceCompra = $request->input('enlaceCompra');

            return view('resultadoCompra', compact('enlaceCompra'));
        }
    }


    public function crearEntrada($numeroTransaccion, $idUsuario, $precio, $tipoTicket)
    {
        // Obtener el nombre del evento
        $evento = $tipoTicket->evento;  // Asegúrate de que $tipoTicket tenga la relación con Evento configurada
        $nombreEvento = $evento->nombreEvento;
    
        // Obtener las iniciales del evento
        $iniciales = '';
        $palabras = explode(' ', $nombreEvento);
        if (count($palabras) > 1) {
            $iniciales = strtoupper(substr($palabras[0], 0, 1) . substr($palabras[1], 0, 1));
        } else {
            $iniciales = strtoupper(substr($nombreEvento, 0, 2));
        }
    
        // Buscar la última entrada para este tipo de ticket y el evento
        $ultimaEntrada = Entrada::whereHas('tipoTickets', function ($query) use ($evento) {
            $query->where('idEvento', $evento->idEvento);
        })
        ->orderBy('numeroEntrada', 'desc')
        ->first();
    
    
        // Determinar el número secuencial
        $secuencial = 1;
        if ($ultimaEntrada) {
            // Extraer el número actual y sumarle uno
            $numeroActual = (int)substr($ultimaEntrada->numeroEntrada, strlen($iniciales));
            $secuencial = $numeroActual + 1;
        }
    
        // Formatear el número de entrada con las iniciales y el número
        $numeroEntrada = sprintf('%s%04d', $iniciales, $secuencial);
    
        // Crear y devolver la nueva entrada
        return Entrada::create([
            'numeroEntrada' => $numeroEntrada,
            'numeroTransaccion' => $numeroTransaccion,
            'fechaCompra' => now(),
            'idUsuario' => $idUsuario,
            'idTipoTicket' => $tipoTicket->idTipoTicket,
            'precio' => $precio,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
    

}
