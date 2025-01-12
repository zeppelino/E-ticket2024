@extends('admin.adminMaster')
@section('styles')
    <link href="{{ asset('backend/style/wizardCrearEvento.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('admin')
    {{-- <head>

    <meta name="csrf-token" content="{{ csrf_token() }}">

</head> --}}
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Reprogramar Evento</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.eventos') }}">Eventos</a></li>
                                <li class="breadcrumb-item active">Reprogramar Evento</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4"></h4>
                            <form id="formEvento"
                                enctype="multipart/form-data"
                                method="POST"
                                action="{{ route('guardarEventoReprogramado') }}">
                                @csrf
                                <div id="basic-pills-wizard" class="twitter-bs-wizard">
                                    <div class="wizard-flow-chart">
                                        <span class="fill">1</span>
                                        <span>2</span>
                                        <span>3</span>
                                        <span>4</span>
                                    </div>
                                        <!-- Campo oculto para el ID del evento suspendido -->
                                        <input type="hidden" name="idEventoSuspendido" value="{{ $eventoSuspendido->idEvento }}">

                                    <div class="tab-content twitter-bs-wizard-tab-content">
                                        {{-- COMIENZA  DATOS BASICOS  SECCION 1 --}}
                                            
                                        <!-- Mostrar errores de validación -->
                                            @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                                        <section>
                                            <div class="tab-pane" id="seller-details">
                                                <h3 class="text-center mb-4">Datos básicos</h3>
                                                <div class="row">
                                                    {{-- NOMBRE DEL EVENTO --}}
                                                    <div class="col-lg-3">
                                                        <div class="mb-3">
                                                            <label for="eventName" class="form-label">Nombre del
                                                                evento</label>
                                                            <input type="text" class="form-control" id="eventName"
                                                                name="eventoNombre"
                                                                placeholder="{{$eventoSuspendido->nombreEvento}}" value = "{{$eventoSuspendido->nombreEvento}}" readonly>
                                                            <span class="invalid-feedback"></span>
                                                        </div>
                                                    </div>
                                                    {{-- CATEGORIA DEL EVENTO --}}
                                                    <div class="col-lg-3">
                                                        <div class="mb-3">
                                                            <label for="idEventoCategoria" class="form-label">Categoría del
                                                                evento</label>
                                                            <select class="form-select" id="idEventoCategoria"
                                                                name="eventoCategoria" >       
                                                                    <option value="{{ $eventoSuspendido->categoria->idCategoria }}">
                                                                        {{ $eventoSuspendido->categoria->nombreCategoria }}
                                                                    </option>
                            
                                                            </select>
                                                        </div>
                                                    </div>
                                                
                                                    {{-- FECHA Y HORA DE HABILITACIÓN --}}
                                                    <div class="col-lg-3">
                                                        <div class="mb-3">
                                                            <label for="eventEnableDate" class="form-label">Fecha y hora de publicación del evento</label>

                                                            <div class="row">
                                                                <div class="col">
                                                                    {{-- Campo para la fecha, prellenado con la fecha actual --}}
                                                                    <input type="date" class="form-control" id="eventEnableDate" name="eventEnableDate" 
                                                                        value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
                                                                </div>
                                                                <div class="col">
                                                                    {{-- Campo para la hora, prellenado con una hora más de la actual --}}
                                                                    <input type="time" class="form-control" id="eventEnableTime" name="eventEnableTime" 
                                                                        value="{{ \Carbon\Carbon::now()->format('H:i') }}" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    {{-- FECHA HORA INICIO --}}
                                                    <div class="col-lg-3">
                                                        <div class="mb-3">
                                                            <label for="eventStartDate" class="form-label">Fecha y hora de
                                                                realización del evento</label>
                                                            <div class="row">
                                                                <div class="col">
                                                                    <input type="date" class="form-control"
                                                                        id="eventStartDate" name="eventStartDate" min="{{ $fechaActual }}">
                                                                </div>
                                                                <div class="col">
                                                                    <input type="time" class="form-control"
                                                                        id="eventStartTime" name="eventStartTime">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                </div>

                                                <div class="row">
                                                    {{-- PAIS --}}
                                                    <div class="col-lg-3">
                                                        <div class="mb-3">
                                                            <label for="selectPaises" class="form-label">Pais</label>
                                                            <select class="form-select" id="selectPaises" name="pais"
                                                                autocomplete="off">
                                                                <option value="{{$eventoSuspendido->ubicacion->país}}" selected>{{$eventoSuspendido->ubicacion->país}}</option>
                                                               
                                                                <!-- Aquí debes agregar las opciones de PAises -->
                                                            </select>
                                                        </div>
                                                    </div>
                                                    {{-- PROVINCIA --}}
                                                    <div class="col-lg-3">
                                                        <div class="mb-3">
                                                            <label for="selectProvincias"
                                                                class="form-label">Provincia</label>
                                                            <select class="form-select" id="selectProvincias"
                                                                name="provincia">
                                                                <option value="{{$eventoSuspendido->ubicacion->provincia}}" selected>{{$eventoSuspendido->ubicacion->provincia}}</option>
                                                                <!-- Aquí debes agregar las opciones de provincias -->
                                                            </select>
                                                        </div>
                                                    </div>
                                                    {{-- LOCALIDAD --}}
                                                    <div class="col-lg-3">
                                                        <div class="mb-3">
                                                            <label for="selectLocalidades"
                                                                class="form-label">Localidad</label>
                                                            <select class="form-select" id="selectLocalidades"
                                                                name="localidad">
                                                                <option value="{{$eventoSuspendido->ubicacion->ciudad}}" selected>{{$eventoSuspendido->ubicacion->ciudad}}</option>
                                                                <!-- Aquí debes agregar las opciones de localidades -->
                                                            </select>
                                                        </div>
                                                    </div>
                                                    {{-- DIRECCION --}}
                                                    <div class="col-lg-3">
                                                        <div class="mb-3">
                                                            <label for="idDireccion" class="form-label">Dirección</label>
                                                            <input type="text" class="form-control" id="idDireccion"
                                                                name="direccionEvento"
                                                                placeholder="{{$eventoSuspendido->ubicacion->direccion}}", value ="{{$eventoSuspendido->ubicacion->direccion}}" readonly>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="row">
                                                    {{-- FOTO EVENTO --}}
                                                    <div class="col-lg-4">
                                                    <div class="form-group mb-3">
                                                        <label for="idEventoImagen" class="form-label">Imagen del evento</label>
                                                        <input name="eventoImagen" class="form-control" type="file" id="idEventoImagen" onChange="mainThamUrl(this)">
                                                        <!-- Vista previa de la imagen existente si está disponible -->
                                                        @if($eventoSuspendido->urlImagen)
                                                            <img src="{{ asset($eventoSuspendido->urlImagen) }}" alt="Imagen Actual" style="max-width: 100px; margin-top: 10px;">
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    {{-- DESCRICPCION DEL EVENTO --}}
                               
                                                <label for="eventDescription" class="form-label">Descripción del evento</label>
                                                    <textarea class="form-control" id="eventDescription" name="eventDescription" rows="4" placeholder="Agrega más detalles...">{{ trim($eventoSuspendido->descripcionEvento) }}
                                                    </textarea>

                                            </div>
                                            {{-- <div class="row button-row"> --}}
                                            <div class="d-flex justify-content-end mt-3">
                                                <button class="btn btn-primary" type="button"
                                                    onClick="validate(this)" id="btnSigDatosBasicos" disabled>Siguiente</button>
                                            </div>
                                        </section>


                                        {{-- COMIENZA TICKETS SECCION 2 --}}

                                        <section class="display-none">
                                            <!-- Boton que sirve unicamente para silenciar error de JS (tierra abajo de la alfombra) -->
                                            <button type="button" class="btn btn-outline-primary" id="agregarTicket" style="background: transparent; border: none; width: 0; height: 0; padding: 0; display: inline-block;"
                                            disable>
                                            </button>
                                            <div class="tab-pane" id="company-document">
                                                <h3 class="text-center mb-4">Tickets</h3>
                                                <div>
                                                    {{-- BOTÓN SWITCH --}}
                                                    <div class="row mb-3">
                                                        <div class="col-lg">
                                                            <p class="fs-3">Total de tickets: <span class="totalCantidad">0</span></p>
                                                        </div>

                                                    </div>
                  
                                                    {{-- Contenedor para las entradas de tickets --}}
                                                    <div id="ticketsContainer" class="mb-3">
                                                        <!-- Itera sobre los tickets del evento suspendido -->
                                                        @foreach ($eventoSuspendido->tipoTickets as $key => $ticket)
                                                            <div class="ticket-field-set mb-3" id="ticket-{{ $key + 1 }}">
                                                                <div class="row g-3 align-items-end">
                                                                    <div class="col-md-2">
                                                                        <label for="ticketType_{{ $key + 1 }}" class="form-label">Tipo de Ticket</label>
                                                                        <select class="form-select item-select" id="ticketType_{{ $key + 1 }}" name="ticketType[]">
                                                                                <option value="{{ $ticket->categoriaTicket->idCatTicket }}">
                                                                                    {{ $ticket->categoriaTicket->nombreCatTicket }}
                                                                                </option>
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-md-2">
                                                                        <label for="ticketPrice_{{ $key + 1 }}" class="form-label">Precio</label>
                                                                        <input type="number" class="form-control" id="ticketPrice_{{ $key + 1 }}" name="ticketPrice[]"
                                                                            value="{{ $ticket->precioTicket }}" placeholder="{{ $ticket->precioTicket }}" min="0" step="0.01" readonly>
                                                                    </div>

                                                                    <div class="col-md-2">
                                                                        <label for="ticketQuantity_{{ $key + 1 }}" class="form-label">Cantidad</label>
                                                                        <input type="number" class="form-control" id="ticketQuantity_{{ $key + 1 }}" name="ticketQuantity[]"
                                                                            value="{{ $ticket->cupoTotal }}" placeholder="{{ $ticket->cupoTotal }}" min="0" readonly>
                                                                    </div>

                                                                    <div class="col-md-4">
                                                                        <label for="ticketDescripcion_{{ $key + 1 }}" class="form-label">Descripción</label>
                                                                        <textarea class="form-control" name="ticketDescription[]" id="ticketDescripcion_{{ $key + 1 }}" rows="1"
                                                                            placeholder="Agrega una descripción">{{ $ticket->descripcionTipoTicket }}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>

                                                </div>
                                            </div>
                                            {{--  <div class="row button-row"> --}}
                                            <div class="d-flex justify-content-end mt-2">
                                                <button class="btn btn-primary me-2" type="button"
                                                    onClick="showPrevious(this)">Anterior</button>
                                                <button class="btn btn-primary" type="button"
                                                    onClick="validate(this)">Siguiente</button>
                                            </div>
                                        </section>


                                        {{-- COMIENZA TANDAS SECCION 3 --}}
                                        <section class="display-none">
                                            <!-- Dato oculto para no validar las tandas -->
                                            <input type="hidden" name="cupoDisponible" value="{{ $eventoSuspendido -> tipoTickets() -> sum('cupoDisponible') }}">
                                            @if ($eventoSuspendido -> tipoTickets() -> sum('cupoDisponible') != 0)
                                            <div class="tab-pane" id="bank-detail">

                                               {{--  <div class="container"> --}}
                                                    <h3 class="text-center mb-4">Tandas</h3>
                                                    
                                                    <div class="row mb-2 align-items-end">

                                                        <div class="col-md-4">
                                                            <p class="fs-3">Total máximo de tandas : <span>4</span></p>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <p class="fs-3">Total de tickets: <span class="totalCantidad">0</span></p>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <p class="fs-3">Total de tickets distribuidos: <span class="totalCantDistri" style="color: red;">0</span></p>
                                                        </div>
                                                    </div>
                                                    <!-- Contenedor para las tandas -->
                                                    <div id="tandasContainer">
                                                        <!-- Primera tanda por defecto -->
                                                        <div class="tanda mb-3" id="tanda-1">
                                                            <div class="row align-items-end">
                                                                <div class="col-md-3">
                                                                    <label for="nombre_tanda_1" class="form-label">Nombre
                                                                        de
                                                                        Tanda</label>
                                                                    <input type="text" class="form-control"
                                                                        id="nombre_tanda_1" name="nombre_tanda[]"
                                                                        value="Tanda 1" readonly>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <label for="fecha_inicio_tanda_1"
                                                                        class="form-label">Fecha
                                                                        de
                                                                        Inicio</label>
                                                                    <input type="datetime-local" class="form-control"
                                                                        id="fecha_inicio_tanda_1"
                                                                        name="fecha_inicio_tanda[]" min="{{ $fechaHoraActual }}">
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <label for="fecha_fin_tanda_1"
                                                                        class="form-label">Fecha de
                                                                        Fin</label>
                                                                    <input type="datetime-local" class="form-control"
                                                                        id="fecha_fin_tanda_1" name="fecha_fin_tanda[]" min="{{ $fechaHoraActual }}">
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label for="cupo_tanda_1"
                                                                        class="form-label">Cupo/Entradas</label>
                                                                    <input type="number" class="form-control ticket-input"
                                                                        id="cupo_tanda_1" name="cupo_tanda[]"
                                                                        placeholder="Ejemplo: 50" min="1" value="1" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Botón para agregar más tandas -->
                                                    <div class="d-grid gap-2">
                                                        <button type="button" class="btn btn-outline-primary"
                                                            id="agregarTanda">Agregar Otra Tanda</button>
                                                    </div>
                                              {{--   </div> --}}
                                            </div>
                                            <div class="d-flex justify-content-end mt-3">
                                                <button class="btn btn-primary me-2" type="button"
                                                    onClick="showPrevious(this)">Anterior</button>
                                                <button class="btn btn-primary" type="button" id="nextButton" 
                                                    onClick="validate(this)" disabled>Siguiente</button>
                                            </div>
                                            @else
                                            <!-- Boton que sirve unicamente para silenciar error de JS (tierra abajo de la alfombra) -->
                                            <button type="button" class="btn btn-outline-primary" id="agregarTanda" style="background: transparent; border: none; width: 0; height: 0; padding: 0; display: inline-block;"
                                            disabled>
                                            </button>

                                            <div class="tab-pane" id="bank-detail">

                                               {{--  <div class="container"> --}}
                                                    <h3 class="text-center mb-4">Tandas</h3>
                                                    
                                                    <div class="row mb-2 align-items-end">

                                                        <div class="col-md-6">
                                                            <p class="fs-3">Evento agotado. No hay tandas para reprogramar.</p>
                                                        </div>
                                                    </div>
                                              {{--   </div> --}}
                                            </div>
                                            <div class="d-flex justify-content-end mt-3">
                                                <button class="btn btn-primary me-2" type="button"
                                                    onClick="showPrevious(this)">Anterior</button>
                                                <button class="btn btn-primary" type="button" id="nextButton" 
                                                    onClick="showNextWizardSection(this.closest('section'))">Siguiente</button>
                                            </div>
                                            @endif
                                        </section>


                                        {{-- MENSAJE DE CONFIRMACIÓN DE EVENTO CREADO SECCION 4 --}}

                                        <section class="display-none">
                                            <div class="tab-pane" id="confirm-detail">
                                                <div class="row justify-content-center">
                                                    <div class="col-lg-6">
                                                        <div class="text-center">
                                                            <div class="mb-4">
                                                                <i
                                                                    class="mdi mdi-check-circle-outline text-success display-4"></i>
                                                            </div>
                                                            <div>
                                                                <h5>Se completo el formulario
                                                                    correctamente</h5>
                                                                <p class="text-muted">Reprograme el evento para guardarlo</p>
                                                                <button type="submit" class="btn btn-success btn-lg"
                                                                    id="reprogramarEvento">Reprogramar
                                                                    Evento</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-end mt-3">
                                                <button class="btn btn-primary" type="button"
                                                    onClick="showPrevious(this)">Anterior</button>
                                            </div>

                                        </section>

                                    </div>

                                </div>{{-- FIN WIZARD --}}
                            </form>
                        </div>
                    </div>
                </div>

            </div>
            <!-- end row -->

        </div>
    </div>
