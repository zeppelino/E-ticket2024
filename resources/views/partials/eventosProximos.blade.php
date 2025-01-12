<div class="row">
    @if (isset($eventosProximos) && $eventosProximos->isNotEmpty())
        @foreach ($eventosProximos as $evento)
            <div class="col-md-4 mb-4">
                <div class="card border-0 position-relative h-100 nosalir">
                    {{-- Span de la fecha --}}
                    <span class="d-inline-flex badge bg-primary position-absolute top-0 ms-2 mt-2 start-0">
                        {{ \Carbon\Carbon::parse($evento->fechaRealizacion)->format('d M Y') }}
                    </span>
                    {{-- Span del beneficio --}}
                    @if ($evento->beneficios->isNotEmpty())
                        @php
                        $beneficio = $evento->beneficios->first();
                        $fechaFinBeneficio = \Carbon\Carbon::parse($beneficio->fechaFinBeneficio)->format('d M Y');
                        @endphp
                        <span class="d-inline-flex badge bg-warning position-absolute top-0 end-0 me-2 mt-2">
                            Descuento del {{ $evento->beneficios->first()->porcentaje }}% hasta
                            {{ \Carbon\Carbon::parse($evento->beneficios->first()->fechaFinBeneficio)->format('d M Y') }}
                        </span>
                    @endif
                    {{-- Span del estado del evento --}}
                    @if ($evento->estadoEvento == 'suspendido' || $evento->estadoEvento == 'agotado')
                        <span class="d-inline-flex badge bg-danger diagonal">
                           {{ Str::upper( $evento->estadoEvento) }}
                        </span>
                    @endif
                    {{-- imagen con sus datos --}}
                    <img src="{{ $evento->urlImagen }}" class="animated-image card-img-top img-fluid fixed-size-image"
                        alt="Evento">
                        <div class="card-body">
                            <h5 class="card-title fw-semibold">{{ $evento->nombreEvento }}</h5>
                            <p class="card-text">
                                <span class="fw-light fw-bold">Categoría:</span>
                                {{ $evento->categoria->nombreCategoria }}<br>
                                <span class="fw-light fw-bold">Ubicación:</span> {{ $evento->ubicacion->ciudad }},
                                {{ $evento->ubicacion->direccion }}
                            </p>
                            <a href="{{ route('unEvento', ['idEvento' => $evento->idEvento]) }}"
                                class="btn btn-primary">Ver Evento</a>
                        </div>
                </div>
            </div>
        @endforeach
    @else
        <p>No hay eventos próximos disponibles en este momento.</p>
    @endif
</div>

<!-- Links de paginación -->
<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        {{ $eventosProximos->appends(['page_eventosProximos' => request('page_eventosProximos')])->links('pagination::bootstrap-4') }}
    </ul>
</nav>

{{-- <div class="row">
    @if (isset($eventosProximos) && $eventosProximos->isNotEmpty())
        @foreach ($eventosProximos as $evento)
            <div class="col-md-4 mb-4"> <!-- mb-4 para espaciar las tarjetas -->
                <div class="card border-0 position-relative h-100">
                    <span class="d-inline-flex badge bg-primary position-absolute top-0 ms-2 mt-2 start-0">
                        {{ \Carbon\Carbon::parse($evento->fechaRealizacion)->format('d M Y') }}
                    </span>
                    @if ($evento->beneficios->isNotEmpty())
                        @php
                            $beneficio = $evento->beneficios->first();
                            $fechaFinBeneficio = \Carbon\Carbon::parse($beneficio->fechaFinBeneficio)->format('d M Y');
                        @endphp
                        <span class="d-inline-flex badge bg-warning position-absolute top-0 end-0 me-2 mt-2">
                            Descuento del {{ $beneficio->porcentaje }}% hasta {{ $fechaFinBeneficio }}
                        </span>
                    @endif
                    <img src="{{ $evento->urlImagen }}" class="animated-image card-img-top img-fluid fixed-size-image"
                        alt="..." />
                    <div class="card-body">
                        <h5 class="card-title fw-semibold">{{ $evento->nombreEvento }}</h5>
                        <p class="card-text">
                            <span class="fw-light fw-bold">Categoría:</span>
                            {{ $evento->categoria->nombreCategoria }}<br>
                            <span class="fw-light fw-bold">Ubicación:</span> {{ $evento->ubicacion->ciudad }},
                            {{ $evento->ubicacion->direccion }}
                        </p>
                        <a href="{{ route('unEvento', ['idEvento' => $evento->idEvento]) }}"
                            class="btn btn-primary">Ver Evento</a>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <p>No hay eventos próximos disponibles en este momento.</p>
    @endif
</div>
 --}}