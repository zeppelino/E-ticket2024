@extends('admin.adminMaster')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4>Administrar Eventos</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                                <li class="breadcrumb-item active">Eventos</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="box-header with-border mb-4">
                                <a href="{{ route('admin.crearEvento') }}">
                                    <button class="btn btn-primary">
                                        Crear Evento
                                    </button>
                                </a>
                            </div>

                            <table id="dataTableEvento" class="table table-bordered table-striped dt-responsive nowrap"
                                width="100%">
                                <thead class="table-info">
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Ubicación</th>
                                        <th style="width: 70px;">Estado</th>
                                        <th>Categoria</th>
                                        <th style="width: 70px;">Fecha</th>
                                        <th style="width: 120px;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Si esta seteada la variable evento entre y muestra la tabla sino muestra que no hay eventos disponibles --}}
                                    @if (isset($eventos) && $eventos->isNotEmpty())
                                        @foreach ($eventos as $evento)
                                            <tr>
                                                <td>{{ $evento->nombreEvento }}</td>
                                                <td>{{ $evento->ubicacion->direccion ?? 'N/A' }}</td>
                                                <td>
                                                    <span id="estadoEvento_{{ $evento->idEvento }}"
                                                        class="badge 
                                                 {{ $evento->estadoEvento == 'disponible' ? 'bg-success' : '' }}
                                                 {{ $evento->estadoEvento == 'pendiente' ? 'bg-warning' : '' }}
                                                 {{ $evento->estadoEvento == 'cancelado' ? 'bg-danger' : '' }}
                                                 {{ $evento->estadoEvento == 'suspendido' ? 'bg-info' : '' }}
                                                 {{ $evento->estadoEvento == 'terminado' ? 'bg-secondary' : '' }}
                                                 {{ $evento->estadoEvento == 'reprogramado' ? 'bg-dark' : '' }}
                                                 {{ $evento->estadoEvento == 'agotado' ? 'bg-pink' : '' }}
                                                 rounded-pill 
                                                 p-2">
                                                        {{ $evento->estadoEvento }}
                                                    </span>
                                                </td>
                                                <td>{{ $evento->categoria->nombreCategoria ?? 'N/A' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($evento->fechaRealizacion)->format('d/m/Y') }}
                                                </td>
                                                <td>


                                                    <div class="btn-group">

                                                        <!-- Botón para ver detalles del evento -->
                                                        <a href="{{ route('admin.detalleEvento', ['id' => $evento->idEvento]) }}"
                                                            class="btn btn-secondary btn-sm d-inline-flex align-items-center">
                                                            <i class="ri-eye-line"></i>
                                                        </a>

                                                        {{-- aca estaba lo comentado abajo --}}
                                                        @php
                                                            $estado = $evento->estadoEvento; // Estado del evento
                                                            $dropdownDisabled =
                                                                $estado == 'disponible' ||
                                                                $estado == 'cancelado' ||
                                                                $estado == 'terminado' ||
                                                                $estado == 'reprogramado';
                                                            $reprogramarDisabled = $estado != 'suspendido';
                                                            $cambiarEstadoDisabled =
                                                                $estado == 'cancelado' ||
                                                                $estado == 'terminado' ||
                                                                $estado == 'reprogramado';
                                                            
                                                            $beneficioDisabled =
                                                                $estado == 'cancelado' ||
                                                                $estado == 'terminado' ||
                                                                $estado == 'reprogramado' ||
                                                                $estado == 'agotado';
                                                        @endphp

                                                              <!-- boton para editar -->
                                                        <div class="btn-group">
                                                            <button id="dropdownButton_{{ $evento->idEvento }}" class="btn btn-primary btn-sm dropdown-toggle"
                                                                type="button" data-bs-toggle="dropdown"
                                                                aria-expanded="false"
                                                                @if ($dropdownDisabled) disabled @endif>
                                                                <i class="ri-pencil-line"></i> Editar
                                                                <i class="ri-arrow-down-s-line"></i>
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                <li>
                                                                    <a class="dropdown-item boton-modificar"
                                                                        href="{{ route('admin.editarEvento', ['id' => $evento->idEvento]) }}"
                                                                        data-id="{{ $evento->idEvento }}"
                                                                        @if ($estado === 'suspendido') disabled @endif>
                                                                        Modificar Evento
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item boton-reprogramar @if ($reprogramarDisabled) disabled @endif"
                                                                        data-id="{{ $evento->idEvento }}"
                                                                        href="{{ $reprogramarDisabled ? '#' : route('admin.reprogramarEvento', ['idEventoSuspendido' => $evento->idEvento]) }}"
                                                                        data-href="{{ route('admin.reprogramarEvento', ['idEventoSuspendido' => $evento->idEvento]) }}">
                                                                        Reprogramar
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>

                                                        <!-- Botón para cambiar estado -->
                                                        <button type="button" class="btn btn-warning btn-sm"
                                                            data-bs-toggle="modal" data-bs-target="#modalEstado"
                                                            data-id="{{ $evento->idEvento }}"
                                                            @if ($cambiarEstadoDisabled) disabled @endif
                                                            data-estado="{{ $evento->estadoEvento }}">
                                                            Cambiar Estado
                                                        </button>

                                                        <!-- Botón para gestionar beneficios -->

                                                        <button type="button" class="btn btn-info btn-sm"
                                                            data-bs-toggle="modal" data-bs-target="#modalDescuento"
                                                            data-id="{{ $evento->idEvento }}"
                                                            @if (
                                                                $beneficioDisabled ||
                                                                    ($evento->tipoTickets->first() && $evento->tipoTickets->first()->categoriaTicket->nombreCatTicket == 'Gratis')) disabled @endif>
                                                            Beneficio
                                                        </button>

                                                    </div>

                                                </td>
                                            </tr>
                                        @endforeach
                                        {{-- termina la carga de la tabla  aca muestra que no hay eventos dispobibles --}}
                                    @endif


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->

            <!-- Modal Estado del Evento -->
            {{-- <div class="modal fade" id="modalEstado" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="miModalLabel">Cambiar Estado del Evento</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Selecciona el nuevo estado del evento:</p>
                            <select id="nuevoEstado" class="form-select">
                                @if (isset($eventos) && $eventos->isNotEmpty())
                                    @if ($evento->estadoEvento == 'pendiente')
                                        <option value="suspendido">Suspendido</option>
                                        <option value="cancelado">Cancelado</option>
                                    @elseif($evento->estadoEvento == 'disponible')
                                        <option value="suspendido">Suspendido</option>
                                        <option value="cancelado">Cancelado</option>
                                    @elseif($evento->estadoEvento == 'agotado')
                                        <option value="suspendido">Suspendido</option>
                                        <option value="cancelado">Cancelado</option>
                                    @elseif($evento->estadoEvento == 'suspendido')
                                        <option value="disponible">Disponible</option> --}} {{--  suspendido no habilita eso lo hace el reprogramar --}}
           {{--                              <option value="cancelado">Cancelado</option>
                                    @endif
                                @endif
                            </select>
                            <input type="hidden" id="idEventoModal">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary" id="guardarCambios">Guardar Cambios</button>
                        </div>
                    </div>
                </div>
            </div> --}}

            <!-- Modal Estado del Evento -->
            <div class="modal fade" id="modalEstado" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="miModalLabel">Cambiar Estado del Evento</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Selecciona el nuevo estado del evento:</p>
                            <select id="nuevoEstado" class="form-select">
                                <!-- Las opciones serán cargadas dinámicamente con JavaScript -->
                            </select>
                            <input type="hidden" id="idEventoModal">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary" id="guardarCambios">Guardar Cambios</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Benficio -->
            <div class="modal fade" id="modalDescuento" tabindex="-1" aria-labelledby="modalDescuentoLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalDescuentoLabel">Datos de la Oferta</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <form id="formDescuento">
                                <!-- Campo oculto para almacenar el ID del evento -->
                                <input type="hidden" id="idEvento" name="idEvento">

                                <div class="mb-3">
                                    <label for="fechaDesde" class="form-label">Fecha de Inicio del beneficio</label>
                                    <input type="date" class="form-control" id="fechaDesde"
                                        min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"required>
                                </div>
                                <div class="mb-3">
                                    <label for="fechaHasta" class="form-label">Fecha de Fin del beneficio</label>
                                    <input type="date" class="form-control" id="fechaHasta"
                                        min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="porcentajeDescuento" class="form-label">Porcentaje de Descuento</label>
                                    <input type="number" class="form-control" id="porcentajeDescuento" min="0"
                                        max="100" required>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-danger" id="eliminarDescuento" style="display:none;">
                                <span>&#128465;</span> Eliminar Descuento
                            </button>
                            <button type="button" class="btn btn-primary" id="guardarDescuento">Guardar
                                Descuento</button>
                        </div>
                    </div>
                </div>
            </div>{{-- fin modal de beneficio --}}
        </div>
    </div>



    <!-- Modal de Mensaje de Éxito -->
    {{--  <div class="modal fade" id="modalMensajeExito" tabindex="-1" aria-labelledby="miModalMensajeLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="miModalMensajeLabel">Éxito</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="mensajeExito" class="lead text-center">Estado del evento actualizado correctamente.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div> --}}

    @if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const successMessage = "{{ session('success') }}";
            if (successMessage) {
                Swal.fire({
                    title: "Éxito",
                    text: successMessage,
                    icon: "success",
                    confirmButtonColor: "#0f9cf3",
                    confirmButtonText: "Cerrar"
                }).then(() => {
                   /*  @php
                    session()->forget('success'); // Eliminar el mensaje después de mostrarlo (no funcionaba)
                    @endphp */
                    window.location.href = "{{ route('admin.eventos') }}";
                });
            }
        });
    </script>
    @endif
