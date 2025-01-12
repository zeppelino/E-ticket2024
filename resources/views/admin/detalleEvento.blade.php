@extends('admin.adminMaster')

@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <div class="d-flex align-items-center mb-4">
                <!-- Aca esta la imagen -->
                @if ($evento->urlImagen)
                    <div>
                        <img src="{{ asset($evento->urlImagen) }}" alt="Imagen del Evento"
                            class="img-fluid rounded shadow-lg me-3" style="max-height: 200px; width: auto;">
                        <!-- Tamaño reducido en un 15% -->
                    </div>
                @else
                    <div class="alert alert-warning text-center">No hay imagen disponible para este evento.</div>
                @endif

                {{-- nombre del evento --}}
                <div>
                    <p class="fw-bold" style="color: #0d6efd; font-size: 1vw;">Nombre del Evento:</p>
                    <h1 style="color: #0d6efd; font-size: 3vw; " class="text-center">
                        {{ $evento->nombreEvento }}
                    </h1>
                </div>
            </div>
            
            @if ($evento->tipoTickets->isNotEmpty())
            <!-- Mostrar total de tickets y tickets disponibles -->
            <div class="alert alert-info text-center fs-5">
                <strong>Total de Tickets:</strong> {{ $evento->tipoTickets->sum('cupoTotal') }}     |
                <strong>Total de Tickets Disponibles:</strong> {{ $evento->tipoTickets->sum('cupoDisponible') }}
            </div>
        @endif
            

            <!-- Información General -->
            <div class="card shadow-sm mb-1">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0 text-center text-secondary">INFORMACIÓN GENERAL</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Primera columna -->
                        <div class="col-md-6">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>País:</strong> {{ $evento->ubicacion->país ?? 'N/A' }}
                                </li>
                                <li class="list-group-item"><strong>Provincia:</strong>
                                    {{ $evento->ubicacion->provincia ?? 'N/A' }}</li>
                                <li class="list-group-item"><strong>Ciudad:</strong>
                                    {{ $evento->ubicacion->ciudad ?? 'N/A' }}</li>
                                <li class="list-group-item"><strong>Ubicación:</strong>
                                    {{ $evento->ubicacion->direccion ?? 'N/A' }}</li>
                                <li class="list-group-item"><strong>Estado:</strong>
                                    <span
                                        class="badge bg-{{ $evento->estadoEvento == 'disponible' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($evento->estadoEvento) }}
                                    </span>
                                </li>
                            </ul>
                        </div>

                        <!-- Segunda columna -->
                        <div class="col-md-6">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>Categoría:</strong>
                                    {{ $evento->categoria->nombreCategoria ?? 'N/A' }}</li>
                                <li class="list-group-item"><strong>Descripción:</strong>
                                    {{ $evento->descripcionEvento ?? 'N/A' }}</li>
                                <li class="list-group-item"><strong>Fecha y Hora de Habilitación:</strong>
                                    {{ \Carbon\Carbon::parse($evento->fechaHabilitacion)->format('d/m/Y H:i A') }}</li>
                                <li class="list-group-item"><strong>Fecha y Hora de Realización:</strong>
                                    {{ \Carbon\Carbon::parse($evento->fechaRealizacion)->format('d/m/Y H:i A') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
 

            <!-- Beneficio, Tandas y Tickets en 3 columnas -->
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <!-- Beneficio -->
                <div class="col">
                    <h4 class="text-secondary mt-4 card-header bg-success">Beneficio</h4>
                    @if ($evento->beneficios->isNotEmpty())
                        @php
                            $beneficio = $evento->beneficios->first();
                        @endphp
                        <div class="card shadow-sm mb-4">
                          {{--   <div class="card-header bg-success text-white">
                                <h5 class="mb-0">Detalles del Beneficio</h5>
                            </div> --}}
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>Fecha Desde:</strong>
                                    {{ \Carbon\Carbon::parse($beneficio->fechaInicioBeneficio)->format('d/m/Y') }}</li>
                                <li class="list-group-item"><strong>Fecha Hasta:</strong>
                                    {{ \Carbon\Carbon::parse($beneficio->fechaFinBeneficio)->format('d/m/Y') }}</li>
                                <li class="list-group-item"><strong>Porcentaje de Descuento:</strong> <span
                                        class="text-success fw-bold">{{ $beneficio->porcentaje }}%</span></li>
                            </ul>
                        </div>
                    @else
                        <div class="alert alert-info">Este evento no tiene beneficios disponibles.</div>
                    @endif
                </div>

                <!-- Tandas -->
                <div class="col">
                    <h4 class="text-secondary mt-4 card-header bg-success">Tandas</h4>
                    @if ($evento->tandas->isEmpty())
                        <div class="alert alert-info">No hay tandas disponibles para este evento.</div>
                    @else
                        <ul class="list-group mb-4">
                            @foreach ($evento->tandas as $tanda)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $tanda->nombreTanda }}</strong><br>
                                        Inicio: {{ \Carbon\Carbon::parse($tanda->fechaInicio)->format('d/m/Y H:i') }}<br>
                                        Fin: {{ \Carbon\Carbon::parse($tanda->fechaFin)->format('d/m/Y H:i') }}
                                    </div>
                                    <span class="badge bg-primary">Cupos: {{ $tanda->cupos }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <!-- Tipos de Tickets -->
                <div class="col">
                    <h4 class="text-secondary mt-4 card-header bg-success">Tipos de Tickets</h4>
                    @if ($evento->tipoTickets->isEmpty())
                        <div class="alert alert-info">No hay tickets disponibles para este evento.</div>
                    @else
                        <ul class="list-group mb-4">
                            @foreach ($evento->tipoTickets as $ticket)
                                <li class="list-group-item">
                                    <strong>{{ $ticket->categoriaTicket->nombreCatTicket }}</strong><br>
                                    <strong>{{ $ticket->descripcionTipoTicket }}</strong><br>
                                    Precio: <span
                                        class="text-success fw-bold">${{ number_format($ticket->precioTicket, 2) }}</span><br>
                                    Cupo Total: {{ $ticket->cupoTotal }} | Cupo Disponible: {{ $ticket->cupoDisponible }}
                                </li>
                            @endforeach
                        </ul>
                        <!-- Mostrar total de tickets y tickets disponibles en una fila debajo -->
                    @endif
                </div>
            </div>
          
            <div class="text-center">
                <a href="{{ route('admin.eventos') }}" class="btn btn-primary btn-lg m-3 d-inline-flex align-items-center">
                    <i class="ri-arrow-left-line me-1"></i> Volver
                </a>
            </div>
        </div>
    </div>
@endsection

<!-- Información del Evento -->
{{-- <div class="card shadow-sm mb-5">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Información General</h5>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>País:</strong> {{ $evento->ubicacion->país ?? 'N/A' }}</li>
                    <li class="list-group-item"><strong>Provincia:</strong> {{ $evento->ubicacion->provincia ?? 'N/A' }}
                    </li>
                    <li class="list-group-item"><strong>Ciudad:</strong> {{ $evento->ubicacion->ciudad ?? 'N/A' }}</li>
                    <li class="list-group-item"><strong>Ubicación:</strong> {{ $evento->ubicacion->direccion ?? 'N/A' }}
                    </li>
                    <li class="list-group-item"><strong>Estado:</strong>
                        <span class="badge bg-{{ $evento->estadoEvento == 'disponible' ? 'success' : 'secondary' }}">
                            {{ ucfirst($evento->estadoEvento) }}
                        </span>
                    </li>
                    <li class="list-group-item"><strong>Categoría:</strong>
                        {{ $evento->categoria->nombreCategoria ?? 'N/A' }}</li>
                    <li class="list-group-item"><strong>Descripción:</strong> {{ $evento->descripcionEvento ?? 'N/A' }}</li>
                    <!-- Mostrar la fecha de habilitación -->
                    <li class="list-group-item"><strong>Fecha de Habilitación:</strong>
                        {{ \Carbon\Carbon::parse($evento->fechaHabilitacion)->format('d/m/Y') }}
                    </li>
                    <li class="list-group-item"><strong>Fecha de Realización:</strong>
                        {{ \Carbon\Carbon::parse($evento->fechaRealizacion)->format('d/m/Y') }}
                    </li>

                </ul>
            </div>

            <!-- Información de Beneficio -->
            <h4 class="text-secondary mt-4">Beneficio</h4>
            @if ($evento->beneficios->isNotEmpty())
                @php
                    $beneficio = $evento->beneficios->first();
                @endphp
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Detalles del Beneficio</h5>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <strong>Fecha Desde:</strong>
                            {{ \Carbon\Carbon::parse($beneficio->fechaInicioBeneficio)->format('d/m/Y') }}
                        </li>
                        <li class="list-group-item">
                            <strong>Fecha Hasta:</strong>
                            {{ \Carbon\Carbon::parse($beneficio->fechaFinBeneficio)->format('d/m/Y') }}
                        </li>
                        <li class="list-group-item">
                            <strong>Porcentaje de Descuento:</strong>
                            <span class="text-success fw-bold">{{ $beneficio->porcentaje }}%</span>
                        </li>
                    </ul>
                </div>
            @else
                <div class="alert alert-info">Este evento no tiene beneficios disponibles.</div>
            @endif

            <!-- Mostrar Tandas del Evento -->
            <h4 class="text-secondary mt-4">Tandas</h4>
            @if ($evento->tandas->isEmpty())
                <div class="alert alert-info">No hay tandas disponibles para este evento.</div>
            @else
                <ul class="list-group mb-4">
                    @foreach ($evento->tandas as $tanda)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $tanda->nombreTanda }}</strong><br>
                                Inicio: {{ \Carbon\Carbon::parse($tanda->fechaInicio)->format('d/m/Y H:i') }}<br>
                                Fin: {{ \Carbon\Carbon::parse($tanda->fechaFin)->format('d/m/Y H:i') }}
                            </div>
                            <span class="badge bg-primary">Cupos: {{ $tanda->cupos }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif

            <!-- Mostrar Tipos de Tickets -->
            <h4 class="text-secondary mt-4">Tipos de Tickets</h4>
            @if ($evento->tipoTickets->isEmpty())
                <div class="alert alert-info">No hay tickets disponibles para este evento.</div>
            @else
                <!-- Sumatoria de tickets disponibles y total de tickets -->
                @php
                    $totalTicketsDisponibles = $evento->tipoTickets->sum('cupoDisponible');
                    $totalTickets = $evento->tipoTickets->sum('cupoTotal');
                @endphp

                <ul class="list-group mb-4">
                    @foreach ($evento->tipoTickets as $ticket)
                        <li class="list-group-item">
                            <strong>{{ $ticket->categoriaTicket->nombreCatTicket }}</strong><br>
                            <strong>{{ $ticket->descripcionTipoTicket }}</strong><br>
                            Precio: <span
                                class="text-success fw-bold">${{ number_format($ticket->precioTicket, 2) }}</span><br>
                            Cupo Total: {{ $ticket->cupoTotal }} | Cupo Disponible: {{ $ticket->cupoDisponible }}
                        </li>
                    @endforeach
                </ul>

                <!-- Mostrar total de tickets y tickets disponibles -->
                <div class="alert alert-info text-center">
                    <strong>Total de Tickets:</strong> {{ $totalTickets }} |
                    <strong>Total de Tickets Disponibles:</strong> {{ $totalTicketsDisponibles }}
                </div>
            @endif --}}
