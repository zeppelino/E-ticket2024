<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tanda;
use Carbon\Carbon;

class ActivarTandasComando extends Command
{
    protected $signature = 'app:activar-tandas-comando';
    protected $description = 'Activar las tandas en el momento';

    public function handle()
    {
        // Obtener tandas pendientes que estén dentro del rango de fechas
        $tandas = Tanda::where('estadoTanda', 'pendiente')
            ->where('fechaInicio', '<=', Carbon::now())
            ->where('fechaFin', '>=', Carbon::now())
            ->get();

        // Iterar sobre las tandas
        foreach ($tandas as $tanda) {
            // Cambiar el estado de la tanda a 'activo'
            $tanda->estadoTanda = 'activo';
            $tanda->save();

            // Opcional: Imprimir un mensaje en la consola para confirmar el cambio
            $this->info("La tanda '{$tanda->nombreTanda}' ha sido activada.");
        }
        $this->info('Todas las tandas válidas han sido activadas.');
}}