@endsection

@section('scripts')
    
    <script>
    /*=====================
    MODAL CAMBIAR ESTADO
    =====================*/

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $(document).ready(function() {
         

            // Evento para guardar cambios
            $('#guardarCambios').on('click', function() {
                var idEvento = $('#idEventoModal').val(); // Obtener el id del evento
                var nuevoEstado = $('#nuevoEstado').val(); // Obtener el estado seleccionado

                $('#guardarCambios').prop('disabled', true); // Desactivar el botón

                // Enviar la solicitud AJAX
                $.ajax({
                    url: "{{ url('/eventos/cambiar-estado/') }}/" + idEvento,
                    method: 'POST',
                    data: {
                     _token: $('meta[name="csrf-token"]').attr('content'),
                     estadoEvento: nuevoEstado
                    },
                    success: function(response) {
                        $('#modalEstado').modal('hide');

                        var botonEstado = $('button[data-id="' + idEvento + '"]');
                        botonEstado.attr('data-estado',
                        nuevoEstado); // Actualiza el estado del botón

                        $('#guardarCambios').prop('disabled', false); // Activar el botón

                        var estadoSpan = $('#estadoEvento_' + idEvento);
                        estadoSpan.text(nuevoEstado);

                        // Remover las clases antiguas y añadir la nueva
                        estadoSpan
                            .removeClass(
                                'bg-success bg-warning bg-danger bg-info bg-secondary bg-dark bg-pink'
                                )
                            .addClass(getBadgeClass(nuevoEstado));
                        // Deshabilitar el botón si el estado cumple con las condiciones
                        if (['cancelado', 'terminado', 'reprogramado'].includes(nuevoEstado)) {
                            $('button[data-id="' + idEvento + '"]').prop('disabled', true);
                        } else {
                            $('button[data-id="' + idEvento + '"]').prop('disabled', false);
                        }

                        // Cambiar el estado de los botones dentro del dropdown según el nuevo estado
                        // Seleccionamos los botones por clase en lugar de por ID
                        var botonModificar = $('.boton-modificar[data-id="' + idEvento + '"]');
                        var botonReprogramar = $('.boton-reprogramar[data-id="' + idEvento + '"]');
               
                        var dropdownButton = $('#dropdownButton_' + idEvento); // Selecciona el botón específico por ID

                        if (nuevoEstado === 'suspendido') {
                            dropdownButton.removeAttr('disabled');
                            // Si el evento está suspendido, habilitar la opción de "Modificar" y "Reprogramar"
                           // Habilitar "Modificar" y "Reprogramar" quitando la clase y el atributo
                            botonModificar.prop('disabled', false).removeClass('disabled');
                            
                            botonReprogramar.prop('disabled', false).removeClass('disabled');
                            botonReprogramar.attr('href', botonReprogramar.data('href')); // Establece el `href` con el valor de `data-href`
                        
                        } else {
                            // Deshabilitar el botón del dropdown
                            dropdownButton.attr('disabled', 'disabled');
                            // Deshabilitar "Modificar" y "Reprogramar" agregando la clase y el atributo
                            botonModificar.prop('disabled', true).addClass('disabled');
                            botonReprogramar.prop('disabled', true).addClass('disabled');
                        }

                        // Mostrar SweetAlert
                        Swal.fire({
                            title: '¡Éxito!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        });
          

                    },
                    error: function(xhr) {
                        // Mostrar el mensaje de error y la respuesta del servidor
                        var errorMessage = 'Ocurrió un error al cambiar el estado.';

                        // Si el servidor devuelve un mensaje de error
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage += '\n' + xhr.responseJSON.message;
                        }

                        // Mostrar SweetAlert de error
                        Swal.fire({
                            title: 'Error',
                            text: errorMessage,
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });

                        $('#guardarCambios').prop('disabled',false); // Reactivar el botón en caso de error
                    }
                });
            });

        });

        // Función para obtener la clase CSS basada en el estado
        function getBadgeClass(estado) {
            switch (estado) {
                case 'disponible':
                    return 'bg-success';
                case 'pendiente':
                    return 'bg-warning';
                case 'cancelado':
                    return 'bg-danger';
                case 'suspendido':
                    return 'bg-info';
                case 'terminado':
                    return 'bg-secondary';
                case 'reprogramado':
                    return 'bg-dark';
                case 'agotado':
                    return 'bg-pink';
                default:
                    return '';
            }
        }

         // logica de ventana modal de cambiar estado

         $('#modalEstado').on('show.bs.modal', function(event) {
            // Obtener los datos del botón que abrió el modal
            var button = $(event.relatedTarget); // Botón que activó el modal
            var idEvento = button.data('id'); // Extrae el ID del evento
            var estadoEvento = button.attr('data-estado');
            //var estadoEvento = button.data('estado'); // Extrae el estado actual del evento

            //console.log("ID del evento: " + idEvento); // Verificar el ID
            //console.log("el estado en la ventana modal es: ", estadoEvento);
            // Establecer el ID del evento en un campo oculto
            $('#idEventoModal').val(idEvento);

            // Limpiar las opciones del select antes de añadir las nuevas
            var select = $('#nuevoEstado');
            select.empty(); // Vaciar las opciones existentes

            // Agregar las opciones del select basadas en el estado actual del evento
            if (estadoEvento === 'pendiente' || estadoEvento === 'disponible' || estadoEvento === 'agotado') {
                select.append('<option value="suspendido">Suspendido</option>');
                select.append('<option value="cancelado">Cancelado</option>');
            } else if (estadoEvento === 'suspendido') {
                select.append('<option value="disponible">Disponible</option>');
                select.append('<option value="cancelado">Cancelado</option>');
            }
        });


        /*==================
        MODAL BENEFICIO
        ===================*/

        $(document).ready(function() {
            // Abrir el modal y cargar los datos del beneficio
            $('button[data-bs-target="#modalDescuento"]').on('click', function() {

                var idEvento = $(this).data('id');

                if (!idEvento) {
                    console.error('El ID del evento no se está pasando al modal.');
                    return;
                }

                $('#idEvento').val(idEvento); // Asignar el idEvento al campo oculto

                // Hacer una solicitud para obtener los datos del beneficio
                $.ajax({
                    url: "{{ url('/eventos/') }}/" + idEvento + '/beneficio',
                    type: 'GET',
                    success: function(data) {
                        var fechaInicioBeneficio = data.beneficio ? data.beneficio
                            .fechaInicioBeneficio : null;
                        var fechaHabilitacionTanda = data.fechaHabilitacionTanda ?
                            formatDateToInput(data.fechaHabilitacionTanda) : null;
                        var fechaRealizacion = data.fechaRealizacion ? formatDateToInput(data.fechaRealizacion) : null;

                        // Lógica para establecer la fecha de inicio del beneficio o la fecha de habilitación de la tanda
                        if (fechaInicioBeneficio) {
                            $('#fechaDesde').val(formatDateToInput(fechaInicioBeneficio));
                        } else if (fechaHabilitacionTanda) {
                            $('#fechaDesde').val(fechaHabilitacionTanda);
                            $('#fechaDesde').attr('min', fechaHabilitacionTanda);
                        } else {
                            $('#fechaDesde').val(''); // Si no hay ninguna de las dos fechas
                        }

                        // Deja el atributo max con la fecha de realizacion del evento
                        $('#fechaHasta').attr('max', fechaRealizacion);

                        // Si existe beneficio, llenar el formulario
                        if (data.beneficio) {
                            $('#fechaHasta').val(formatDateToInput(data.beneficio
                                .fechaFinBeneficio));
                            $('#porcentajeDescuento').val(data.beneficio.porcentaje);

                            // Mostrar botón de eliminar
                            $('#eliminarDescuento').show();
                        } else {
                            // Si no hay beneficio, limpiar el formulario
                            $('#fechaHasta').val('');
                            $('#porcentajeDescuento').val('');

                            // Ocultar botón de eliminar
                            $('#eliminarDescuento').hide();
                        }
                    },
                    error: function() {
                        alert('Error al cargar los datos del beneficio.');
                    }
                });
            });

            /* ///////////////////////// */
            // Guardar o actualizar el beneficio
            $('#guardarDescuento').on('click', function() {
                var fechaInicio = $('#fechaDesde').val();
                var fechaFin = $('#fechaHasta').val();

                // Validar que la fecha de inicio no sea mayor a la fecha de fin
                if (new Date(fechaInicio) > new Date(fechaFin)) {
                    Swal.fire({
                        title: 'Error',
                        text: 'La fecha de inicio no puede ser mayor que la fecha de fin.',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                    return; // Detener el envío de la solicitud AJAX
                }

                var idEvento = $('#idEvento').val();
                var data = {
                    fechaInicioBeneficio: formatDateForDatabase(fechaInicio), // Convertir fecha antes de enviar
                    fechaFinBeneficio: formatDateForDatabase(fechaFin), // Convertir fecha antes de enviar
                    porcentaje: $('#porcentajeDescuento').val(),
                    _token: $('meta[name="csrf-token"]').attr('content') // Asegurarse de enviar el token CSRF
                };

                $.ajax({
                    url: "{{ url('/eventos/') }}/" + idEvento + '/beneficio',
                    type: 'POST',
                    data: data,
                    success: function(response) {
                        Swal.fire({
                            title: '¡Éxito!',
                            text: 'El beneficio se ha guardado correctamente.',
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#modalDescuento').modal('hide');
                                location.reload(); // Recargar la página al cerrar el SweetAlert*************************
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = xhr.status + ': ' + xhr.statusText + ' - ' + xhr.responseText;
                        Swal.fire({
                            title: 'Error',
                            text: 'Error al guardar el beneficio. Faltan datos',
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#guardarDescuento').show(); // Mantener botón de guardar visible
                            }
                        });
                    }
                });

                // oculta botones solo puede cerrar
                $('#guardarDescuento').hide();
            });
            /* ///////////////////////// */
            // Eliminar el beneficio
            $('#eliminarDescuento').on('click', function() {
                var idEvento = $('#idEvento').val();

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: '¿Estás seguro de que deseas eliminar el beneficio?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ url('/eventos/') }}/" + idEvento + '/beneficio',
                            type: 'DELETE',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                // SweetAlert de éxito
                                Swal.fire({
                                    title: '¡Eliminado!',
                                    text: 'El beneficio ha sido eliminado correctamente.',
                                    icon: 'success',
                                    confirmButtonText: 'Aceptar'
                                }).then(() => {
                                    // Ocultar botones al eliminar
                                    $('#eliminarDescuento').hide();
                                    $('#guardarDescuento').hide();
                                    // Recargar la página después de cerrar el SweetAlert
                                    location.reload();//*******************************************
                                });
                            },
                            error: function() {
                                // SweetAlert de error
                                Swal.fire({
                                    title: 'Error',
                                    text: 'Hubo un error al intentar eliminar el beneficio.',
                                    icon: 'error',
                                    confirmButtonText: 'Aceptar'
                                });
                            }
                        });
                    }
                });
            });

            $('#modalDescuento').on('hidden.bs.modal', function() {
                location.reload(); // Recargar la página cuando el modal se cierre**********************
            });
        });
    </script>

    <script src="{{ asset('backend/js/evento.js') }}"></script>
