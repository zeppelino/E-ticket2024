<?php

namespace App\Mail;


use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EventoCanceladoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $evento;
    public $nroTransaccion;


    public function __construct($user, $evento, $nroTransaccion)
    {
        $this->user = $user;
        $this->evento = $evento;
        $this->nroTransaccion = $nroTransaccion;

    }

      /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            // Subject = asunto
            subject: 'Evento Cancelado',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.evento_cancelado',
        );
    }

    public function build()
    {
        return $this->subject('Evento Cancelado')
                    ->view('mail.evento_cancelado')
                    ->with([
                        'nombreUsuario' => $this->user->name,
                        'nombreEvento' => $this->evento->nombreEvento,
                        'nroTransaccion' => $this->nroTransaccion,
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