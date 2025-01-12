<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Inscripcion;
use App\Models\Evento;
use Carbon\Carbon;

class estadoVentaPerdido extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:estado-venta-perdido';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualizar el estado de venta en las inscripciones';

    /**
     * Execute the console command.
     */
    public function handle()
{
    // Calcular el tiempo límite (15 minutos antes de ahora)
    $tiempoLimite = Carbon::now()->subMinutes(10);

    // Buscar inscripciones con estadoVenta 'pendiente' y updated_at anterior al tiempo límite
    $inscripciones = Inscripcion::where('estadoVenta', 'pendiente')
        ->where('updated_at', '<', $tiempoLimite)
        ->get();

    foreach ($inscripciones as $inscripcion) {
        // Actualizar estadoVenta a 'cancelado'
        $inscripcion->estadoVenta = 'cancelado';
        $inscripcion->save();
    }

    $this->info('El estado de venta de las inscripciones pendientes ha sido actualizado.');
}
}
