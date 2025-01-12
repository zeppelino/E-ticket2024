@extends('admin.adminMaster')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4>
                                    Mis Entradas
                                </h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                                        <li class="breadcrumb-item active">Mis Entradas</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                   <!-- Filtro de estado -->
                   <div class="mb-4">
                 {{--    <form method="GET" action="{{ route('verMisEntradas') }}">
                        <label for="idEntradas" class="form-label">Filtrar por estado del evento:</label>
                        <select name="estado" id="idEntradas" class="form-select" onchange="this.form.submit()">
                            <option value="">Disponibles</option>
                            <option value="terminado" {{ request('estado') == 'terminado' ? 'selected' : '' }}>Terminados</option>
                            <option value="suspendido" {{ request('estado') == 'suspendido' ? 'selected' : '' }}>Suspendidos</option>
                            <option value="cancelado" {{ request('estado') == 'cancelado' ? 'selected' : '' }}>Cancelados</option>
                        </select>
                    </form> --}}
                    <form method="GET" action="{{ route('verMisEntradas') }}" style="display: flex; align-items: center; gap: 10px;">
                        <label for="idEntradas" class="form-label" style="margin: 0; white-space: nowrap; font-size: 18px; font-weight: bold;">Filtrar por estado del evento:</label>
                        <select name="estado" id="idEntradas" class="form-select" style="width: auto; min-width: 150px;" onchange="this.form.submit()">
                            <option value="">Disponibles</option>
                            <option value="terminado" {{ request('estado') == 'terminado' ? 'selected' : '' }}>Terminados</option>
                            <option value="suspendido" {{ request('estado') == 'suspendido' ? 'selected' : '' }}>Suspendidos</option>
                            <option value="cancelado" {{ request('estado') == 'cancelado' ? 'selected' : '' }}>Cancelados</option>
                        </select>
                    </form>                    
                </div>

                <div class="row">
                    @if($entradasUsuario->isEmpty())
                    <p>No tienes entradas disponibles. Obtén tu primera  
                        <a href="{{ route('welcome') }}" target="_blank" rel="noopener noreferrer">entrada aquí</a>
                    </p>
                @else
                    @foreach($entradasUsuario as $entrada)       
                    <div class="col-md-6 mb-1"> <!-- Cambiado a col-md-6 para dos columnas -->
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div class="row">
                                    <!-- Imagen del evento -->
                                    <div class="col-md-3 text-center">
                                        <img src="{{ $entrada->tipoTickets->evento->urlImagen }}" alt="Imagen del evento"
                                             class="img-fluid rounded">
                                    </div>
                                    <!-- Detalles del evento -->
                                    <div class="col-md-6">
                                        <h5 class="card-title"><strong>Evento: {{ $entrada->tipoTickets->evento->nombreEvento }}</strong></h5>
                                        <p class="card-text text-muted">Categoría: {{ $entrada->tipoTickets->evento->categoria->nombreCategoria }}</p>
                                        <p class="card-text text-muted">Fecha: {{ \Carbon\Carbon::parse($entrada->tipoTickets->evento->fechaRealizacion)->format('d M Y') }}</p>
                                        <p class="card-text"><strong>Ubicación:</strong> {{ $entrada->tipoTickets->evento->ubicacion->ciudad }}, {{ $entrada->tipoTickets->evento->ubicacion->direccion }}</p>
                                        <p class="card-text text-muted">Estado del evento: {{ $entrada->tipoTickets->evento->estadoEvento }}</p>
                                        <!-- Botón para descargar la entrada en PDF -->
                                        
                                    </div>
                                    <div class="col-md-3">
                                        <div>
                                            <a href="{{ route('entradaPDF', ['idEntrada' => $entrada->idEntrada]) }}" class="btn btn-primary" target="_blank">Descargar Entrada</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
               
              
                  
    
                    <!-- Información adicional -->
                    <div class="alert alert-info">
                        <strong>Nota:</strong> Asegúrate de presentar tus entradas digitales o físicas al momento de ingresar al evento.
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
