<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class EnviarCorreoPrueba extends Command
{
    protected $signature = 'app:enviar-correo-prueba';
    protected $description = 'Enviar un correo de prueba para verificar la configuración de envío de correos';

    public function handle()
    {
        // Email estático al que se enviará el aviso
        //ESTABA TENIENDO PROBLEMAS MANDADOI EL MAIL - YA QUE ESTABA UTILIZANDO UN FORMATO VIEJO
        $emailDestino = 'ejemplo@correo.com'; // Cambia esto por el email real

        // Contenido del correo simple
        $contenidoHtml = "
            <h1>Prueba de Correo</h1>
            <p>Este es un correo de prueba para verificar la configuración de envío.</p>
        ";

        // Enviar el correo
        Mail::send([], [], function ($message) use ($emailDestino, $contenidoHtml) {
            $message->to($emailDestino)
                    ->subject('Correo de Prueba')
                    ->html($contenidoHtml); // Cambia setBody por html()
        });

        $this->info('Correo de prueba enviado a: ' . $emailDestino);
    }
}