@endsection

@section('scripts')
    <!--  JS PARA Reprogamar EVENTO -->
<script src="{{ asset('backend/js/reprogramarEvento.js') }}"></script>

<script>

//variable utilizada en creacion de tickets
//window.catTicketsCantidad = {{ $catTicketsCantidad }};
$(document).ready(function() {

// Configurar el token CSRF para todas las solicitudes AJAX
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('#formEvento').on('submit', function(event) {
    event.preventDefault(); // Evitar el envío normal del formulario
    $('#reprogramarEvento').prop('disabled', true); // Desactivar el botón

    var formData = new FormData(this); // Obtener los datos del formulario, incluyendo la imagen

    $.ajax({
        url: "{{ route('guardarEventoReprogramado') }}", // Cambia esta URL a tu ruta
        type: 'POST',
        data: formData,
        processData: false, // Importante para evitar que jQuery procese los datos
        contentType: false, // Importante para permitir el envío de archivos
        success: function(response) {
            // Mostrar SweetAlert con la respuesta
            Swal.fire({
                title: 'Éxito',
                text: response.message,
                icon: 'success',
                confirmButtonColor: "#0f9cf3",
                confirmButtonText: 'Aceptar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#crearEvento').prop('disabled', false); // Reactivar el botón
                    window.location.href = "{{ route('admin.eventos') }}"; // Cambia esta URL a donde deseas redirigir
                }
            });
        },
        error: function(xhr, status, error) {
            // Manejar errores
            Swal.fire({
                title: 'Error',
                text: 'Ocurrió un problema al crear el evento.',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                $('#crearEvento').prop('disabled', false); // Reactivar el botón en caso de error
            });
        }
    });
});
});


