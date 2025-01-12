<?php


use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


// El facade Schedule nos permite programar la ejecución de comandos
Schedule::command('app:update-event-status')->everyMinute();

Schedule::command('app:activar-tandas-comando')->everyMinute();

Schedule::command('app:update-evento-terminado')->everyMinute();

Schedule::command('app:mandar-mail-inscriptos-tandas')->everyMinute();


Schedule::command('app:verificar-eventos-agotados')->everyMinute();

Schedule::command('app:estado-venta-perdido')->everyMinute();
// tengo que hacer un comando aparte para mandar los mails, asi no queda sobrecargado el tanda cambio de estado
//Schedule::command('app:enviar-correo-prueba')->everyMinute();
