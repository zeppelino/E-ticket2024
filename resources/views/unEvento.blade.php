@extends('layouts.header')

@section('content')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Botón para volver -->
    <div class="container mt-5">
        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('welcome') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
        </div>

        {{-- aca cambiar el src cuando esten las imagenes del evento en la base --}}
        <div class="d-flex align-items-center mb-4">
            <!-- Foto del evento -->
            <div class="flex-shrink-0">
                <img src="{{ asset($evento->urlImagen) }}" alt="Foto del Evento" class="img-fluid rounded shadow"
                    style="max-width: 150px; height: auto;">
            </div>

            <!-- Nombre del evento -->
            <div class="ms-4">
                <h1 class="display-5 fw-bold">{{ $evento->nombreEvento }}</h1>
                <p class="text-muted">{{ $evento->categoria->nombreCategoria }}</p>
            </div>
        </div>

        {{-- Mensaje si el evento ya termino --}}
        @if ($evento->estadoEvento == 'terminado')
            <div class="card mb-4 shadow-sm">
                <div class="card-body text-center">
                    <h1 class="card-title" style="color: red; font-size: 2.5rem;">EVENTO TERMINADO</h1>
                </div>
            </div>
        @endif
        @if ($evento->estadoEvento == 'suspendido')
            <div class="card mb-4 shadow-sm">
                <div class="card-body text-center">
                    <h1 class="card-title" style="color: red; font-size: 2.5rem;">EVENTO SUSPENDIDO</h1>
                </div>
            </div>
        @endif
        @if (!$entradasDisponibles)
            <div class="card mb-4 shadow-sm">
                <div class="card-body text-center">
                    <h1 class="card-title" style="color: red; font-size: 2.5rem;">ENTRADAS AGOTADAS</h1>
                </div>
            </div>
        @endif

        <!-- Descripción del evento -->
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Descripción</h5>
                <p class="card-text">{{ $evento->descripcionEvento }}</p>
            </div>
        </div>

        <!-- Tipos de entrada y precios -->
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Tipos de Tickets</h5>
                <ul class="list-group list-group-flush">
                    @foreach ($evento->tipoTickets as $ticket)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>{{ $ticket->categoriaTicket->nombreCatTicket }}</span>
                            <span
                                class="badge bg-success rounded-pill">${{ number_format($ticket->precioTicket, 2) }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Fecha y hora del evento -->
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Fecha y Hora</h5>
                <p class="card-text">
                    <i class="bi bi-calendar3"></i>
                    {{ \Carbon\Carbon::parse($evento->fechaRealizacion)->translatedFormat('d \d\e F \d\e Y') }} <br>
                    <i class="bi bi-clock"></i> {{ \Carbon\Carbon::parse($evento->fechaRealizacion)->format('H:i') }} hs
                </p>
            </div>
        </div>

        <!-- Ubicación del evento -->
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Ubicación</h5>
                <p class="card-text">
                    <i class="bi bi-geo-alt"></i> {{ $evento->ubicacion->país }} <br>
                    {{ $evento->ubicacion->provincia }}
                    <i class="bi bi-geo-alt"></i> {{ $evento->ubicacion->ciudad }} <br>
                    {{ $evento->ubicacion->direccion }}
                </p>
            </div>
        </div>


        <!-- Botón para inscribirse en la lista de espera -->
        <div class="text-center mb-5">
            @if ($evento->estadoEvento !== 'terminado' && $evento->estadoEvento !== 'suspendido' && $entradasDisponibles)
                <a href="{{ route('listaEspera') }}" class="btn btn-warning btn-lg px-5" data-bs-toggle="modal"
                    data-bs-target="#listaEsperaModal">Inscribirse en Lista de Espera</a>
            @endif
        </div>
    </div>

    <!-- Modal -->

    <div class="modal fade" id="listaEsperaModal" tabindex="-1" aria-labelledby="listaEsperaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-custom text-white">
                <div class="modal-header border-0">
                    <h3 class="modal-title text-center w-100" id="listaEsperaModalLabel">INSCRIPCIÓN</h3>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p><strong>Debe tener un email registrado para continuar con la inscripción.</strong></p>
                    <p>En caso de suspensión del evento, se le notificará que debe realizar nuevamente la inscripción.</p>
                    <p>Si ya compró su entrada, se le notificará con la nueva información de reprogramación o cancelación.
                    </p>
                    <p><strong class="text-white">En caso de cancelación del evento, se le notificará.</strong></p>

                    <form action="{{ route('notificacionListaEspera') }}" method="POST" name="formInscripcion">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Ingrese su email para ser notificado:</label>
                            <input type="email" class="form-control bg-secondary text-white text-center" name="email"
                                id="email" placeholder="ejemplo@correo.com" required style="border-radius: 20px;">

                            <input type="hidden" name="idEvento" value='{{ $evento->idEvento }}'>
                        </div>

                        @if ($errors->has('idEvento'))
                            <span class="text-danger"
                                style="border: 1px solid red; padding: 5px; border-radius: 5px; display: inline-block;"><strong>{{ $errors->first('idEvento') }}</strong></span>
                        @endif

                        @if ($errors->has('email'))
                            <span class="text-danger"
                                style="border: 1px solid red; padding: 5px; border-radius: 5px; display: inline-block;"><strong>{{ $errors->first('email') }}</strong></span>
                        @endif

                        @if (session('success'))
                            <p class="text-success"
                                style="border: 1px solid green; padding: 5px; border-radius: 5px; display: inline-block;">
                                <strong>{{ session('success') }}</strong></p>
                        @endif



                        <div class="modal-footer border-0 justify-content-center">
                            {{--  <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button> --}}
                            <button type="submit" class="btn btn-primary">Confirmar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    {{-- <div class="modal fade" id="listaEsperaModal" tabindex="-1" aria-labelledby="listaEsperaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="listaEsperaModalLabel">Inscripción en Lista de Espera</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p> <strong> Debera tener un email registrado para continuar con la inscripción.</strong></p>
                <p>En caso de suspensión del evento, se le notificará que debe realizar nuevamente la inscripción.</p>
                <p>Si ya compró su entrada, se le notificará con la nueva información de reprogramación o cancelación.</p>
                <p class="text-muted">En caso de cancelación del evento, se le notificará.</p>

              
                        
                <form action="{{ route('notificacionListaEspera') }}" method="POST" name="formInscripcion">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Ingrese su email para ser notificado:</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="ejemplo@correo.com" required>
                        
                        <!-- Campo oculto para el ID del evento -->
                        <input type="hidden" name="idEvento" value='{{ $evento->idEvento}}'>
                        
                    </div>

                    @if ($errors->has('idEvento'))
                    <span class="text-danger">{{ $errors->first('idEvento') }}</span>
                    @endif

                    <!-- Mostrar errores de validación -->
                    @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif

                    <!-- Mensaje de éxito después de la inscripción -->
                    @if (session('success'))
                        <p class="text-success">{{ session('success') }}</p>
                    @endif

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Confirmar</button>
                    </div>
                </form>

                  

            </div>
           
        </div>
    </div>
</div> --}}


    <script>
        $(document).ready(function() {
            // Mostrar el modal si la sesión 'show_modal' está activa
            @if (session('show_modal'))
                $('#listaEsperaModal').modal('show');
                {{ session()->forget('show_modal') }} /* <!-- Limpia la sesión --> */
            @endif
        });
    </script>
@endsection()
