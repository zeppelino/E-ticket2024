@extends('reportes.head')

@section('titulo', 'Reporte Entradas')

@section('contenido')
    <div class="container">
        <div class="text-center">
            <h1>Reporte de Entradas</h1>
            <p style="font-size: 14px; font-weight: bold; margin-bottom: 10px;">
                Período del reporte: 
                <span style="color: #2c3e50;">{{ $fecha_desde }}</span> 
                al 
                <span style="color: #2c3e50;">{{ $fecha_hasta }}</span>
            </p>
        </div>
        
        <div class="table-responsive" id="divEntradas">
            <table class="table table-bordered table-striped tablaReporte" id="tablaEntradas">
                <thead class="table-info">
                    <tr>
                        <th>Nombre del Evento</th>
                        <th>Entradas Vendidas</th>
                        <th>Entradas No Vendidas</th>
                        <th>Participantes Sin Entradas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($eventos as $evento)
                    <tr>
                        <td>{{$evento->nombreEvento }}</td>
                        <td class="numeric">{{ $evento->tipoTickets->sum(function ($tipoTicket) { 
                            return $tipoTicket->cupoTotal - $tipoTicket->cupoDisponible; 
                        }) }}</td>
                        <td class="numeric">{{ $evento->tipoTickets->sum('cupoDisponible') }}</td>
                        <td class="numeric">{{ $evento->cancelados  }}</td>
                    </tr>     
                    @endforeach
                </tbody>
            </table>
    </div>
    
@endsection()