@endsection

{{-- 
                                                @if ($evento->estadoEvento == 'disponible')
                                                    <!-- Solo cambiar estado y beneficio , editar muteado-->
                                                    <div class="dropdown" >
                                                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false" disabled>
                                                            <i class="ri-pencil-line"></i> Editar
                                                            <i class="ri-arrow-down-s-line"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" href="#">Modificar Evento</a></li>
                                                        </ul>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" href="#">Reprogramar</a></li>
                                                        </ul>
                                                        
                                                    </div>
                                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEstado" data-id="{{ $evento->idEvento }}">
                                                        Cambiar Estado
                                                    </button>
                                                    <button type="button" class="btn btn-info btn-sm" data-id="{{ $evento->idEvento }}" data-bs-toggle="modal" data-bs-target="#modalDescuento">
                                                        Beneficio
                                                    </button>
                                                @elseif($evento->estadoEvento == 'pendiente')
                                                    <!-- Editar y modificar evento y beneficio -->
                                                    <div class="dropdown">
                                                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="ri-pencil-line"></i> Editar
                                                            <i class="ri-arrow-down-s-line"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" href="#">Modificar Evento</a></li>
                                                        </ul>
                                                        
                                                    </div>
                                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEstado" data-id="{{ $evento->idEvento }}">
                                                        Cambiar Estado
                                                    </button>
                                                    <button type="button" class="btn btn-info btn-sm" data-id="{{ $evento->idEvento }}" data-bs-toggle="modal" data-bs-target="#modalDescuento">
                                                        Beneficio
                                                    </button>
                                                @elseif($evento->estadoEvento == 'suspendido')
                                                    <!-- Editar para reprogramar, cambiar estado y beneficio -->
                                                    <div class="dropdown">
                                                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="ri-pencil-line"></i> Editar
                                                            <i class="ri-arrow-down-s-line"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" href="#">Reprogramar</a></li>
                                                        </ul>
                                                    </div>
                                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEstado" data-id="{{ $evento->idEvento }}">
                                                        Cambiar Estado
                                                    </button>
                                                    <button type="button" class="btn btn-info btn-sm" data-id="{{ $evento->idEvento }}" data-bs-toggle="modal" data-bs-target="#modalDescuento">
                                                        Beneficio
                                                    </button> --}}
