@extends('admin.adminMaster')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4>
                            Reportes
                        </h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
                                <li class="breadcrumb-item active">Reportes</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">


                            <!-- Filtros de Reportes -->
                            <form method="GET" action="{{ route('reportePDF') }}" class="mb-4" target="_blank"
                                name="nameReporteForm" id="reporteForm">
                                @csrf
                                <div class="mb-4">
                                    <div class="row mb-3">
                                        <!-- Tipo de Reporte -->
                                        <div class="col-md-4 mb-3">
                                            <label for="tipo_reporte" class="form-label">Tipo de Reporte</label>
                                            <select class="form-select form-select-sm" id="tipo_reporte"
                                                name="tipo_reporte">
                                                <option value="anual">Reporte por años</option>
                                                <option value="entradas">Entradas Vendidas/No Vendidas</option>
                                            </select>
                                        </div>

                                        <!-- Fecha Desde -->
                                        <div class="col-md-2 mb-3">
                                            <label for="fecha_desde" class="form-label">Desde</label>
                                            <input type="date" class="form-control form-control-sm" id="fecha_desde"
                                                name="fecha_desde" required>
                                        </div>

                                        <!-- Fecha Hasta -->
                                        <div class="col-md-2 mb-3">
                                            <label for="fecha_hasta" class="form-label">Hasta</label>
                                            <input type="date" class="form-control form-control-sm" id="fecha_hasta"
                                                name="fecha_hasta" required>
                                            <small id="dateError" class="text-danger" style="display: none;">La fecha
                                                "Hasta" no puede ser menor que la fecha "Desde".</small>
                                        </div>

                                        <!-- Botón de Exportar a PDF -->
                                        <div class="col-md-4 d-flex align-items-center">
                                            <div class="text-center mt-3">
                                                <button type="submit" class="btn btn-primary">Descargar PDF</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>


                            <!-- Tablas de Visualización del Reporte -->
                            <div class="table-responsive" id="divAnual">
                                <table class="table table-bordered table-striped tablaReporte" id="tablaAnual">
                                    <thead class="table-info">
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
                                                <td>{{ \Carbon\Carbon::parse($evento->fechaRealizacion)->format('d/m/Y') }}
                                                </td>
                                                <td>{{ $evento->categoria->nombreCategoria ?? 'N/A' }}</td>
                                                <td>{{ $evento->nombreEvento }}</td>
                                                <td>{{ $evento->ubicacion->direccion ?? 'N/A' }},
                                                    {{ $evento->ubicacion->ciudad ?? 'N/A' }}</td>

                                                <!-- Suma del cupoTotal de los tipoTickets -->
                                                <td class="text-end">{{ $evento->tipoTickets->sum('cupoTotal') }}</td>
                                                <!-- Total de entradas -->

                                                <!-- Entradas Vendidas -->
                                                <td class="text-end">
                                                    {{ $evento->tipoTickets->sum(function ($tipoTicket) {
                                                        return $tipoTicket->cupoTotal - $tipoTicket->cupoDisponible;
                                                    }) }}
                                                </td>

                                                <!-- Entradas No Vendidas -->
                                                <td class="text-end">{{ $evento->tipoTickets->sum('cupoDisponible') }}</td>

                                                <td class="text-end">{{ $evento->cancelados ?? 0 }}</td>
                                                <!-- aca poner cuantos quisieron comprar pero no pudieron -->
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>

                            <!-- Tabla para Entradas Vendidas/No Vendidas -->
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
                                                <td>{{ $evento->nombreEvento }}</td>
                                                <td class="text-end">
                                                    {{ $evento->tipoTickets->sum(function ($tipoTicket) {
                                                        return $tipoTicket->cupoTotal - $tipoTicket->cupoDisponible;
                                                    }) }}
                                                </td>
                                                <td class="text-end">{{ $evento->tipoTickets->sum('cupoDisponible') }}</td>
                                                <td class="text-end">{{ $evento->cancelados ?? 0 }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('scripts')
        <!--  JS PARA  REPORTES -->
        {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}

        <script src="{{ asset('backend/js/reportes.js') }}"></script>
    @endsection
