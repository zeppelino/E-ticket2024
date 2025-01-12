@extends('layouts.header')

@section('style')
    <link href="{{ asset('assets/css/welcomeStyle.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <!-- CARRUSEL -->
    <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <!-- Carrusel estático (puedes dinamizar si es necesario) -->
            <div class="carousel-item active">
                <img src="{{ asset('frontend/img/slider-10.jpg') }}" class="d-block" alt="..." />
            </div>
            <div class="carousel-item">
                <img src="{{ asset('frontend/img/slider-2.jpg') }}" class="d-block" alt="..." />
            </div>
            <div class="carousel-item">
                <img src="{{ asset('frontend/img/slider-1.jpg') }}" class="d-block" alt="..." />
            </div>
            <div class="carousel-item">
                <img src="{{ asset('frontend/img/slider-11.jpg') }}" class="d-block" alt="..." />
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
        <div class="fixed-text">E-Ticket Eventos</div>
    </div>

    <!-- BUSCADOR -->
    <div class="container mt-5">
        <form id="buscadorForm" method="GET" action="{{ route('welcome') }}">
            <!-- Contenedor estilizado -->
            <div class="d-flex align-items-center p-2 shadow-sm border rounded-pill"
                style="background-color: #f1f3f5; border-color: #f1f3f5;">
                {{-- Lupa --}}
                <span class="ms-2">
                    <i class="fas fa-search" style="color: #6c757d; font-size: 24px;"></i>
                    {{-- class="ri-search-line" --}}
                </span>

                <input type="text" name="query" id="searchQuery" class="form-control border-0 ms-3"
                    placeholder="Ingrese las primeras letras del evento"
                    style="border-radius: 20px; background-color: #f1f3f5;" maxlength="15">
            </div>
        </form>
    </div>

    <!-- RESULTADOS DE BÚSQUEDA -->
    <div class="container mt-4">
        <div class="search-results">
            @include('partials.eventos_resultados', ['eventos' => isset($eventos) ? $eventos : []])
        </div>
    </div>

    <!-- TITULO Próximos Eventos -->
    <div class="container">
        <div class="row mt-4">
            <h1>Próximos Eventos</h1>
        </div>
    </div>

    <!-- TARJETAS de eventos Próximos en cuadrícula -->
    <div class="container mt-4" id="eventosProximosContainer">

        @include('partials.eventosProximos')
  
    </div>

    <!-- TITULO Eventos Finalizados -->
    <div class="container">
        <div class="row mt-5">
            <h1>Eventos finalizados</h1>
        </div>
    </div>

    <!-- TARJETAS de Eventos Finalizados -->
    <div class="container mt-5" id="eventosTerminadosContainer">

        @include('partials.eventosTerminados')
  
    </div>

    {{--  <script src="{{ asset('backend/js/welcome.js') }}"></script> --}}

    <script>

        /* ======================
        LOGICA PARA PAGINADO
        ======================== */

        document.addEventListener('click', function (e) {
            // Verifica si el clic fue en un enlace de paginación
            const pageLink = e.target.closest('.pagination .page-link');
            if (pageLink) {
                e.preventDefault();
                const url = pageLink.getAttribute('href');

                // Solo procede si hay una URL
                if (url) {
                    fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        // Determina si el enlace de paginación pertenece a eventos próximos o eventos terminados
                        if (pageLink.closest('#eventosProximosContainer')) {
                            document.getElementById('eventosProximosContainer').innerHTML = html;
                        } else if (pageLink.closest('#eventosTerminadosContainer')) {
                            document.getElementById('eventosTerminadosContainer').innerHTML = html;
                        }
                    })
                    .catch(error => {
                        console.error('Error en la carga AJAX:', error);
                    });
                }
            }
        });



        document.addEventListener('DOMContentLoaded', function() {
            const searchQuery = document.getElementById('searchQuery');
            const searchResults = document.querySelector('.search-results');
            let debounceTimeout;

            // Función para realizar la búsqueda
            function buscarEventos() {
                const query = searchQuery.value.trim();

                // Si el campo de texto está vacío, limpiar resultados
                if (query === '') {
                    searchResults.innerHTML = ''; // Limpiar resultados
                    console.log("Campo de búsqueda vacío.");
                    return; // Salir de la función
                }

                console.log("Realizando búsqueda con query:", query);

                // Realizar la petición AJAX para obtener los eventos filtrados
                //fetch(`/buscar-eventos?query=${query}`, {
                fetch(`{{ url('/buscar-eventos') }}?query=${query}`, {
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
                        // Verificar respuesta del servidor
                        if (data.message) {
                            searchResults.innerHTML = `<p>${data.message}</p>`;
                        } else {
                            const titulo = data.titulo || 'Resultados'; // Usar título o valor por defecto
                            searchResults.innerHTML = `<h2>${titulo}</h2>` + data.html;
                        }
                        console.log("Datos recibidos:", data);
                    })
                    .catch(error => {
                        console.error('Error al cargar los eventos:', error);
                        searchResults.innerHTML =
                            `<p>Ocurrió un error al buscar eventos. Intenta nuevamente.</p>`;
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
        });
    </script>
@endsection

<!-- FOOTER-->
