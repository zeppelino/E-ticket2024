<?php

namespace App\Console\Commands;


use Illuminate\Console\Command;
use App\Models\Tanda;
use App\Models\Inscripcion;
use App\Mail\TandaMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class MandarMailInscriptosTandas extends Command
{
    protected $signature = 'app:mandar-mail-inscriptos-tandas';
    protected $description = 'Envía correos a usuarios inscriptos en eventos con tandas activas.';

    public function handle()
    {
        // Obtener todas las tandas activas
        $tandasActivas = Tanda::where('estadoTanda', 'activo')
            ->where('fechaInicio', '<=', Carbon::now())
            ->where('fechaFin', '>=', Carbon::now())
            ->get();

        // Obtener los IDs de los eventos relacionados
        $eventosIds = $tandasActivas->pluck('idEvento');

        // Buscar las inscripciones para esos eventos y cargar el usuario y evento asociados
        $inscripciones = Inscripcion::whereIn('idEvento', $eventosIds)
            ->with(['usuario', 'evento.tipoTickets', 'evento.ubicacion'])
            ->get();

        // Iterar sobre las inscripciones y enviar correo a cada usuario
        foreach ($inscripciones as $inscripcion) {
            $usuario = $inscripcion->usuario;
            $evento = $inscripcion->evento;

            // Verificar que el evento tenga cupos disponibles
            $cupoDisponible = $evento->tipoTickets->sum('cupoDisponible');

            if ($usuario && $evento && $usuario->email && $inscripcion->estadoEnvio === 'pendiente' && $cupoDisponible > 0) {
                // Enviar el correo usando el Mailable
                Mail::to($usuario->email)->send(new TandaMail($usuario, $evento));
                $this->info("Correo enviado a: {$usuario->email} para el evento: {$evento->nombreEvento}");
                $inscripcion->estadoEnvio = 'enviado';
                $inscripcion->save();
            }
        }
    }

   
}
