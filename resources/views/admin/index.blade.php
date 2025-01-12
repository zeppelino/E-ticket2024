@extends('admin.adminMaster')

@section('style')
    <link href="{{ asset('assets/css/indexStyle.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('admin')
    <div class="page-content">
        <div class="container-fluid">
            @auth
                @if (auth()->user()->hasRole('Admin'))
                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">Panel</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Inicio</a></li>
                                        <li class="breadcrumb-item active">Panel</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-truncate font-size-14 mb-2">Total Ingresos</p>
                                            {{-- {{ $ingresosYEntradas->total_ingresos }}  --}}
                                            <h4 class="mb-2" id="ingresosTotales"></h4>
                                        </div>
                                        <div class="avatar-sm">
                                            <span class="avatar-title bg-light text-primary rounded-3">
                                                <i class="mdi mdi-currency-usd font-size-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div><!-- end cardbody -->
                            </div><!-- end card -->
                        </div><!-- end col -->
                        <div class="col-xl-3 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-truncate font-size-14 mb-2">Entradas Vendidas</p>
                                            <h4 class="mb-2 text-center">{{ $ingresosYEntradas->total_entradas_vendidas }}</h4>
                                        </div>
                                        <div class="avatar-sm">
                                            <span class="avatar-title bg-light text-success rounded-3">
                                                <i class="ri-coupon-3-line font-size-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div><!-- end cardbody -->
                            </div><!-- end card -->
                        </div><!-- end col -->
                        <div class="col-xl-3 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-truncate font-size-14 mb-2">Eventos Próximos</p>
                                            <h4 class="mb-2 text-center">{{ $eventosProximos }}</h4>
                                        </div>
                                        <div class="avatar-sm">
                                            <span class="avatar-title bg-light text-primary rounded-3">
                                                <i class="ri-calendar-2-line font-size-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div><!-- end cardbody -->
                            </div><!-- end card -->
                        </div><!-- end col -->
                        <div class="col-xl-3 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-truncate font-size-14 mb-2">Eventos Activos</p>
                                            <h4 class="mb-2 text-center">{{ $eventosActivos }}</h4>
                                        </div>
                                        <div class="avatar-sm">
                                            <span class="avatar-title bg-light text-success rounded-3">
                                                <i class="ri-thumb-up-line font-size-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div><!-- end cardbody -->
                            </div><!-- end card -->
                        </div><!-- end col -->
                    </div><!-- end row -->

                    <!-- TABLA DE RANKING Y GRAFICO -->
                    <div class="row">
                        <!-- Columna para el ranking de usuarios -->
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="container">
                                    <h4 class="card-title mb-4 mt-4"style="font-weight: bold;">Ranking de los 5 Usuarios con Más Entradas Compradas</h4>
                                    <table class="table table-bordered table-striped">
                                        <thead class="table-info">
                                            <tr>
                                                <th>#</th>
                                                <th>Nombre</th>
                                                <th>Email</th>
                                                <th>Cantidad de Entradas Compradas</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @if ($rankingUsuarios->isEmpty())
                                                <!-- Mostrar mensaje si no hay datos -->
                                                <tr>
                                                    <td colspan="4" class="text-center">
                                                        No hay información.
                                                    </td>
                                                </tr>
                                            @else
                                                <!-- Mostrar datos si existen -->
                                                @foreach ($rankingUsuarios as $index => $usuario)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $usuario->name }}</td>
                                                        <td>{{ $usuario->email }}</td>
                                                        <td class="text-center">{{ $usuario->total_entradas }}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                        <!-- end col -->

                        <!-- Gráfico de Dona - Eventos con entradas más vendidas -->
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body pb-4">
                                    <div id="chart"></div> 
                                    <!-- Aquí aparecerá el mensaje si no hay datos -->
                                    <p id="no-data-message" class="text-center" style="display: none;">No hay datos disponibles</p>
                                </div>
                            </div><!-- end card -->
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->

                    <!-- EMPIEZA LA PAGINA DEL CLIENTE -->
                {{-- @elseif (auth()->user()->hasRole('Cliente'))
                     <!-- sI HAY DATOS MUESTRO LOS EVENTOS SI NO DOY LA BIENVENIDA -->
                    @if (isset($eventosRelacionados) && $eventosRelacionados->isNotEmpty())
                        <!-- BUSCADOR -->
                        <div class="container mt-3">
                            <form id="buscadorForm"
                                class="d-flex justify-content-between align-items-center p-3 border rounded shadow-sm"
                                style="background-color: #f1f3f5;" method="GET" action="{{ route('dashboard') }}">

                                <select name="categoria" class="form-select me-2 border-primary w-100"
                                    style="border-radius: 20px;">
                                    <option value="0">Seleccione una categoría</option>
                                    @foreach ($categorias as $categoria)
                                        <option value="{{ $categoria->idCategoria }}">{{ $categoria->nombreCategoria }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="text" name="query" id="searchQuery"
                                    class="form-control me-2 border-primary w-100"
                                    placeholder="Ingrese las primeras letras del evento" style="border-radius: 20px;"
                                    maxlength="15">

                            </form>
                        </div>

                        <!-- RESULTADOS DE BÚSQUEDA -->
                        <div class="container mt-4">
                            <div class="search-results">
                                @include('partials.eventos_resultadosCliente', [
                                    'eventos' => isset($eventos) ? $eventos : [],
                                ])

                            </div>
                        </div>

                        <div class="container mt-5">
                            <div class="row">
                                @if ($eventosRelacionados != null)
                                    <h1 class="ms-1">Eventos que te pueden interesar</h1>
                                    <div class="row">
                                        @foreach ($eventosRelacionados as $evento)
                                            <div class="col-md-4 mb-4">
                                                <div class="card shadow-sm" style="max-width: 300px; height: auto;">
                                                    <img src="{{ $evento->urlImagen }}" alt="Imagen del evento"
                                                        class="card-img-top" style="height: 150px; object-fit: cover;">
                                                    <div class="card-body">
                                                        <h5 class="card-title" style="font-size: 1rem;">
                                                            {{ $evento->nombreEvento }}
                                                        </h5>
                                                        <p class="card-text text-muted" style="font-size: 0.875rem;">
                                                            Categoría: {{ $evento->categoria->nombreCategoria }}
                                                        </p>
                                                        <p class="card-text text-muted" style="font-size: 0.875rem;">
                                                            {{ \Carbon\Carbon::parse($evento->fechaRealizacion)->format('d M Y') }}
                                                        </p>
                                                        <p class="card-text" style="font-size: 0.875rem;">
                                                            <strong>Ubicación:</strong> {{ $evento->ubicacion->ciudad }},
                                                            {{ $evento->ubicacion->direccion }}
                                                        </p>
                                                        <a href="{{ route('unEvento', ['idEvento' => $evento->idEvento]) }}"
                                                            class="btn btn-primary btn-sm">Ver Evento</a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                                <!-- Enlaces de paginación -->
                                <div class="d-flex justify-content-center mt-4">
                                    {{ $eventosRelacionados->links('pagination::bootstrap-4', ['class' => 'pagination pagination-sm']) }}
                                </div>
                            </div>
                        </div>


                        <!-- Carrusel de Eventos Más Populares -->
                        <div class="container mt-5">
                            <div class="row">
                                @if ($eventosPopulares != null)
                                    <h1 class="ms-1">Eventos Más Populares</h1>
                                    <div class="row">
                                        @foreach ($eventosPopulares as $evento)
                                            <div class="col-md-4 mb-2"> <!-- Se mantiene un espaciado vertical -->
                                                <div class="card shadow-sm" style="max-width: 300px; height: auto;">
                                                    <img src="{{ $evento->urlImagen }}" alt="Imagen del evento"
                                                        class="card-img-top" style="height: 150px; object-fit: cover;">
                                                    <div class="card-body">
                                                        <h5 class="card-title" style="font-size: 1rem;">
                                                            {{ $evento->nombreEvento }}
                                                        </h5>
                                                        <p class="card-text text-muted" style="font-size: 0.875rem;">
                                                            Categoría: {{ $evento->categoria->nombreCategoria }}
                                                        </p>
                                                        <p class="card-text text-muted" style="font-size: 0.875rem;">
                                                            {{ \Carbon\Carbon::parse($evento->fechaRealizacion)->format('d M Y') }}
                                                        </p>
                                                        <p class="card-text" style="font-size: 0.875rem;">
                                                            <strong>Ubicación:</strong> {{ $evento->ubicacion->ciudad }},
                                                            {{ $evento->ubicacion->direccion }}
                                                        </p>
                                                        <a href="{{ route('unEvento', ['idEvento' => $evento->idEvento]) }}"
                                                            class="btn btn-primary btn-sm">Ver Evento</a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif


                                <!-- Enlaces de paginación -->
                                <div class="d-flex justify-content-center mt-4">
                                    {{ $eventosPopulares->links('pagination::bootstrap-4', ['class' => 'pagination pagination-sm']) }}
                                </div>
                            </div>
                        </div>
 --}}
                        {{-- CAMINO CUANDO NO HAY EVENTOS TODAVIA --}}
                    @else
                        <div class="container text-center mt-5">
                            <div class="card shadow-lg">
                                <div class="card-body p-5">
                                    <!-- Encabezado de bienvenida -->
                                    <h1 class="display-4 fw-bold text-primary">¡Bienvenido a la Plataforma de Eventos!</h1>
                                    <p class="lead mt-3 mb-5">Aquí encontrarás eventos futuros en los que podrás participar y
                                        disfrutar de grandes experiencias.</p>

                                    <!-- Descripción de la plataforma -->
                                    <p class="fs-5 text-muted">Explora y descubre los próximos eventos disponibles en tu área.
                                        Desde conferencias hasta conciertos, nuestra plataforma te conecta con las mejores
                                        actividades.</p>

                                    <!-- Mensaje motivador -->
                                    <blockquote class="blockquote mt-4">
                                        <p class="mb-0 fst-italic">"La vida está llena de momentos para celebrar. ¡Aprovecha y
                                            participa en los eventos que te esperan!"</p>
                                    </blockquote>

                                    <!-- Botón para explorar eventos -->
                                    {{-- <a href="/eventos" class="btn btn-primary btn-lg mt-4">Ver Próximos Eventos</a> --}}
                                </div>
                            </div>
                        </div>
                    @endif
                {{-- @endif --}}

                {{-- continua el else de si hay eventos cargados , si no hay muestra esta bienvenida --}}

            @endauth
        </div>

    </div>


    <!-- End Page-content -->
@endsection

@section('scripts')
    @auth
        @if (auth()->user()->hasRole('Admin'))

            <script>
                // Aplica formato al número con jQuery Number y agrega el símbolo de peso
                $(document).ready(function() {
                    var ingresosTotales = {{ $ingresosYEntradas->total_ingresos ?? 0 }};
                    $('#ingresosTotales').text($.number(ingresosTotales, 2)).prepend('$ ');
                });
            </script>

            {{-- =================================
            Inicialización de Gráfico de Dona
            ================================== --}}
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    
                    var eventNames = @json($eventNames);
                    var ticketCounts = @json($ticketCounts);

                    // Verifica si no hay datos
                    if (ticketCounts.length === 0) {
                        document.getElementById('no-data-message').style.display = 'block';  // Muestra el mensaje
                        return;  // Detiene la ejecución del gráfico
                    }

                    // Calcula el total de entradas vendidas
                    var totalEntradas = ticketCounts.reduce((acc, curr) => acc + curr, 0);

                    var options = {
                        series: ticketCounts, // Número de entradas vendidas
                        chart: {
                            type: 'donut',
                            height: 350
                        },
                        labels: eventNames, // Nombres de los eventos
                        responsive: [{
                            breakpoint: 480,
                            options: {
                                chart: {
                                    width: 300
                                },
                                legend: {
                                    position: 'bottom'
                                }
                            }
                        }],
                        title: {
                            text: 'Los 5 Eventos con Más Entradas Vendidas',
                            align: 'left',
                            style: {
                                fontFamily: 'Inter,Arial,sans-serif', // Cambia 'Arial' por la fuente que desees
                                fontSize: '15px', // Ajusta el tamaño de la fuente
                                fontWeight: 'bold', // Ajusta el grosor de la fuente (opcional)
                            }
                        },
                        plotOptions: {
                            pie: {
                                donut: {
                                    labels: {
                                        show: true,
                                        total: {
                                            show: true,
                                            label: 'Total Entradas',
                                            fontSize: '16px',
                                            fontWeight: 600,
                                            color: '#333', // Color del texto
                                            formatter: function() {
                                                return totalEntradas; // Muestra el total en el centro
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    };

                    var chart = new ApexCharts(document.querySelector("#chart"), options);
                    chart.render();
                });
            </script>
        @endif
    @endauth

    @auth
        @if (auth()->user()->hasRole('Cliente'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const searchQuery = document.getElementById('searchQuery');
                    const categorySelect = document.querySelector('select[name="categoria"]');
                    const searchResults = document.querySelector('.search-results');
                    let debounceTimeout;

                    // Función para realizar la búsqueda
                    function buscarEventos() {
                        const query = searchQuery.value.trim();
                        const categoria = categorySelect.value;

                        // Si la categoría es 0, no mostrar nada
                        if (categoria === '0') {
                            searchResults.innerHTML = ''; // Limpiar resultados
                            return; // Salir de la función
                        }

                        // Obtener la URL base desde Laravel
                        const baseUrl = "{{ url('/buscar-eventos2') }}"; // Esto está bien en una vista Blade

                        // Verificar si query y categoria tienen valores válidos
                        const queryParam = query ? encodeURIComponent(query) : '';
                        const categoriaParam = categoria ? encodeURIComponent(categoria) : '';

                        // Construir la URL completa usando template literals
                        const url = `${baseUrl}?query=${queryParam}&categoria=${categoriaParam}`;

                        fetch(url, {
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
                            })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Error en la respuesta del servidor');
                                }
                                return response.json();
                            })
                            .then(data => {
                                // Si el servidor devuelve un mensaje de no encontrado
                                if (data.message) {
                                    searchResults.innerHTML = `<p>${data.message}</p>`;
                                } else {
                                    const titulo = data.titulo; // Obtener el título de la respuesta
                                    searchResults.innerHTML = `<h2>${titulo}</h2>` + data.html;
                                }
                            })
                            .catch(error => {
                                console.error('Error al cargar los eventos:', error);
                                searchResults.innerHTML =
                                    `<p>No se encontraron Eventos.</p>`;
                            });
                    }

                    // Función para aplicar el debounce (evita llamadas excesivas)
                    function debounce(func, delay) {
                        clearTimeout(debounceTimeout);
                        debounceTimeout = setTimeout(func, delay);
                    }

                    // Agregar evento de entrada al input
                    searchQuery.addEventListener('input', function() {
                        debounce(buscarEventos, 300); // Llamar a la función de búsqueda con un retardo de 300 ms
                    });

                    // Evento change en el select
                    categorySelect.addEventListener('change', function() {
                        buscarEventos(); // Llamar a la función de búsqueda inmediatamente al cambiar la categoría
                    });
                });
            </script>
        @endif
    @endauth

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
                        // Aquí se olvida la sesión en el servidor                 
                        window.location.reload();
                    });
                }
            });
        </script>
    @endif
@endsection
