
    @extends('reportes.head')

    @section('titulo', 'Reporte Eventos')
    
    @section('contenido')
    <div class="container">
        <div class="text-center">
            <h1>Reporte de Eventos</h1>
            <p style="font-size: 14px; font-weight: bold; margin-bottom: 10px;">
                Período del reporte: 
                <span style="color: #2c3e50;">{{ $fecha_desde }}</span> 
                al 
                <span style="color: #2c3e50;">{{ $fecha_hasta }}</span>
            </p>
            
        </div>

        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Tipo de Evento</th>
                    <th>Nombre del Evento</th>
                    <th>Lugar</th>
                    <th>Cupo de Entradas</th>
                    <th>Entradas Vendidas</th>
                    <th>Entradas No Vendidas</th>
                    <th>Participantes Sin Entradas</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($eventos as $evento)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($evento->fechaRealizacion)->format('d/m/Y') }}</td>
                        <td>{{ $evento->categoria->nombreCategoria ?? 'N/A' }}</td>
                        <td>{{ $evento->nombreEvento }}</td>
                        <td>{{ $evento->ubicacion->direccion ?? 'N/A' }}, {{ $evento->ubicacion->ciudad ?? 'N/A' }}</td>
                        <td class="numeric">{{ $evento->tipoTickets->sum('cupoTotal') }}</td>
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

