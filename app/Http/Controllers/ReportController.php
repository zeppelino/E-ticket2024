<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Inscripcion;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{

    /*====================
    GENERAR PDF REPORTES
    =====================*/
// REPORTE DE 1 AÑO CON TODOS LOS DATOS
    public function reportePDF(Request $request)
    {

        $tipoReporte = $request->input('tipo_reporte'); // busco el tipo de reporte con el request

        // hago la consulta del evento
        $eventos = Evento::with(['ubicacion', 'categoria', 'tipoTickets'])
            ->whereBetween('fechaRealizacion', [$request->input('fecha_desde'), $request->input('fecha_hasta')])
            ->orderby('fechaRealizacion', 'asc')
            ->get();

        foreach ($eventos as $evento) {
            $evento->cancelados = Inscripcion::where('idEvento', $evento->idEvento)
                ->where('estadoVenta', 'cancelado')
                ->count();
        }

        $fecha_d = $request->input('fecha_desde');
        $fecha_h = $request->input('fecha_hasta');

        $fecha_desde = Carbon::parse($fecha_d)->format('d/m/Y');
        $fecha_hasta = Carbon::parse($fecha_h)->format('d/m/Y');

        // Segun que tipo de pdf se carga la vista
        if ($tipoReporte == 'anual') {
            // Generar el PDF para el reporte anual
            $pdf = PDF::loadView('reportes.reporteAnualPDF', compact('eventos', 'fecha_desde', 'fecha_hasta')); //enviar fechas !!

        } elseif ($tipoReporte == 'entradas') {

            // Generar el PDF para el reporte de entradas
            $pdf = PDF::loadView('reportes.reporteEntradasPDF',compact('eventos', 'fecha_desde', 'fecha_hasta')); //enviar fechas !!

        } else {
            // Manejo de error si el tipo de reporte no es válido
            return redirect()->back()->with('error', 'Tipo de reporte no válido.');
        }

        return $pdf->stream();

    }

    // CODIGO PARA REPORTES DE AÑO A AÑO
    /* public function reportePDF(Request $request)
    {
    $tipoReporte = $request->input('tipo_reporte');

    // Cargar la vista del PDF según el tipo de reporte
    if ($tipoReporte == 'anual') {
    // Si el reporte es anual se busca esta consulta
    // Obtener eventos en el rango de fechas y agrupados por año
    $eventosPorAnio = Evento::with(['ubicacion', 'categoria', 'tipoTickets'])
    ->whereBetween('fechaRealizacion', [$request->input('fecha_desde'), $request->input('fecha_hasta')])
    ->orderBy('fechaRealizacion', 'asc')
    ->get()
    ->groupBy(function ($evento) {
    return \Carbon\Carbon::parse($evento->fechaRealizacion)->format('Y');
    });

    // Calcular los totales por cada año
    $eventosResumen = [];
    foreach ($eventosPorAnio as $anio => $eventos) {
    $cantidadEventos = $eventos->count();
    $entradasVendidas = 0;
    $entradasNoVendidas = 0;
    $sinEntradas = 0;

    foreach ($eventos as $evento) {
    // Sumar entradas vendidas y no vendidas
    foreach ($evento->tipoTickets as $tipoTicket) {
    $entradasVendidas += $tipoTicket->cupoTotal - $tipoTicket->cupoDisponible;
    $entradasNoVendidas += $tipoTicket->cupoDisponible;
    }

    // Calcular el número de personas sin entradas (estadoVenta = 'cancelado')
    $sinEntradas += Inscripcion::where('idEvento', $evento->idEvento)
    ->where('estadoVenta', 'cancelado')
    ->count();
    }

    $eventosResumen[] = [
    'anio' => $anio,
    'cantidadEventos' => $cantidadEventos,
    'entradasVendidas' => $entradasVendidas,
    'entradasNoVendidas' => $entradasNoVendidas,
    'sinEntradas' => $sinEntradas,
    ];
    }

    // Aca se devuelve el pdf
    $pdf = PDF::loadView('reportes.reporteAnualPDF', compact('eventosResumen'));

    } elseif ($tipoReporte == 'entradas') {

    // Si es un reporte de entrada proceso esta informacion
    $eventos = Evento::with(['ubicacion', 'categoria', 'tipoTickets'])
    ->whereBetween('fechaRealizacion', [$request->input('fecha_desde'), $request->input('fecha_hasta')])
    ->orderby('fechaRealizacion', 'asc')
    ->get();

    foreach ($eventos as $evento) {
    $evento->cancelados = Inscripcion::where('idEvento', $evento->idEvento)
    ->where('estadoVenta', 'cancelado')
    ->count();
    }

    // aca se envia la info a la vista del pdf
    $pdf = PDF::loadView('reportes.reporteEntradasPDF', compact('eventos'));
    } else {
    return redirect()->back()->with('error', 'Tipo de reporte no válido.');
    }

    return $pdf->stream();
    } */

    /*====================
    LISTAR REPORTES
    =====================*/
    public function listarReportes()
    {
        // Obtén todos los eventos junto con la ubicación, categoría, tipoTickets y las inscripciones
        $eventos = Evento::with(['ubicacion', 'categoria', 'tipoTickets'])
            ->orderby('fechaRealizacion', 'asc')
            ->get();

        foreach ($eventos as $evento) {
            $evento->cancelados = Inscripcion::where('idEvento', $evento->idEvento)
                ->where('estadoVenta', 'cancelado')
                ->count();
        }

        return view('admin.reportes', compact('eventos'));
    }
}
