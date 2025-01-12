<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Entrada;
use App\Models\Evento;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /*====================
    DASHBOARD SISTEMA
    ====================*/

    public function showDashboard()
    {

        //PARTE DE VISTA "CLIENTE"

        $usuario = auth()->user(); // or Auth::user()

        if ($usuario->hasRole('Cliente')) {

            // Obtener categorías para el selector
            $categorias = Categoria::all();

            //Listar eventos clientes
            $userId = auth()->user()->id; // O el ID del usuario que quieras usar

            $eventosRelacionados = Evento::where('estadoEvento', 'disponible')
                ->whereHas('categoria', function ($query) use ($userId) {
                    $query->whereIn('idCategoria', function ($subQuery) use ($userId) {
                        $subQuery->select('eventos.idCategoriaEvento')
                            ->from('entradas')
                            ->join('tipo_tickets', 'entradas.idTipoTicket', '=', 'tipo_tickets.idTipoTicket')
                            ->join('eventos', 'tipo_tickets.idEvento', '=', 'eventos.idEvento')
                            ->where('entradas.idUsuario', $userId);
                    });
                })->orderBy('fechaRealizacion', 'asc')
                ->take(4) // Restringir a los primeros 4 resultados
                ->paginate(3);

            // Obtener IDs de eventos relacionados con las entradas del usuario
            $eventosRelacionadosIds = Entrada::where('idUsuario', $userId)
                ->join('tipo_tickets', 'entradas.idTipoTicket', '=', 'tipo_tickets.idTipoTicket')
                ->join('eventos', 'tipo_tickets.idEvento', '=', 'eventos.idEvento')
                ->pluck('eventos.idEvento');

            // Obtener los de eventos próximos
            $eventosProximosArray = Evento::where('fechaHabilitacion', '>', Carbon::now())
                ->whereNotIn('idEvento', $eventosRelacionadosIds)
                ->take(4) // Restringir a los primeros 4 resultados
                ->get();

            // Obtener los de eventos populares
            $eventosPopulares = Evento::select('eventos.idEvento', 'eventos.nombreEvento', 'eventos.descripcionEvento', 'eventos.urlImagen', 'eventos.fechaRealizacion', 'eventos.idUbicacion', 'eventos.idCategoriaEvento', DB::raw('COUNT(entradas.idEntrada) as total_entradas_vendidas'))
                ->join('tipo_tickets', 'eventos.idEvento', '=', 'tipo_tickets.idEvento')
                ->join('entradas', 'tipo_tickets.idTipoTicket', '=', 'entradas.idTipoTicket')
                ->where('eventos.estadoEvento', 'disponible')
                ->groupBy('eventos.idEvento', 'eventos.nombreEvento', 'eventos.descripcionEvento', 'eventos.urlImagen', 'eventos.fechaRealizacion', 'eventos.idUbicacion', 'eventos.idCategoriaEvento') // Agrupar por las columnas necesarias
                ->orderByDesc('total_entradas_vendidas')
                ->take(4)
                ->paginate(3);

            return view('admin.index', compact('categorias', 'eventosProximosArray', 'eventosRelacionados', 'eventosPopulares'));

        }

        // PARTE VISTA "ADMIN"

        $hoy = Carbon::now();
        $haceUnaSemana = $hoy->subDays(7);
        $haceUnMes = $hoy->subDays(30);

        // datos para gráfico de dona

        $eventos = Evento::select('nombreEvento')
            ->selectSub(function ($query) {
                $query->from('tipo_tickets')
                    ->join('entradas', 'tipo_tickets.idTipoTicket', '=', 'entradas.idTipoTicket')
                    ->whereColumn('tipo_tickets.idEvento', 'eventos.idEvento')
                    ->selectRaw('COUNT(entradas.idEntrada)');
            }, 'entradas_count')
            ->whereNotIn('estadoEvento', ['cancelado', 'reprogramado']) // Excluir eventos cancelados y reprogramados
            ->having('entradas_count', '>', 0) // Filtrar eventos con al menos una entrada vendida
            ->orderByDesc('entradas_count')
            ->take(5)
            ->get();

        $eventNames = $eventos->pluck('nombreEvento')->toArray();
        $ticketCounts = $eventos->pluck('entradas_count')->toArray();

        // ingresos semana
        /* $ingresosYEntradasSemana = Entrada::whereBetween('fechaCompra', [$haceUnaSemana, Carbon::now()])
        ->selectRaw('SUM(precio) as total_ingresos, COUNT(idEntrada) as total_entradas_vendidas')
        ->first(); */

        // Ingresos y entradas del último mes, excluyendo eventos cancelados
        /*   $ingresosYEntradasMes = Entrada::join('tipo_tickets', 'entradas.idTipoTicket', '=', 'tipo_tickets.idTipoTicket')
        ->join('eventos', 'tipo_tickets.idEvento', '=', 'eventos.idEvento')
        ->where('eventos.estadoEvento', '!=', 'cancelado')
        ->whereBetween('fechaCompra', [$haceUnMes, Carbon::now()])
        ->selectRaw('SUM(precio) as total_ingresos, COUNT(entradas.idEntrada) as total_entradas_vendidas')
        ->first(); */

        // Obtener total de ingresos y cantidad de entradas vendidas
        $ingresosYEntradas = Entrada::join('tipo_tickets', 'entradas.idTipoTicket', '=', 'tipo_tickets.idTipoTicket')
            ->join('eventos', 'tipo_tickets.idEvento', '=', 'eventos.idEvento')
            ->whereNotIn('estadoEvento', ['cancelado', 'reprogramado']) // Excluir eventos cancelados y reprogramados
            ->selectRaw('SUM(precio) as total_ingresos, COUNT(entradas.idEntrada) as total_entradas_vendidas')
            ->first();

        // Obtener la cantidad de eventos próximos
        $eventosProximos = Evento::where('fechaHabilitacion', '>', Carbon::now())
            ->count();

        // Obtener la cantidad de eventos activos (disponibles)
        $eventosActivos = Evento::where('estadoEvento', 'disponible')
            ->count();

        // Ranking de usuarios
        $rankingUsuarios = DB::table('entradas')
            ->join('tipo_tickets', 'entradas.idTipoTicket', '=', 'tipo_tickets.idTipoTicket')
            ->join('eventos', 'tipo_tickets.idEvento', '=', 'eventos.idEvento')
            ->join('users', 'entradas.idUsuario', '=', 'users.id')
            ->select('users.name', 'users.email', DB::raw('COUNT(entradas.idEntrada) as total_entradas'))
            ->whereNotIn('eventos.estadoEvento', ['cancelado', 'reprogramado']) // Excluir eventos cancelados y reprogramados
            ->groupBy('users.id', 'users.name', 'users.email')
            ->orderByDesc('total_entradas')
            ->limit(5) // Limitar a los 5 primeros usuarios
            ->get();

        // Pasar las variables a la vista usando compact
        return view('admin.index', compact('ingresosYEntradas', 'eventosProximos', 'eventosActivos', 'rankingUsuarios', 'eventNames', 'ticketCounts'));
    }

}
