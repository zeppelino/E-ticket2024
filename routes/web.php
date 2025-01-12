<?php
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\EntradaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ListaEsperaController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MailController;
use App\Http\Controllers\NotificacionesCampanaController;

//Guia para definir rutas:
//Route::<tipo_metodo>(/<nombreURL>),[<NombreControlador>::class, '<nombreMetodo>'])->name('<nombreVista>');

/*==================
  VISTAS FRONTEND
===================*/

/* Pagina principal */
Route::get('/', [HomeController::class,'index'])->name('welcome');
/* Buscar eventos */
Route::get('/buscar-eventos', [HomeController::class, 'buscarEventos'])->name('buscar.eventos');
/* Mostrar un evento */
Route::get('/Evento/{idEvento}', [EventoController::class, 'show'])->name('unEvento');
/* Ruta lista de espera */
Route::get('/listaEspera', [ListaEsperaController::class, 'mostrarListaEspera'])->name('listaEspera'); // esta esta al pedo // si no se usa borrenlo
Route::post('/inscripcion', [ListaEsperaController::class, 'enviarMailListaEspera'])->name('notificacionListaEspera');
// Rutas para la compra de entrada//
Route::get('/compra', [ListaEsperaController::class, 'mostrarComprarEntradaTemporal'])->middleware('auth')->name('comprarEntradaTemporal')/* ->middleware('signed') */;
Route::get('/entradaAdquirida', [ListaEsperaController::class, 'mostrarComprarEntradaTemporal'])->name('entradaAdquirida')->middleware('signed');
Route::get('/tiempoExpirado', [ListaEsperaController::class, 'tiempoExpirado'])->name('tiempoExpirado');

Route::get('/entradas-agotadas', function () {
  return view('entradasAgotadas');
})->name('entradasAgotadas');

Route::post('/pasarelaPago', [PagoController::class, 'mostrarPasarela'])->name('pasarelaPago');
Route::get('/resultadoCompra', [PagoController::class, 'procesarPago'])->name('resultadoCompra');
Route::get('/entradaAdquirida', [PagoController::class, 'procesarPago'])->name('entradaAdquirida');

// Route::get('/pasarelaPago', function () {
//   return redirect()->route('welcome')->with('error', 'Acceso no permitido.');
// });

Route::get('/enviar-mails', [MailController::class, 'enviarMails'])->name('enviar.mails');
Route::post('/enviar-tandas', [MailController::class, 'enviarTandas'])->name('enviar.tandas');

/*==================
   VISTAS BACKEND
===================*/

/* Solo Admin (redirige a dashboard si no es rol admin)*/
Route::group(['middleware' => ['auth','onlyAdmin']], function () {
  /*===============================
  TABLA EVENTO  - Listar eventos
  ===============================*/
  Route::get('/eventos', [EventoController::class, 'listarEventos'])->name('admin.eventos');
  /*=======================================
  TABLA EVENTO - Cambiar estado de evento
  =======================================*/
  Route::post('/eventos/cambiar-estado/{idEvento}', [EventoController::class, 'cambiarEstadoEvento'])->name('cambiarEstado');
  //Route::get('/eventos/actualizar-fila/{idEvento}', [EventoController::class, 'actualizarFila']);
  /*=======================
  TABLA EVENTO - Beneficio
  ========================*/
  Route::get('/eventos/{idEvento}/beneficio', [EventoController::class, 'getBeneficio']);
  Route::post('/eventos/{idEvento}/beneficio', [EventoController::class, 'saveBeneficio']);
  Route::delete('/eventos/{idEvento}/beneficio', [EventoController::class, 'deleteBeneficio']);
  /*===============================
  TABLA EVENTO - Modificar evento
  ================================*/
  Route::get('/eventos/{id}/editar', [EventoController::class, 'editar'])->name('admin.editarEvento');
  Route::put('/eventos/{id}', [EventoController::class, 'actualizar'])->name('admin.actualizarEvento2');
  Route::put('/admin/evento/actualizar/{id}', [EventoController::class, 'update'])->name('admin.actualizarEvento'); 
  /*===================
  EVENTO - Creación
  ===================*/
  Route::get('/crearEvento', [EventoController::class, 'crearEvento'])->name('admin.crearEvento');
  Route::get('/crearEvento/provincias/{paisId}', [EventoController::class, 'buscarProvincia'])->name('admin.buscarProvincia');
  Route::get('/crearEvento/localidades/{localidadId}', [EventoController::class, 'buscarLocalidad'])->name('admin.buscarLocalidad');
  Route::post('/crearEvento/guardar', [EventoController::class, 'guardarEvento'])->name('guardarEvento');
  /*================
  EVENTO - Detalle
  =================*/
  Route::get('/admin/evento/{id}', [EventoController::class, 'mostrarDetalle'])->name('admin.detalleEvento');
  /*===================
  EVENTO - Reprogramar
  ===================*/
  Route::get('/reprogramarEvento/{idEventoSuspendido}', [EventoController::class, 'reprogramarEvento'])->name('admin.reprogramarEvento');
  Route::post('/reprogramarEvento/guardar', [EventoController::class, 'guardarEventoReprogramado'])->name('guardarEventoReprogramado');
  /*==========
  REPORTES
  ===========*/
  Route::get('/reportes', [ReportController::class, 'listarReportes'])->name('admin.reportes');
  Route::get('/reportes/reportePdf', [ReportController::class, 'reportePDF'])->name('reportePDF');

});

/* Solo Cliente */
Route::group(['middleware' => ['auth','onlyCliente']], function () {
  /* entradas */
  Route::get('/Entradas', [EntradaController::class, 'verMisEntradas'])->name('verMisEntradas');
  Route::get('/Entradas/entradaPDF{idEntrada}', [EntradaController::class, 'entradaPdf'])->name('entradaPDF');
  /*Buscar eventos para dashboard client */
  Route::get('/buscar-eventos2', [EventoController::class, 'buscarEventosClientes'])->name('buscar.eventos2');
});

/* Usuario Admin o Cliente */
Route::middleware('auth')->group(function () {
  /* dashboard */
  Route::get('/Inicio', [DashboardController::class, 'showDashboard'])->name('dashboard');
  /* perfil */
  Route::get('/perfil', [PerfilController::class, 'mostrarPerfil'])->name('perfil');
  Route::post('/perfil/update', [PerfilController::class, 'modificarPerfil'])->name('perfil.update');
  /* notificaiones - campana - cambia a leida */
  Route::post('/marcarNotificacionComoLeida/{notification}', [NotificacionesCampanaController::class, 'marcarComoLeida']);
  /* notificaiones - campana - muestra tabla*/
  Route::get('/notificaciones', [NotificacionesCampanaController::class, 'verTablaNotificaciones'])->name('admin.verNotificaciones');
});

/*==================================
USUARIO - de Breeze (no se utiliza)
==================================*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/* Logout */
Route::controller(AuthenticatedSessionController::class)->group(function () {
  Route::get('/admin/logout', 'destroy')->name('admin.logout');
});

require __DIR__ . '/auth.php';
