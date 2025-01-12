<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InscripcionListaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $evento;
    public $idEvento;
    

    /**
     * Create a new message instance.
     */
    public function __construct($user, $evento, $idEvento)
    {
        $this->user = $user;
        $this->evento = $evento;
        $this->idEvento = $idEvento;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            // Subject = asunto
            subject: 'Inscripcion a evento',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.inscribirseListaEsperaMail',
        );
    }

    public function build()
    {
        return $this->subject('Inscripción en lista de espera')
                    ->view('mail.inscribirseListaEsperaMail')
                    ->with([
                        'nombreUsuario' => $this->user->name,
                        'nombreEvento' => $this->evento->nombreEvento,
                        'idEvento' => $this->evento->idEvento,
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
