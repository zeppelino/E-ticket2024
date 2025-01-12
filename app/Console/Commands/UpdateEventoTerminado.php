<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Evento;
use Carbon\Carbon;

class UpdateEventoTerminado extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-evento-terminado';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Va a cambiar a estado Terminado cuando el evento haya finalizado';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Consultar los eventos cuyo estado sea "pendiente" y cuya fecha de publicación ya haya pasado
        $events = Evento::whereIn('estadoEvento', ['disponible','agotado'])->where('fechaRealizacion', '<', Carbon::now())->get();

        foreach ($events as $event) {
            $event->estadoEvento = 'terminado';
            $event->save();
            // Opcional: Agregar lógica adicional si es necesario (como notificar usuarios)
        }
   
        $this->info('El estado de los eventos ha sido actualizado.');
    }
}