/*=============================================
CODIGO PARA LOS TICKETS
==============================================*/
var esGratis = false;

document.addEventListener("DOMContentLoaded", function() {
    
    let ticketCount = 1; // Inicialmente hay una entrada
    let inputCount = 0;
    const maxInputs = {{ $catTicketsCantidad }};//window.catTicketsCantidad;

    let precioTicket = {{ $ticket->precioTicket ?? 0 }};
    if (precioTicket === 0) {
        esGratis = true;
        //enableFreeOption();  
        document.getElementById('agregarTanda').disabled = true;
    }

    //console.log("es gratis:" ,esGratis);

    // Función para deshabilitar opciones seleccionadas
    function loadSelects() {
        const allSelects = document.querySelectorAll('.item-select');
        const selectedValues = [];

        // Recorrer todos los selects y obtener las opciones seleccionadas
        allSelects.forEach(select => {
            const selectedValue = select.value;
            if (selectedValue) {
                selectedValues.push(selectedValue);
            }
        });

        // Recorrer nuevamente los selects para deshabilitar las opciones seleccionadas
        allSelects.forEach(select => {
            const options = select.querySelectorAll('option');
            options.forEach(option => {
                if (selectedValues.includes(option.value) && option.value !== select.value) {
                    option.disabled = true;
                } else {
                    option.disabled = false;
                }
            });
        });
    }

    // Función para actualizar los nombres de los tickets
    function actualizarNombresDeTickets() {
        const tickets = document.querySelectorAll(".ticket-field-set");
        tickets.forEach((ticket, index) => {
            ticket.querySelector('select[name="ticketType[]"]').id = `ticketType_${index + 1}`;
            ticket.querySelector('input[name="ticketPrice[]"]').id = `ticketPrice_${index + 1}`;
            ticket.querySelector('input[name="ticketQuantity[]"]').id = `ticketQuantity_${index + 1}`;
            ticket.querySelector('textarea[name="ticketDescription[]"]').id = `ticketDescription_${index + 1}`;
        });
    }

    // Función para desactivar la opción "Gratuito" en todos los selects
   /*  function disableFreeOption() {
        document.querySelectorAll('.item-select option').forEach(function(option) {
            if (option.text.trim() === 'Gratis') {
                option.disabled = true; // Desactivar opción "Gratuito"
            }
        });
    } */

    // Función para activar opción "Gratuito"
    function enableFreeOption() {
        document.querySelectorAll('.item-select option').forEach(function(option) {
            if (option.text.trim() === 'Gratis') {
                option.disabled = false; 
            }
        });
    }

    // Función para eliminar todos los tickets excepto el primero
    function clearAllTicketsExceptFirst() {
        const tickets = document.querySelectorAll('.ticket-field-set');
        for (let i = 1; i < tickets.length; i++) {
            tickets[i].remove();
        }
        inputCount = 0; // Restablecer el contador de entradas
        // Mostrar la suma total en el elemento con id "totalCantidad"
        document.querySelector('.totalCantidad').textContent = inputCount;
        //disableFreeOption(); // Desactivar opción gratuita después de eliminar
        //loadSelects(); // Actualizar select para eliminar opciones no disponibles
    }

    function toggleFreeTicket(isFree) {
        var ticketTypeSelect = document.getElementById('ticketType_1');
        var ticketPriceInput = document.getElementById('ticketPrice_1');
        var ticketCantidadInput = document.getElementById('ticketQuantity_1');
        
        if (isFree) {
            //opcion gratuita
            ticketTypeSelect.value = 4;
            ticketPriceInput.value = 0; // Asignar 0 al precio
            ticketPriceInput.classList.add('readonly-select');
            ticketCantidadInput.value = ''; // Vaciar cantidad
            ticketTypeSelect.disabled = false; // Habilitar opción "Gratuito"
            ticketTypeSelect.classList.add('readonly-select');
        } else {
            //opcion de pago
            inputCount = 0; // Restablecer el contador de entradas
            // Mostrar la suma total en el elemento con id "totalCantidad"
            document.querySelector('.totalCantidad').textContent = inputCount;
            ticketTypeSelect.selectedIndex = 0; // Restablecer la selección por defecto
            ticketPriceInput.value = ''; // Vaciar el campo de precio
            ticketPriceInput.disabled = false; // Habilitar el campo de precio
            ticketCantidadInput.value = ''; // Vaciar cantidad
            ticketTypeSelect.classList.remove('readonly-select'); // Remover clase de bloqueo
            ticketPriceInput.classList.remove('readonly-select');
        }
    }
    //funcion para eliminar todas las tandas excepto la primera
    function clearAllTandasExceptFirst() {
        const tandas = document.querySelectorAll('.tanda'); // Selecciona todos los elementos de tanda
        for (let i = 1; i < tandas.length; i++) {
            tandas[i].remove();
        }

        tandaCount = 1; // Inicialmente hay una tanda
        //checkDistribution();
        //document.querySelector('.totalCantidad').textContent = inputCount; // Actualiza el total en pantalla
    }

    /*=======================
    AGREGAR TICKET
    =========================*/

    document.getElementById("agregarTicket").addEventListener("click", function() {
        
        inputCount++;
        ticketCount++;

        const ticketContainer = document.createElement("div");
        ticketContainer.classList.add("ticket-field-set", "mb-3");
        ticketContainer.id = `ticket-${ticketCount}`;

        ticketContainer.innerHTML = `
        <div class="row g-3 align-items-end">
            <div class="col-md-2">
                <label for="ticketType_${ticketCount}" class="form-label">Tipo de Ticket *</label>
                <select class="form-select item-select ticket-select" id="ticketType_${ticketCount}" name="ticketType[]">
                        <option value="" selected>Seleccione el tipo de ticket</option>
                        @foreach ($catTickets as $catTicket)
                        <option value="{{ $catTicket->idCatTicket }}">{{ $catTicket->nombreCatTicket }}
                        </option>
                        @endforeach
                </select>
            </div>
            <div class="col-md-2">
                 <label for="ticketPrice_${ticketCount}" class="form-label">Precio *</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                    <input type="number" class="form-control" id="ticketPrice_${ticketCount}" name="ticketPrice[]"
                    placeholder="Ej. 100" min="0" step="0.01">
                </div>
            </div>
            <div class="col-md-2">
                <label for="ticketQuantity_${ticketCount}" class="form-label">Cantidad *</label>
                <input type="number" class="form-control" id="ticketQuantity_${ticketCount}" name="ticketQuantity[]"
                    placeholder="Ej. 50" min="0" required>
            </div>
            <div class="col-md-4">
                <label for="ticketDescription_${ticketCount}" class="form-label">Descripción *</label>
                <textarea class="form-control" id="ticketDescription_${ticketCount}" name="ticketDescription[]"
                    placeholder="Agrega una descripción" rows="1"></textarea>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger btn-sm eliminarTicket ri-delete-bin-line"></button>
            </div>
        </div>`;

        document.getElementById("ticketsContainer").appendChild(ticketContainer);  


        /*========================
        ELIMINAR TICKET
        ========================*/
        ticketContainer.querySelector(".eliminarTicket").addEventListener("click", function() {
            document.getElementById("agregarTicket").disabled = false;
            actualizarNombresDeTickets(); 
            ticketContainer.remove();
            ticketCount--;
            inputCount--;
            loadSelects();
            //disableFreeOption();
        });

        // Deshabilitar el botón si se llegó al límite de tickets
        if (inputCount >= maxInputs-2) {// se descuenta gratuito y el que ya existe por defecto
            document.getElementById("agregarTicket").disabled = true;
        } 

        loadSelects();
        //disableFreeOption();

    });// fin click agregar ticket

    // Escuchar cambios en los selects para actualizar la lista de opciones disponibles
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('ticket-select')) {
            loadSelects(); // Actualizar los selects cuando se selecciona un valor
            //disableFreeOption();
        }
    });

    loadSelects();
    //disableFreeOption();
});// fin creacion tickets


    $(document).ready(function() {
    // Llamar a la función para actualizar el total al cargar la página
    actualizarSumaDeCantidad();
});

    /*=======================================
    MOSTRAR CANTIDAD TOTAL DE TICKETS
    =======================================*/

    var totalTickets = 0;

    function actualizarSumaDeCantidad() {  
    let totalCantidad = 0;

        // Recorrer todos los inputs de cantidad
        $('input[name="ticketQuantity[]"]').each(function() {
            // Asegurarse de que el valor sea un número (maneja inputs vacíos)
            let cantidad = parseInt($(this).val()) || 0;
            totalCantidad += cantidad;
        });

        totalTickets = totalCantidad;

        // Mostrar la suma total en el elemento con id "totalCantidad"
        $('.totalCantidad').text(totalCantidad);

    }

    // Detectar cuando el valor de un input ticketQuantity cambia
    $(document).on('input', 'input[name="ticketQuantity[]"]', function() {
        actualizarSumaDeCantidad();
    });

    // Llamar a la función cuando se elimine un ticket para recalcular la suma
    $(document).on('click', '.eliminarTicket', function() {
        actualizarSumaDeCantidad();
    });

    /*==========================================
    VALIDAR CANTIDAD DE TICKETS EN LAS TANDAS
    ==========================================*/

    // Función para verificar la distribución
    function checkDistribution() {
        
        var sum = 0;
        // Sumar las cantidades ingresadas en los inputs
        $('.ticket-input').each(function() {
            let value = parseInt($(this).val()) || 0; // Obtener el valor del input, o 0 si está vacío
            sum += value;

            // Mostrar la suma total en el elemento con id "totalCantidad"
            $('.totalCantDistri').text(sum);
        });

        // Verificar si la suma es igual al total
        if (sum === totalTickets) {

            $('#nextButton').prop('disabled', false); // Habilitar el botón
            $('.totalCantDistri').css('color', 'green');
            
            let cupoDisponible = {{ $eventoSuspendido->tipoTickets()->sum('cupoDisponible') }};

            if (cupoDisponible !== 0) {
                Swal.fire({
                title: "Tickets distribuidos",
                text: "Todos los tickets estan distribuidos",
                icon: "success",
                confirmButtonColor: "#0f9cf3",
                confirmButtonText: "Cerrar"
                });
            } 
            
        } else {
            $('#nextButton').prop('disabled', true); // Deshabilitar
            $('.totalCantDistri').css('color', 'red');
        }
    }

    // Ejecutar la verificación al cambiar los valores de los inputs
    $(document).on('input change', '.ticket-input', function() { 
        checkDistribution();
    });

    </script>
@endsection
