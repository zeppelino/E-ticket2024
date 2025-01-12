<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Evento;
use Carbon\Carbon;

class UpdateEventStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-event-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualizar el estado de los eventos pendientes a activo';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Consultar los eventos cuyo estado sea "pendiente" y cuya fecha de publicación ya haya pasado
        $events = Evento::where('estadoEvento', 'pendiente')->where('fechaHabilitacion', '<', Carbon::now())->get();

        foreach ($events as $event) {
            $event->estadoEvento = 'disponible';
            $event->save();
            // Opcional: Agregar lógica adicional si es necesario (como notificar usuarios)
        }
   
        $this->info('El estado de los eventos ha sido actualizado.');
    }
}
