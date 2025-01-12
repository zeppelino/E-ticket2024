<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Evento;
use App\Models\Tanda;

class VerificarEventosAgotados extends Command
{
    protected $signature = 'app:verificar-eventos-agotados';
    protected $description = 'Verifica si los eventos han agotado sus cupos y cambia su estado a "agotado".';



    public function handle()
    {
        // Obtener todos los eventos con estado "disponible"
        $eventosActivos = Evento::where('estadoEvento', 'disponible')->with('tipoTickets')->get();

        foreach ($eventosActivos as $evento) {
            // Sumar los cupos totales y disponibles
            $cupoTotal = $evento->tipoTickets->sum('cupoTotal');
            $cupoDisponible = $evento->tipoTickets->sum('cupoDisponible');

            // Verificar si todos los cupos están agotados
            if ($cupoDisponible === 0 && $cupoTotal > 0) {
                // Cambiar el estado a "agotado"
                $evento->estadoEvento = 'agotado';
                $evento->save();

                $this->info("Evento agotado: {$evento->nombreEvento}");
            }
        }

    }

    // public function handle()
    // {
    //     // Obtener todos los eventos activos
    //     $eventosActivos = Evento::where('estadoEvento', 'disponible')->with('tipoTickets')->get();

    //     foreach ($eventosActivos as $evento) {
    //         // Calcular la suma de cupos disponibles para el evento
    //         $cupoDisponible = $evento->tipoTickets->sum('cupoDisponible');

    //         if ($cupoDisponible <= 0) {
    //             // Cambiar el estado del evento a "agotado"
    //             $evento->estadoEvento = 'agotado';
    //             $evento->save();

    //             $this->info("Evento agotado: {$evento->nombreEvento}");
    //         } else {
    //             $this->info("Evento con cupos disponibles: {$evento->nombreEvento}, cupos restantes: {$cupoDisponible}");
    //         }
    //     }

    //     $this->info('Verificación de eventos completada.');
    // }
}
