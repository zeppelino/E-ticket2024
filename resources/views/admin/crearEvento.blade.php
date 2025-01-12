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
                        <h4 class="mb-sm-0">Crear Evento</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.eventos') }}">Eventos</a></li>
                                <li class="breadcrumb-item active">Crear Evento</li>
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
                            {{--=========================
                                    FORMULARIO
                             ==========================--}}
                            <form id="formEvento" enctype="multipart/form-data">
                                @csrf
                                <div id="basic-pills-wizard" class="twitter-bs-wizard">
                                    <div class="wizard-flow-chart">
                                        <span class="fill">1</span>
                                        <span>2</span>
                                        <span>3</span>
                                        <span>4</span>
                                    </div>

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
                                                                evento *</label>
                                                            <input type="text" class="form-control" id="eventName"
                                                                name="eventoNombre"
                                                                placeholder="Introduce el nombre del evento">
                                                            <span class="invalid-feedback"></span>
                                                        </div>
                                                    </div>
                                                    {{-- CATEGORIA DEL EVENTO --}}
                                                    <div class="col-lg-3">
                                                        <div class="mb-3">
                                                            <label for="idEventoCategoria" class="form-label">Categoría del
                                                                evento *</label>
                                                            <select class="form-select" id="idEventoCategoria"
                                                                name="eventoCategoria">
                                                                <option selected disabled>Selecciona la categoría</option>
                                                                @foreach ($categorias as $categoria)
                                                                    <option value="{{ $categoria->idCategoria }}">
                                                                        {{ $categoria->nombreCategoria }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    {{-- FECHA HORA HABILITACION --}}
                                                    <div class="col-lg-3">
                                                        <div class="mb-3">
                                                            <label for="eventEnableDate" class="form-label">Fecha y hora de
                                                                publicación del evento *</label>
                                                            <div class="row">
                                                                <div class="col">
                                                                    <input type="date" class="form-control"
                                                                        id="eventEnableDate" name="eventEnableDate" min="{{ $fechaActual }}">
                                                                </div>
                                                                <div class="col">
                                                                    <input type="time" class="form-control"
                                                                        id="eventEnableTime" name="eventEnableTime">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- FECHA HORA INICIO --}}
                                                    <div class="col-lg-3">
                                                        <div class="mb-3">
                                                            <label for="eventStartDate" class="form-label">Fecha y hora de
                                                                realización del evento *</label>
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
                                                            <label for="selectPaises" class="form-label">Pais *</label>
                                                            <select class="form-select" id="selectPaises" name="pais"
                                                                autocomplete="off">
                                                                <option value="" selected>Selecciona el pais</option>
                                                                @foreach ($paises as $pais)
                                                                    <option value="{{ $pais->id }}">{{ $pais->name }}
                                                                    </option>
                                                                @endforeach
                                                                <!-- Aquí debes agregar las opciones de PAises -->
                                                            </select>
                                                        </div>
                                                    </div>
                                                    {{-- PROVINCIA --}}
                                                    <div class="col-lg-3">
                                                        <div class="mb-3">
                                                            <label for="selectProvincias"
                                                                class="form-label">Provincia *</label>
                                                            <select class="form-select" id="selectProvincias"
                                                                name="provincia">
                                                                <option value="" selected>Selecciona la provincia</option>
                                                                <!-- Aquí debes agregar las opciones de provincias -->
                                                            </select>
                                                        </div>
                                                    </div>
                                                    {{-- LOCALIDAD --}}
                                                    <div class="col-lg-3">
                                                        <div class="mb-3">
                                                            <label for="selectLocalidades"
                                                                class="form-label">Localidad *</label>
                                                            <select class="form-select" id="selectLocalidades"
                                                                name="localidad">
                                                                <option value="" selected>Selecciona la localidad</option>
                                                                <!-- Aquí debes agregar las opciones de localidades -->
                                                            </select>
                                                        </div>
                                                    </div>
                                                    {{-- DIRECCION --}}
                                                    <div class="col-lg-3">
                                                        <div class="mb-3">
                                                            <label for="idDireccion" class="form-label">Dirección *</label>
                                                            <input type="text" class="form-control" id="idDireccion"
                                                                name="direccionEvento"
                                                                placeholder="Introduce la dirección del evento" required>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="row">
                                                    {{-- FOTO EVENTO --}}
                                                    <div class="col-lg-4">
                                                        <div class="form-group mb-3">
                                                            <label for="idEventoImagen" class="form-label">Imagen del
                                                                evento</label>
                                                            <input name="eventoImagen" class="form-control"
                                                                type="file" id="idEventoImagen"
                                                                onChange="mainThamUrl(this)">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg">
                                                        <div class="col-sm-10">
                                                            <img id="mainThmb" class="border rounded avatar-lg"
                                                                src="{{ !empty($editData->profile_image) ? url('frontend/img/eventos/' . $editData->profile_image) : url('frontend/img/eventos/imagenDefecto/porDefectoEvento.jpg') }}"
                                                                alt="Card image cap">
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="mb-3">
                                                    {{-- DESCRICPCION DEL EVENTO --}}
                                                    <label for="eventDescription" class="form-label">Descripción del
                                                        evento *</label>
                                                    <textarea class="form-control" id="eventDescription" name="eventDescription" rows="4"
                                                        placeholder="Describe el evento"></textarea>
                                                </div>

                                            </div>

                                            <div class="mt-3">
                                                <span>Campos obligatorios (*)</span>
                                            </div>
                                            {{-- <div class="row button-row"> --}}
                                            <div class="d-flex justify-content-end mt-3">
                                                <button class="btn btn-primary" type="button"
                                                    onClick="validate(this)" id="btnSigDatosBasicos" disabled>Siguiente</button>
                                            </div>
                                        </section>


                                        {{-- COMIENZA TICKETS SECCION 2 --}}

                                        <section class="display-none">
                                            <div class="tab-pane" id="company-document">
                                                <h3 class="text-center mb-4">Tickets</h3>
                                                <div>
                                                    {{-- BOTÓN SWITCH --}}
                                                    <div class="row mb-3">
                                                        <div class="col-lg-3">
                                                            <div>
                                                                <div class="square-switch">
                                                                    <span class="align-top me-1 fs-3">Evento pago: </span>
                                                                    <input type="checkbox" id="square-switch3"
                                                                        switch="bool" checked />
                                                                    <label for="square-switch3" class="align-bottom"
                                                                        data-on-label="Si" data-off-label="No"></label>
                                                                </div>
                                                                {{-- <div class="form-check form-switch mb-3">
                                                                    <input class="form-check-input" type="checkbox" id="freeTicketsCheckbox">          
                                                                    <label class="form-check-label"
                                                                    for="freeTicketsCheckbox">¿Evento gratuito?</label>
                                                                </div> --}}
                                                            </div>
                                                        </div>

                                                        <div class="col-lg">
                                                            <p class="fs-3">Total de tickets: <span class="totalCantidad">0</span></p>
                                                        </div>

                                                    </div>
                                                    {{-- datos a completar del ticket --}}
                                                    <!-- Contenedor para las entradas -->
                                                    <div id="ticketsContainer" class="mb-3">
                                                        <!-- Primera entrada por defecto -->
                                                        <div class="ticket-field-set mb-3" id="ticket-1">
                                                            <div class="row g-3 align-items-end">
                                                                <div class="col-md-2">
                                                                    <label for="ticketType_1" class="form-label">Tipo de Ticket *</label>
                                                                    <select class="form-select item-select ticket-select" id="ticketType_1" name="ticketType[]">
                                                                        <option value="" selected>Seleccione el tipo de ticket</option>
                                                                        @foreach ($catTickets as $catTicket)
                                                                            <option value="{{ $catTicket->idCatTicket }}">
                                                                                {{ $catTicket->nombreCatTicket }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <label for="ticketPrice_1"
                                                                    class="form-label">Precio *</label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                                                       
                                                                       <input type="number" class="form-control text-end"
                                                                        id="ticketPrice_1" name="ticketPrice[]"
                                                                        placeholder="Ej. 100" min="0"
                                                                        step="0.01">
                                                                    </div>
                                                                    
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <label for="ticketQuantity_1"
                                                                        class="form-label">Cantidad *
                                                                        </label>
                                                                    <input type="number" class="form-control text-end"
                                                                        id="ticketQuantity_1" name="ticketQuantity[]"
                                                                        placeholder="Ej. 50" min="0" required>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label for="ticketDescripcion_1"
                                                                        class="form-label">Descripción *</label>
                                                                    <textarea class="form-control" name="ticketDescription[]" id="ticketDescripcion_1" rows="1"
                                                                        placeholder="Agrega una descripción"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <!-- Botón para agregar más campos de tickets -->
                                                        <div class="d-grid gap-2">
                                                            <button type="button" class="btn btn-outline-primary"
                                                                id="agregarTicket">Agregar Otro Ticket</button>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="mt-3">
                                                <span>Campos obligatorios (*)</span>
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
                                                                        Inicio *</label>
                                                                    <input type="datetime-local" class="form-control"
                                                                        id="fecha_inicio_tanda_1"
                                                                        name="fecha_inicio_tanda[]" min="{{ $fechaHoraActual }}">
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <label for="fecha_fin_tanda_1"
                                                                        class="form-label">Fecha de
                                                                        Fin *</label>
                                                                    <input type="datetime-local" class="form-control"
                                                                        id="fecha_fin_tanda_1" name="fecha_fin_tanda[]" min="{{ $fechaHoraActual }}">
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label for="cupo_tanda_1"
                                                                        class="form-label">Cupo/tickets *</label>
                                                                    <input type="number" class="form-control ticket-input text-end"
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

                                            <div class="mt-3">
                                                <span>Campos obligatorios (*)</span>
                                            </div>
                                            <div class="d-flex justify-content-end mt-3">
                                                <button class="btn btn-primary me-2" type="button"
                                                    onClick="showPrevious(this)">Anterior</button>
                                                <button class="btn btn-primary" type="button" id="nextButton" 
                                                    onClick="validate(this)" disabled>Siguiente</button>
                                            </div>
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
                                                                <p class="text-muted">Cree el evento para guardarlo</p>
                                                                <button type="submit" class="btn btn-success btn-lg"
                                                                    id="crearEvento">Crear
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
<!--  JS PARA CREAR EVENTO -->
<script src="{{ asset('backend/js/crearEvento.js') }}"></script>

<script>

$(document).ready(function() {

    // Configurar el token CSRF para todas las solicitudes AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#formEvento').on('submit', function(event) {
        event.preventDefault(); // Evitar el envío normal del formulario
        $('#crearEvento').prop('disabled', true); // Desactivar el botón

        var formData = new FormData(this); // Obtener los datos del formulario, incluyendo la imagen

        $.ajax({
            url: "{{ route('guardarEvento') }}",
            type: 'POST',
            data: formData,
            processData: false, // Importante para evitar que jQuery procese los datos
            contentType: false, // Importante para permitir el envío de archivos
            success: function(response) {
                // Mostrar SweetAlert con la respuesta
                //$('#crearEvento').prop('disabled', false); // Reactivar el botón
                Swal.fire({
                    title: 'Éxito',
                    text: response.message,
                    icon: 'success',
                    confirmButtonColor: "#0f9cf3",
                    confirmButtonText: 'Aceptar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#crearEvento').prop('disabled', false); // Reactivar el botón
                        window.location.href = "{{ route('admin.eventos') }}";
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


/*============================================
    PAISES,  PROVINCIAS Y LOCALIDADES
==============================================*/

$(document).ready(function() {

    const $selectPaises = $("#selectPaises");
    const $selectProvincias = $("#selectProvincias");
    const $selectLocalidades = $("#selectLocalidades");

    function provincia(paisId) {

        $.ajax({
            url: "{{ url('/crearEvento/provincias/') }}/" + paisId,
            method: "GET",
            success: function(json) {
                let $options = `<option value="">Selecciona la provincia</option>`;

                json.provincias.forEach(function(el) {
                    $options += `<option value="${el.id}">${el.name}</option>`;
                });

                $selectProvincias.html($options);
            },
            error: function(jqXHR) {
                let message = jqXHR.statusText || "Ocurrió un error";
                $selectProvincias.next().html(`Error: ${jqXHR.status}: ${message}`);
            }
        });
    }

    function localidad(provinciaId) {
        $.ajax({
            url: "{{ url('/crearEvento/localidades/') }}/" + provinciaId,
            method: "GET",
            success: function(json) {
                let $options = `<option value="">Selecciona la localidad</option>`;

                json.localidades.forEach(function(el) {
                    $options += `<option value="${el.id}">${el.name}</option>`;
                });

                $selectLocalidades.html($options);
            },
            error: function(jqXHR) {
                let message = jqXHR.statusText || "Ocurrió un error";
                $selectLocalidades.next().html(`Error: ${jqXHR.status}: ${message}`);
            }
        });
    }

    $selectPaises.change(function() {
        provincia($(this).val());
        $selectProvincias.html('<option value="">Selecciona la provincia</option>');
        $selectLocalidades.html('<option value="">Selecciona la localidad</option>');
        //console.log($(this).val());
    });

    $selectProvincias.change(function() {
        localidad($(this).val());
        //console.log($(this).val());
    });

}); // fin paises y localidades

/*=============================================
CODIGO PARA LOS TICKETS
==============================================*/
var esGratis = false;

document.addEventListener("DOMContentLoaded", function() {
    
    let ticketCount = 1; // Inicialmente hay una entrada
    let inputCount = 0;
    const maxInputs = {{ $catTicketsCantidad }};//window.catTicketsCantidad;

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
    function disableFreeOption() {
        document.querySelectorAll('.item-select option').forEach(function(option) {
            if (option.text.trim() === 'Gratis') {
                option.disabled = true; // Desactivar opción "Gratuito"
            }
        });
    }

    // Función para desactivar opción "Gratuito"
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
        disableFreeOption(); // Desactivar opción gratuita después de eliminar
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
                    <input type="number" class="form-control text-end" id="ticketPrice_${ticketCount}" name="ticketPrice[]"
                    placeholder="Ej. 100" min="0" step="0.01">
                </div>
            </div>
            <div class="col-md-2">
                <label for="ticketQuantity_${ticketCount}" class="form-label">Cantidad *</label>
                <input type="number" class="form-control text-end" id="ticketQuantity_${ticketCount}" name="ticketQuantity[]"
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
            disableFreeOption();
        });

        // Deshabilitar el botón si se llegó al límite de tickets
        if (inputCount >= maxInputs-2) {// se descuenta gratuito y el que ya existe por defecto
            document.getElementById("agregarTicket").disabled = true;
        } 

        loadSelects();
        disableFreeOption();

    });// fin click agregar ticket

    /*========================
       BOTÓN SWITCH PAGO
    ========================*/

    document.getElementById('square-switch3').addEventListener('change', function() {
        var agregarTicket = document.getElementById('agregarTicket');
        var agregarTanda = document.getElementById('agregarTanda');
        
        if (this.checked) {//opcion de pago 
            disableFreeOption(); // Asegurar que la opción gratuita esté desactivada
            agregarTicket.disabled = false;
            agregarTanda.disabled = false;//habilita boton de agregar tanda
            toggleFreeTicket(false);
            esGratis = false;
            //checkDistribution();// comprueba distribucion de tickets en tanda/s   
        } else {//opcion gratuita
            toggleFreeTicket(true);//bloquea opciones en los selects
            agregarTicket.disabled = true;
            agregarTanda.disabled = true;//deshabilita boton de agregar más tandas
            clearAllTicketsExceptFirst(); // Eliminar todos los tickets excepto el primero
            enableFreeOption();//habilita opcion gratuita 
            clearAllTandasExceptFirst();//eliminar tandas de más, si fueron creadas y se volvio
            esGratis = true;
        }
    });

    // Escuchar cambios en los selects para actualizar la lista de opciones disponibles
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('ticket-select')) {
            loadSelects(); // Actualizar los selects cuando se selecciona un valor
            disableFreeOption();
        }
    });

    loadSelects();
    disableFreeOption();
});// fin creacion tickets
</script>

@endsection
