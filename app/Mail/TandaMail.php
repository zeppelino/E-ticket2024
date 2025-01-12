<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class TandaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $usuario;
    public $evento;

    public function __construct($usuario, $evento)
    {
        $this->usuario = $usuario;
        $this->evento = $evento;
    }

    public function build()
    {
        $tiempoVencimiento = 10; // En minutos 

        // Generar un enlace temporal firmado
        $enlaceCompra = URL::temporarySignedRoute(
            'comprarEntradaTemporal',
            now()->addMinutes($tiempoVencimiento),
            [
                'evento' => $this->evento->idEvento, 
                'user' => $this->usuario->id, 
                'generadoEn' => now()->timestamp
            ]
        );

        return $this->view('mail.turnoMail')
                    ->subject('Es tu turno! Compra tu entrada para ' . $this->evento->nombreEvento)
                    ->with([
                        'idUsuario' => $this->usuario->id,
                        'nombreCliente' => $this->usuario->name,
                        'idEvento' => $this->evento->idEvento,
                        'nombreEvento' => $this->evento->nombreEvento,
                        'fechaEvento' => $this->evento->fechaRealizacion,
                        'lugarEvento' => $this->evento->ubicacion->direccion,
                        'enlaceCompra' => $enlaceCompra,
                    ]);
    }
}
