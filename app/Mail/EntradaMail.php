<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EntradaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $entrada;
    public function __construct($entrada)
    {
        $this->entrada = $entrada;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Ya tenes tu entrada para ' . $this -> entrada->tipoTickets->evento->nombreEvento . '!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.entradaMail',
            //view: 'entrada.entradaPDF';
        );
    }

    public function build()
    {
        Carbon::setLocale('es');
        return $this->view('mail.entradaMail')
                    ->subject('Tu nueva entrada para el evento')
                    ->with([
                        'nombreEvento' => $this->entrada->tipoTickets->evento->nombreEvento,
                        'numeroEntrada' => $this->entrada->numeroEntrada,
                        'tipoTicket' => $this->entrada->tipoTickets->categoriaTicket->nombreCatTicket,
                        'precioTicket' => $this->entrada->precio,
                        'fechaEvento' => \Carbon\Carbon::parse($this->entrada->tipoTickets->evento->fechaRealizacion)->translatedFormat('d \d\e F \d\e Y'),
                        'horaEvento' => \Carbon\Carbon::parse($this->entrada->tipoTickets->evento->fechaRealizacion)->format('H:i'),
                        'lugarEvento' => $this->entrada->tipoTickets->evento->ubicacion->direccion,
                        'ciudad' => $this->entrada->tipoTickets->evento->ubicacion->ciudad,
                        'nombreCliente' => $this->entrada->usuario->name,
                        'fechaCompra' => \Carbon\Carbon::parse($this->entrada->created_at)->translatedFormat('d \d\e F \d\e Y'),
                    ]);
                
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
