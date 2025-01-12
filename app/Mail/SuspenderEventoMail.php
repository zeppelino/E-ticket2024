<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SuspenderEventoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $evento;
    public $user;

    public function __construct($usuario, $evento)
    {
        $this->user = $usuario;
        $this->evento = $evento;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'EVENTO SUSPENDIDO',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.eventoSuspendidoMail',
        );
    }


    public function build()
    {

        $fechaRealizacion = Carbon::parse($this->evento->fechaRealizacion)->format('d/m/Y \a \l\a\s H:i');

        return $this->subject('Evento Suspendido')
                    ->view('mail.eventoSuspendidoMail')
                    ->with([
                        'nombreUsuario' => $this->user->name,
                        'nombreEvento' => $this->evento->nombreEvento,
                        'fechaRealizacion' => $fechaRealizacion,
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
