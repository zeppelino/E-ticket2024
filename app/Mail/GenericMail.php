<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GenericMail extends Mailable
{
    use Queueable, SerializesModels;

    public function build()
    {
        return $this->view('mail.turnoMail')
                    ->subject('Asunto del correo');
    }
}
