<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Evento;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Metodo INVOKE administra uno unica ruta

    /* public function __invoke()
    {
        return view('welcome');
    } */

    // MOSTRAR EVENTOS EN LA PAGINA DE INICIO

public function index(Request $request)
{
    // Obtener categorías para el selector
    $categorias = Categoria::all();

    // Si no hay búsqueda, obtenemos todos los eventos como siempre
    /* $eventosProximos = Evento::where('estadoEvento', 'disponible')
        ->with(['categoria', 'ubicacion', 'beneficios' => function ($query) {
            $query->orderBy('created_at', 'desc')->limit(1);
        }])
        ->orderBy('fechaRealizacion', 'asc')
        ->get(); 
        
        $eventosTerminados = Evento::where('estadoEvento', 'terminado')
        ->with(['categoria', 'ubicacion'])
        ->orderBy('fechaRealizacion', 'asc')
        ->get();
        
        */
        $eventosProximos = Evento::whereIn('estadoEvento', ['disponible', 'suspendido', 'agotado'])
        ->with(['categoria', 'ubicacion', 'beneficios' => function ($query) {
            $query->orderBy('created_at', 'desc')->limit(1);
        }])
        ->orderBy('fechaRealizacion', 'asc')
        ->paginate(3, ['*'], 'page_eventosProximos');

        $eventosTerminados = Evento::where('estadoEvento', 'terminado')
        ->with(['categoria', 'ubicacion'])
        ->orderBy('fechaRealizacion', 'asc')
        ->paginate(3, ['*'], 'page_eventosTerminados');

        // Si la solicitud es AJAX, devolver solo la vista de los eventos
        if ($request->ajax()) {
            if ($request->has('page_eventosProximos')) {
                return view('partials.eventosProximos', compact('eventosProximos'))->render();
            } elseif ($request->has('page_eventosTerminados')) {
                return view('partials.eventosTerminados', compact('eventosTerminados'))->render();
            }
        }

    return view('welcome', compact('eventosProximos', 'eventosTerminados', 'categorias'));
}


 public function buscarEventos(Request $request)
{
    $titulo = 'Resultado de la busqueda';

    try {
        $query = $request->input('query');
        $categoria = $request->input('categoria');

        // Filtrar eventos según el criterio de búsqueda
        $eventos = Evento::where(function ($q) use ($query, $categoria) {
            if ($query) {
                $q->where('nombreEvento', 'like', '%' . $query . '%');
            }
            if ($categoria && $categoria != 0) {
                $q->where('idCategoriaEvento', $categoria);
            }
        })
        ->whereIn('estadoEvento', ['disponible', 'suspendido', 'agotado']) // Filtrar por estado
        ->with(['categoria', 'ubicacion'])
        ->get();

        // Verificar si hay resultados
        if ($eventos->isEmpty()) {
            return response()->json(['message' => 'No se encontraron eventos.'], 404);
        }

        // Renderizar la vista de resultados parciales
        $html = view('partials.eventos_resultados', ['eventos' => $eventos])->render();

        
        return response()->json(['html' => $html, 'titulo' =>$titulo], 200);

    } catch (\Exception $e) {
        // Devolver un mensaje de error en lugar de detener el flujo
        return response()->json(['message' => 'Ocurrió un error al buscar eventos.'], 500);
    }
}



}
