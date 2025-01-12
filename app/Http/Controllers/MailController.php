<?php

namespace App\Http\Controllers;

use App\Models\Inscripcion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TandaMail;

class MailController extends Controller
{
    public function enviarTandas(Request $request)
    {
        // Obtener todos los correos de los usuarios con inscripciones
        $inscripciones = Inscripcion::with('usuario', 'evento')->get(); // Asegúrate de cargar la relación evento

        // // Enviar un correo a cada usuario inscrito
        // foreach ($inscripciones as $inscripcion) {
        //     $usuario = $inscripcion->usuario;
        //     $evento = $inscripcion->evento;

        //     // Pasar los datos del usuario y el evento al Mailable
        //     Mail::to($usuario->email)->send(new TandaMail($usuario, $evento));
        //     sleep(5); // Esperar 5 segundos entre cada envío
        // }

        
        // Enviar un correo a un usuario inscrito
        $inscripcion = $inscripciones[0];
        $usuario = $inscripcion->usuario;
        $evento = $inscripcion->evento;
        
        // Pasar los datos del usuario y el evento al Mailable
        Mail::to($usuario->email)->send(new TandaMail($usuario, $evento));

        // Redirigir de vuelta con un mensaje de éxito
        return redirect()->back()->with('success', 'Correos de la tanda enviados con éxito.');
    }
}
