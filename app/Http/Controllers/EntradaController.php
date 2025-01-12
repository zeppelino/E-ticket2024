<?php

namespace App\Http\Controllers;

use App\Models\Beneficio;
use App\Models\Categoria;
use App\Models\CategoriaTicket;
use App\Models\User;
use App\Models\Evento;
use App\Models\TipoTicket;
use App\Models\Ubicacion;
use App\Models\Entrada;
use Illuminate\Http\Request;
/* libreria DomPDF */
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use function PHPUnit\Framework\isEmpty;

class EntradaController extends Controller 

{
    /* public function verMisEntradas()
    {
    $userId = auth()->id();
    // Obtener todas las entradas del usuario con sus eventos relacionados
    $entradasUsuario = Entrada::with(['tipoTickets.evento', 'tipoTickets.evento.ubicacion', 'tipoTickets.evento.categoria'])
                              ->where('idUsuario', $userId)
                              ->get();


        return view('admin.verMisEntradas', compact('entradasUsuario'));
    } */
    public function verMisEntradas(Request $request)
    {
        $userId = auth()->id();
        $estado = $request->get('estado'); // Obtiene el estado desde la solicitud (puede ser null)
    
        // Construir la consulta base
        $query = Entrada::with(['tipoTickets.evento', 'tipoTickets.evento.ubicacion', 'tipoTickets.evento.categoria'])
                        ->where('idUsuario', $userId);
    
        // Filtrar según el estado si se especifica
        if ($estado) {
            $query->whereHas('tipoTickets.evento', function ($q) use ($estado) {
                $q->where('estadoEvento', $estado);
            });
        } else {
            // Por defecto, solo eventos disponibles
            $query->whereHas('tipoTickets.evento', function ($q) {
                $q->whereIn('estadoEvento', ['disponible','agotado']);
            });
        }
    
        // Obtener las entradas según la consulta construida
        $entradasUsuario = $query->get();
    
        return view('admin.verMisEntradas', compact('entradasUsuario'));
    }
    
    
    
    /* ==============
    ENTRADAS PDF
    ================*/
    
    public function entradaPdf($idEntrada) {
        $qrcode = base64_encode(QrCode::format('svg')->size(100)->errorCorrection('H')->color(0, 0, 0)->backgroundColor(255, 255, 255)->generate(route('entradaPDF', ['idEntrada' => $idEntrada])));

         
         $entrada = Entrada::with(['tipoTickets.evento', 'tipoTickets.evento.ubicacion', 'tipoTickets', 'tipoTickets.categoriaTicket','tipoTickets.evento.categoria', 'usuario'])
         ->where('idEntrada', $idEntrada)
         ->first();

        // Mensaje por si no encuentra el evento
        if(!$entrada){
            return redirect()->route('welcome')->with('error', 'Entrada no encontrado');    
        }

        Carbon::setLocale('es');
        
        $data = [
            'numeroEntrada' => $entrada->numeroEntrada,
            'tipoTicket' => $entrada->tipoTickets->categoriaTicket->nombreCatTicket,
            'precioTicket' => $entrada->precio,
            'logo' => '../public/assets/images/logo-con-nombre.png', // URL del logo 
            'nombreEvento' => $entrada->tipoTickets->evento->nombreEvento,
           'fechaEvento' => \Carbon\Carbon::parse($entrada->tipoTickets->evento->fechaRealizacion)->translatedFormat('d \d\e F \d\e Y'),
            'horaEvento' => \Carbon\Carbon::parse($entrada->tipoTickets->evento->fechaRealizacion)->format('H:i'),
            'lugarEvento' => $entrada->tipoTickets->evento->ubicacion->direccion,
            'ciudad' => $entrada->tipoTickets->evento->ubicacion->ciudad,
            'nombreCliente' => $entrada->usuario->name,
            'fechaCompra' => \Carbon\Carbon::parse($entrada->created_at)->translatedFormat('d \d\e F \d\e Y'),
            'qrcode' => $qrcode,
        ];
        
        $pdf = PDF::loadView('entrada.entradaPdf',$data);
        return $pdf->stream();
    }


    /* CREAR ENTRADAS NUEVAS EN EL REPROGRAMAR */
    public function crearEntrada($entrada, $idNuevoEvento)
{
       // Supongamos que el tipo de ticket tiene una categoría y buscas el equivalente en el nuevo evento
    $nuevoTipoTicket = TipoTicket::where('idCatTicket', $entrada->tipoTickets->idCatTicket)
                                 ->where('idEvento', $idNuevoEvento)
                                 ->where('cupoTotal', $entrada->tipoTickets->cupoTotal) // Comparar la cantidad de cupoTotal
                                 ->first(); // Encuentra el ticket equivalente en el nuevo evento

    if (!$nuevoTipoTicket) {
        throw new \Exception('No se pudo encontrar un tipo de ticket equivalente para el nuevo evento.');
    }

    //descrementar el cupo disponible
    $nuevoTipoTicket -> cupoDisponible --;
    $nuevoTipoTicket -> save();
 
    // Crea la nueva entrada en la base de datos con el nuevo idTipoTicket
    $entradaNueva = Entrada::create([
        'numeroEntrada' => $entrada->numeroEntrada,
        'numeroTransaccion' => $entrada->numeroTransaccion,
        'fechaCompra' => $entrada->fechaCompra,
        'idTipoTicket' => $nuevoTipoTicket->idTipoTicket, // Asigna el nuevo idTipoTicket del evento reprogramado
        'idUsuario' => $entrada->idUsuario,
        'precio' => $entrada->precio,
    ]);

    return $entradaNueva;
}

}


